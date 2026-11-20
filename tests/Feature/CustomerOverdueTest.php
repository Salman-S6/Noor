<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerOverdueTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2026-11-15 12:00:00'));

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        if ($this->name() !== 'test_requires_authentication') {
            Sanctum::actingAs($this->user);
        }
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_requires_authentication(): void
    {
        $response = $this->getJson('/api/customers/overdue?days=30');
        $response->assertStatus(401);
    }

    public function test_validation_fails_for_invalid_days(): void
    {
        $response = $this->getJson('/api/customers/overdue?days=45');

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['days']]);
    }

    public function test_validation_fails_for_missing_days(): void
    {
        $response = $this->getJson('/api/customers/overdue');

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['days']]);
    }

    public function test_overdue_with_and_without_payments(): void
    {
        // الزبون 1: لديه دفعة سابقة منذ 47 يوماً (2026-09-29) ورصيده 5400
        $customer1 = Customer::create([
            'first_name' => 'أبو أحمد',
            'last_name' => 'الحلبي',
            'phone' => '0999111222',
        ]);
        Invoice::create([
            'customer_id' => $customer1->id,
            'invoice_number' => '1001',
            'amount' => 7000,
            'date' => '2026-09-20',
        ]);
        Payment::create([
            'customer_id' => $customer1->id,
            'amount' => 1600,
            'date' => '2026-09-29',
        ]);

        // الزبون 2: لا يملك أي دفعة، أقدم فاتورة منذ 40 يوماً (2026-10-06) ورصيده 3000
        $customer2 = Customer::create([
            'first_name' => 'سعيد',
            'last_name' => 'الشامي',
            'phone' => '0999333444',
        ]);
        Invoice::create([
            'customer_id' => $customer2->id,
            'invoice_number' => '1002',
            'amount' => 3000,
            'date' => '2026-10-06',
        ]);

        // الزبون 3: مسدد بالكامل (balance = 0)
        $customer3 = Customer::create([
            'first_name' => 'محمد',
            'last_name' => 'سالم',
            'phone' => '0999555666',
        ]);
        Invoice::create([
            'customer_id' => $customer3->id,
            'invoice_number' => '1003',
            'amount' => 2000,
            'date' => '2026-09-01',
        ]);
        Payment::create([
            'customer_id' => $customer3->id,
            'amount' => 2000,
            'date' => '2026-09-02',
        ]);

        // الزبون 4: رصيد موجب لكن آخر دفعة حديثة (منذ 5 أيام: 2026-11-10) -> غير متأخر
        $customer4 = Customer::create([
            'first_name' => 'عمر',
            'last_name' => 'الخالد',
            'phone' => '0999777888',
        ]);
        Invoice::create([
            'customer_id' => $customer4->id,
            'invoice_number' => '1004',
            'amount' => 4000,
            'date' => '2026-10-01',
        ]);
        Payment::create([
            'customer_id' => $customer4->id,
            'amount' => 1000,
            'date' => '2026-11-10',
        ]);

        $response = $this->getJson('/api/customers/overdue?days=30');

        $response->assertStatus(200);

        $json = $response->json();

        $this->assertEquals(8400, $json['total_overdue']); // 5400 + 3000
        $this->assertEquals(2, $json['customers_count']);
        $this->assertCount(2, $json['customers']['data']);

        // ترتيب تنازلي حسب balance: الزبون 1 (5400) ثم الزبون 2 (3000)
        $firstItem = $json['customers']['data'][0];
        $this->assertEquals($customer1->id, $firstItem['customer']['id']);
        $this->assertEquals('أبو أحمد', $firstItem['customer']['first_name']);
        $this->assertEquals('0999111222', $firstItem['customer']['phone']);
        $this->assertEquals(5400, $firstItem['balance']);
        $this->assertEquals(47, $firstItem['days_overdue']);
        $this->assertEquals('2026-09-29', $firstItem['last_payment_date']);

        $secondItem = $json['customers']['data'][1];
        $this->assertEquals($customer2->id, $secondItem['customer']['id']);
        $this->assertEquals('سعيد', $secondItem['customer']['first_name']);
        $this->assertEquals('0999333444', $secondItem['customer']['phone']);
        $this->assertEquals(3000, $secondItem['balance']);
        $this->assertEquals(40, $secondItem['days_overdue']);
        $this->assertNull($secondItem['last_payment_date']);
    }

    public function test_pagination_and_total_overdue_across_pages(): void
    {
        // إنشاء 16 زبون متأخرين للتأكد من التقسيم 15 في الصفحة
        for ($i = 1; $i <= 16; $i++) {
            $customer = Customer::create([
                'first_name' => "زبون $i",
                'phone' => "09990000$i",
            ]);
            Invoice::create([
                'customer_id' => $customer->id,
                'invoice_number' => "INV-$i",
                'amount' => 100 * $i,
                'date' => '2026-09-01',
            ]);
        }

        // الصفحة 1
        $resPage1 = $this->getJson('/api/customers/overdue?days=30&page=1');

        $resPage1->assertStatus(200);
        $dataPage1 = $resPage1->json();

        $this->assertEquals(16, $dataPage1['customers_count']);
        // مجموع 100*(1+2+...+16) = 100 * (16*17/2) = 13600
        $this->assertEquals(13600, $dataPage1['total_overdue']);
        $this->assertEquals(1, $dataPage1['customers']['current_page']);
        $this->assertEquals(2, $dataPage1['customers']['last_page']);
        $this->assertCount(15, $dataPage1['customers']['data']);
        $this->assertNotNull($dataPage1['customers']['next_page_url']);

        // الصفحة 2
        $resPage2 = $this->getJson('/api/customers/overdue?days=30&page=2');

        $resPage2->assertStatus(200);
        $dataPage2 = $resPage2->json();

        $this->assertEquals(2, $dataPage2['customers']['current_page']);
        $this->assertCount(1, $dataPage2['customers']['data']);
        $this->assertNull($dataPage2['customers']['next_page_url']);
    }
}
