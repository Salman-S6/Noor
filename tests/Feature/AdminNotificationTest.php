<?php

namespace Tests\Feature;

use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.admin_notifications.user' => 'admin',
            'services.admin_notifications.password' => 'noor_admin_2026',
        ]);
        putenv('ADMIN_NOTIFICATIONS_USER=admin');
        putenv('ADMIN_NOTIFICATIONS_PASSWORD=noor_admin_2026');
    }

    protected function asAdmin(): self
    {
        return $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('admin:noor_admin_2026'),
        ])->withServerVariables([
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'noor_admin_2026',
        ]);
    }

    public function test_unauthenticated_request_is_rejected_with_401(): void
    {
        $response = $this->get('/admin/notifications');
        $response->assertStatus(401);
        $response->assertHeader('WWW-Authenticate');
    }

    public function test_invalid_credentials_are_rejected_with_401(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('wrong_user:wrong_password'),
        ])->withServerVariables([
            'PHP_AUTH_USER' => 'wrong_user',
            'PHP_AUTH_PW' => 'wrong_password',
        ])->get('/admin/notifications');

        $response->assertStatus(401);
    }

    public function test_can_view_admin_notifications_page_with_valid_auth(): void
    {
        $response = $this->asAdmin()->get('/admin/notifications');
        $response->assertStatus(200);
        $response->assertSee('إدارة وتعميم الإشعارات');
        $response->assertSee('إصدار إشعار أو تعميم جديد');
    }

    public function test_can_create_app_update_notification_for_all(): void
    {
        $payload = [
            'target_type' => 'all',
            'type' => 'update',
            'title' => 'تحديث تطبيق نور v2.0',
            'body' => 'يرجى تنزيل التحديث الجديد للاستفادة من الميزات الجديدة وإصلاح الأخطاء.',
            'version' => '2.0.0',
            'link' => 'https://example.com/downloads/noor-v2.apk',
            'is_mandatory' => '1',
            'is_active' => '1',
        ];

        $response = $this->asAdmin()->post('/admin/notifications', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => null,
            'type' => 'update',
            'title' => 'تحديث تطبيق نور v2.0',
            'version' => '2.0.0',
            'link' => 'https://example.com/downloads/noor-v2.apk',
            'is_mandatory' => 1,
            'is_active' => 1,
        ]);
    }

    public function test_can_create_notification_for_specific_user(): void
    {
        $user = User::factory()->create();

        $payload = [
            'target_type' => 'specific',
            'user_id' => $user->id,
            'type' => 'discount',
            'title' => 'عرض خاص بك',
            'body' => 'خصم 15% على الاشتراك السنوي.',
            'is_active' => '1',
        ];

        $response = $this->asAdmin()->post('/admin/notifications', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $user->id,
            'type' => 'discount',
            'title' => 'عرض خاص بك',
        ]);
    }

    public function test_creation_validation_fails_for_empty_fields(): void
    {
        $response = $this->asAdmin()->post('/admin/notifications', []);
        $response->assertSessionHasErrors(['title', 'body', 'type', 'target_type']);
    }

    public function test_update_validation_fails_when_version_or_link_missing(): void
    {
        $payload = [
            'target_type' => 'all',
            'type' => 'update',
            'title' => 'تحديث ناقص',
            'body' => 'نص التحديث',
        ];

        $response = $this->asAdmin()->post('/admin/notifications', $payload);
        $response->assertSessionHasErrors(['version', 'link']);
    }

    public function test_update_validation_fails_for_invalid_version_format(): void
    {
        // تجربة صيغ غير مطابقة لـ x.y.z
        $invalidVersions = ['v2.1.0', '2.1', '2.1.0-beta', 'نسخة 2.0'];

        foreach ($invalidVersions as $invalidVersion) {
            $payload = [
                'target_type' => 'all',
                'type' => 'update',
                'title' => 'تحديث',
                'body' => 'نص',
                'version' => $invalidVersion,
                'link' => 'https://example.com/app.apk',
            ];

            $response = $this->asAdmin()->post('/admin/notifications', $payload);
            $response->assertSessionHasErrors(['version']);
        }
    }

    public function test_update_validation_fails_for_non_https_link(): void
    {
        $payload = [
            'target_type' => 'all',
            'type' => 'update',
            'title' => 'تحديث برابط غير آمن',
            'body' => 'نص',
            'version' => '1.0.1',
            'link' => 'http://example.com/app.apk',
        ];

        $response = $this->asAdmin()->post('/admin/notifications', $payload);
        $response->assertSessionHasErrors(['link']);
    }

    public function test_can_toggle_notification_status(): void
    {
        $notification = AppNotification::create([
            'type' => 'general',
            'title' => 'تنبيه صيانة',
            'body' => 'سيتم إجراء صيانة مجدولة الليلة.',
            'is_active' => true,
        ]);

        $response = $this->asAdmin()->patch("/admin/notifications/{$notification->id}/toggle");
        $response->assertRedirect();

        $this->assertFalse($notification->fresh()->is_active);

        // إعادة التفعيل
        $this->asAdmin()->patch("/admin/notifications/{$notification->id}/toggle");
        $this->assertTrue($notification->fresh()->is_active);
    }

    public function test_can_delete_notification(): void
    {
        $notification = AppNotification::create([
            'type' => 'general',
            'title' => 'إشعار للحذف',
            'body' => 'نص تجريبي.',
        ]);

        $response = $this->asAdmin()->delete("/admin/notifications/{$notification->id}");
        $response->assertRedirect();

        $this->assertDatabaseMissing('app_notifications', [
            'id' => $notification->id,
        ]);
    }
}
