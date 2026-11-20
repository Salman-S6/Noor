<?php

namespace Tests\Feature;

use App\Models\AppFeature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AppFeatureTest extends TestCase
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

    public function test_api_app_features_returns_dictionary_and_list(): void
    {
        $response = $this->getJson('/api/app-features');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'features' => [
                'reports_summary' => ['key', 'name', 'is_enabled', 'action', 'message'],
                'overdue_debts' => ['key', 'name', 'is_enabled', 'action', 'message'],
                'customers_summary' => ['key', 'name', 'is_enabled', 'action', 'message'],
            ],
            'features_list',
        ]);

        $this->assertTrue($response->json('features.reports_summary.is_enabled'));
        $this->assertNull($response->json('features.reports_summary.message'));
    }

    public function test_api_app_features_reflects_disabled_status_and_custom_message(): void
    {
        $feature = AppFeature::findByKey('reports_summary');
        $this->assertNotNull($feature);

        $feature->update([
            'is_enabled' => false,
            'disabled_message' => 'قسم الإحصائيات قيد التطوير حالياً.',
        ]);

        $response = $this->getJson('/api/app-features');
        $response->assertStatus(200);

        $this->assertFalse($response->json('features.reports_summary.is_enabled'));
        $this->assertEquals('قسم الإحصائيات قيد التطوير حالياً.', $response->json('features.reports_summary.message'));
    }

    public function test_admin_features_page_requires_basic_auth(): void
    {
        $response = $this->get('/admin/features');
        $response->assertStatus(401);
        $response->assertHeader('WWW-Authenticate');
    }

    public function test_admin_can_view_features_page_with_valid_auth(): void
    {
        $response = $this->asAdmin()->get('/admin/features');

        $response->assertStatus(200);
        $response->assertSee('نظام التحكم بواجهات وميزات التطبيق');
        $response->assertSee('الإحصائيات والتقارير العامة');
        $response->assertSee('reports_summary');
    }

    public function test_admin_can_toggle_feature_status(): void
    {
        $feature = AppFeature::findByKey('reports_summary');
        $this->assertTrue($feature->is_enabled);

        // إيقاف الميزة
        $resToggleOff = $this->asAdmin()->patch("/admin/features/{$feature->id}/toggle");
        $resToggleOff->assertRedirect();
        $this->assertFalse($feature->fresh()->is_enabled);

        // إعادة تشغيل الميزة
        $resToggleOn = $this->asAdmin()->patch("/admin/features/{$feature->id}/toggle");
        $resToggleOn->assertRedirect();
        $this->assertTrue($feature->fresh()->is_enabled);
    }

    public function test_admin_can_update_feature_settings(): void
    {
        $feature = AppFeature::findByKey('overdue_debts');

        $payload = [
            'name' => 'الديون المتأخرة والزبائن المتعثرون',
            'action_type' => 'hide',
            'disabled_message' => 'تم تعطيل هذه الشاشة مؤقتاً بأمر الإدارة.',
            'description' => 'شرح محدث للواجهة.',
            'icon' => '🚨',
        ];

        $response = $this->asAdmin()->put("/admin/features/{$feature->id}", $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $fresh = $feature->fresh();
        $this->assertEquals('الديون المتأخرة والزبائن المتعثرون', $fresh->name);
        $this->assertEquals('hide', $fresh->action_type);
        $this->assertEquals('تم تعطيل هذه الشاشة مؤقتاً بأمر الإدارة.', $fresh->disabled_message);
        $this->assertEquals('🚨', $fresh->icon);
    }

    public function test_admin_can_create_new_custom_feature(): void
    {
        $payload = [
            'key' => 'pos_quick_sale',
            'name' => 'نقطة البيع السريع',
            'description' => 'واجهة المبيعات السريعة بالكاشير.',
            'icon' => '🛒',
            'action_type' => 'lock',
            'disabled_message' => 'نقطة البيع غير مفعلة في اشتراكك.',
        ];

        $response = $this->asAdmin()->post('/admin/features', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('app_features', [
            'key' => 'pos_quick_sale',
            'name' => 'نقطة البيع السريع',
            'is_enabled' => true,
        ]);
    }

    public function test_feature_middleware_blocks_api_when_feature_disabled(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // تعطيل ميزة كشف حساب الزبائن
        $feature = AppFeature::findByKey('customers_summary');
        $feature->update([
            'is_enabled' => false,
            'disabled_message' => 'كشف الزبائن قيد الصيانة السنوية.',
            'action_type' => 'lock',
        ]);

        $response = $this->getJson('/api/customers/summary');

        $response->assertStatus(403);
        $this->assertEquals('disabled', $response->json('status'));
        $this->assertEquals('customers_summary', $response->json('feature'));
        $this->assertEquals('كشف الزبائن قيد الصيانة السنوية.', $response->json('message'));
        $this->assertEquals('lock', $response->json('action'));
    }

    public function test_feature_middleware_allows_api_when_feature_enabled(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // التأكد من تفعيل الميزة
        $feature = AppFeature::findByKey('customers_summary');
        $feature->update([
            'is_enabled' => true,
        ]);

        $response = $this->getJson('/api/customers/summary');

        $response->assertStatus(200);
        $this->assertArrayHasKey('customers', $response->json());
    }
}
