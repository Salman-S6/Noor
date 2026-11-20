<?php

namespace Tests\Feature;

use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_notifications_returns_only_active_items_and_unread_count(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        AppNotification::create([
            'type' => 'general',
            'title' => 'إشعار نشط',
            'body' => 'هذا إشعار نشط.',
            'is_active' => true,
        ]);

        AppNotification::create([
            'type' => 'general',
            'title' => 'إشعار معطل',
            'body' => 'هذا إشعار غير نشط.',
            'is_active' => false,
        ]);

        $response = $this->getJson('/api/notifications');

        $response->assertStatus(200);
        $data = $response->json('data.data');

        $this->assertCount(1, $data);
        $this->assertEquals('إشعار نشط', $data[0]['title']);
        $this->assertEquals(1, $response->json('unread_count'));
        $this->assertFalse($data[0]['is_read']);
    }

    public function test_time_ago_is_formatted_in_arabic(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $notification = AppNotification::create([
            'type' => 'general',
            'title' => 'إشعار مع وقت بالعربية',
            'body' => 'محتوى تجريبي',
            'is_active' => true,
        ]);
        $notification->timestamps = false;
        $notification->created_at = now()->subMinutes(5);
        $notification->save();

        $response = $this->getJson('/api/notifications');
        $response->assertStatus(200);

        $timeAgo = $response->json('data.data.0.time_ago');
        $this->assertStringContainsString('منذ', $timeAgo);
        $this->assertStringContainsString('دقائق', $timeAgo);
    }

    public function test_can_mark_single_notification_as_read(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $notification = AppNotification::create([
            'type' => 'alert',
            'title' => 'تنبيه أمان',
            'body' => 'يرجى مراجعة إعدادات الأمان.',
            'is_active' => true,
        ]);

        // قبل القراءة
        $resBefore = $this->getJson('/api/notifications');
        $this->assertEquals(1, $resBefore->json('unread_count'));

        // تحديد كمقروء
        $markRes = $this->postJson("/api/notifications/{$notification->id}/read");
        $markRes->assertStatus(200);
        $markRes->assertJsonFragment(['status' => 'success']);

        // بعد القراءة
        $resAfter = $this->getJson('/api/notifications');
        $this->assertEquals(0, $resAfter->json('unread_count'));
        $this->assertTrue($resAfter->json('data.data.0.is_read'));
        $this->assertNotNull($resAfter->json('data.data.0.read_at'));
    }

    public function test_can_mark_all_notifications_as_read(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        AppNotification::create([
            'type' => 'general',
            'title' => 'إشعار 1',
            'body' => 'نص 1',
            'is_active' => true,
        ]);

        AppNotification::create([
            'type' => 'discount',
            'title' => 'إشعار 2',
            'body' => 'خصم 20%',
            'is_active' => true,
        ]);

        $resBefore = $this->getJson('/api/notifications');
        $this->assertEquals(2, $resBefore->json('unread_count'));

        // تحديد الكل كمقروء
        $markAllRes = $this->postJson('/api/notifications/read-all');
        $markAllRes->assertStatus(200);

        $resAfter = $this->getJson('/api/notifications');
        $this->assertEquals(0, $resAfter->json('unread_count'));
    }

    public function test_specific_user_targeting(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // إشعار خاص بالمستخدم 1
        AppNotification::create([
            'user_id' => $user1->id,
            'type' => 'alert',
            'title' => 'رسالة خاصة للمستخدم الأول',
            'body' => 'فقط للمستخدم 1',
            'is_active' => true,
        ]);

        // إشعار عام للجميع
        AppNotification::create([
            'user_id' => null,
            'type' => 'general',
            'title' => 'رسالة عامة للجميع',
            'body' => 'للجميع',
            'is_active' => true,
        ]);

        // فحص المستخدم 1: يرى الإشعارين (العام والخاص به)
        Sanctum::actingAs($user1);
        $resUser1 = $this->getJson('/api/notifications');
        $this->assertCount(2, $resUser1->json('data.data'));

        // فحص المستخدم 2: يرى الإشعار العام فقط
        Sanctum::actingAs($user2);
        $resUser2 = $this->getJson('/api/notifications');
        $this->assertCount(1, $resUser2->json('data.data'));
        $this->assertEquals('رسالة عامة للجميع', $resUser2->json('data.data.0.title'));
    }

    public function test_get_latest_update_when_update_exists(): void
    {
        AppNotification::create([
            'type' => 'update',
            'title' => 'تحديث 1.1.0',
            'body' => 'إصلاحات طفيفة.',
            'version' => '1.1.0',
            'link' => 'https://example.com/v1.1.apk',
            'is_mandatory' => false,
            'is_active' => true,
            'created_at' => now()->subDays(2),
        ]);

        AppNotification::create([
            'type' => 'update',
            'title' => 'تحديث رئيسي 2.0.0',
            'body' => 'ميزات جديدة كلياً.',
            'version' => '2.0.0',
            'link' => 'https://example.com/v2.0.apk',
            'is_mandatory' => true,
            'is_active' => true,
            'created_at' => now(),
        ]);

        $response = $this->getJson('/api/notifications/latest-update');

        $response->assertStatus(200);
        $json = $response->json();

        $this->assertTrue($json['has_update']);
        $this->assertEquals('2.0.0', $json['update']['version']);
        $this->assertEquals('https://example.com/v2.0.apk', $json['update']['download_url']);
        $this->assertTrue($json['update']['is_mandatory']);
    }

    public function test_latest_update_picks_highest_semantic_version_not_latest_created(): void
    {
        // تم إنشاؤها اليوم ولكن برقم إصدار 2.9.0
        AppNotification::create([
            'type' => 'update',
            'title' => 'تحديث 2.9.0',
            'body' => 'إصدار سابق.',
            'version' => '2.9.0',
            'link' => 'https://example.com/v2.9.0.apk',
            'is_mandatory' => false,
            'is_active' => true,
            'created_at' => now(),
        ]);

        // تم إنشاؤها قبل أيام ولكن برقم إصدار أعلى 2.10.0
        AppNotification::create([
            'type' => 'update',
            'title' => 'تحديث 2.10.0',
            'body' => 'إصدار أعلى رقمياً.',
            'version' => '2.10.0',
            'link' => 'https://example.com/v2.10.0.apk',
            'is_mandatory' => true,
            'is_active' => true,
            'created_at' => now()->subDays(5),
        ]);

        $response = $this->getJson('/api/notifications/latest-update');

        $response->assertStatus(200);
        $json = $response->json();

        $this->assertTrue($json['has_update']);
        // يجب أن يرجع 2.10.0 لأنها أكبر من 2.9.0 رقمياً
        $this->assertEquals('2.10.0', $json['update']['version']);
    }

    public function test_latest_update_picks_latest_id_when_same_version(): void
    {
        AppNotification::create([
            'type' => 'update',
            'title' => 'نسخة أولى',
            'body' => 'تفاصيل 1.',
            'version' => '2.1.0',
            'link' => 'https://example.com/v2.1.0.apk',
            'is_active' => true,
        ]);

        AppNotification::create([
            'type' => 'update',
            'title' => 'نسخة معدلة',
            'body' => 'تفاصيل معدلة.',
            'version' => '2.1.0',
            'link' => 'https://example.com/v2.1.0-fixed.apk',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/notifications/latest-update');

        $response->assertStatus(200);
        $json = $response->json();

        $this->assertEquals('2.1.0', $json['update']['version']);
        $this->assertEquals('نسخة معدلة', $json['update']['title']);
        $this->assertEquals('https://example.com/v2.1.0-fixed.apk', $json['update']['download_url']);
    }

    public function test_latest_update_ignores_inactive_updates(): void
    {
        // إصدار عالي ولكن معطل
        AppNotification::create([
            'type' => 'update',
            'title' => 'تحديث ملغى',
            'body' => 'معطل.',
            'version' => '3.0.0',
            'link' => 'https://example.com/v3.0.apk',
            'is_active' => false,
        ]);

        // إصدار نشط
        AppNotification::create([
            'type' => 'update',
            'title' => 'تحديث نشط',
            'body' => 'نشط.',
            'version' => '1.0.0',
            'link' => 'https://example.com/v1.0.apk',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/notifications/latest-update');

        $response->assertStatus(200);
        $json = $response->json();

        $this->assertEquals('1.0.0', $json['update']['version']);
    }

    public function test_get_latest_update_when_no_update_exists(): void
    {
        $response = $this->getJson('/api/notifications/latest-update');

        $response->assertStatus(200);
        $this->assertFalse($response->json('has_update'));
        $this->assertNull($response->json('update'));
    }
}
