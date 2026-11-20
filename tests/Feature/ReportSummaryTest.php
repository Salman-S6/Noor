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

class ReportSummaryTest extends TestCase
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
        $response = $this->getJson('/api/reports/summary?period=week');
        $response->assertStatus(401);
    }

    public function test_validation_fails_for_invalid_period(): void
    {
        $response = $this->getJson('/api/reports/summary?period=invalid');

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['period']]);
    }

    public function test_summary_week_structure_and_calculations(): void
    {
        $customer = Customer::create([
            'first_name' => 'أبو أحمد',
            'phone' => '0999123456',
        ]);

        // ضمن الفترة (آخر 7 أيام: 2026-11-09 إلى 2026-11-15)
        Invoice::create([
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-W1',
            'amount' => 1200,
            'date' => '2026-11-09',
        ]);
        Invoice::create([
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-W2',
            'amount' => 6600,
            'date' => '2026-11-15',
        ]);
        Payment::create([
            'customer_id' => $customer->id,
            'amount' => 600,
            'date' => '2026-11-09',
        ]);
        Payment::create([
            'customer_id' => $customer->id,
            'amount' => 3600,
            'date' => '2026-11-14',
        ]);

        // فترة سابقة (2026-11-02 إلى 2026-11-08)
        Invoice::create([
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-PREV',
            'amount' => 3000,
            'date' => '2026-11-05',
        ]);
        Payment::create([
            'customer_id' => $customer->id,
            'amount' => 1800,
            'date' => '2026-11-06',
        ]);

        $response = $this->getJson('/api/reports/summary?period=week');

        $response->assertStatus(200);
        $json = $response->json();

        $this->assertEquals('week', $json['period']);
        $this->assertEquals('2026-11-09', $json['from']);
        $this->assertEquals('2026-11-15', $json['to']);

        // total_receipts = 600 + 3600 = 4200
        $this->assertEquals(4200, $json['total_receipts']);
        // total_withdrawals = 1200 + 6600 = 7800
        $this->assertEquals(7800, $json['total_withdrawals']);
        // net = 4200 - 7800 = -3600
        $this->assertEquals(-3600, $json['net']);
        // previous_net = 1800 - 3000 = -1200
        $this->assertEquals(-1200, $json['previous_net']);
        // invoices_count = 2
        $this->assertEquals(2, $json['invoices_count']);

        // series = 7 عناصر بالضبط
        $this->assertCount(7, $json['series']);
        $this->assertEquals('2026-11-09', $json['series'][0]['date']);
        $this->assertEquals(600, $json['series'][0]['receipts']);
        $this->assertEquals(1200, $json['series'][0]['withdrawals']);

        $this->assertEquals('2026-11-10', $json['series'][1]['date']);
        $this->assertEquals(0, $json['series'][1]['receipts']);
        $this->assertEquals(0, $json['series'][1]['withdrawals']);

        $this->assertEquals('2026-11-15', $json['series'][6]['date']);
        $this->assertEquals(0, $json['series'][6]['receipts']);
        $this->assertEquals(6600, $json['series'][6]['withdrawals']);

        // top_debtors
        $this->assertCount(1, $json['top_debtors']);
        $this->assertEquals($customer->id, $json['top_debtors'][0]['customer']['id']);
        // balance = (1200+6600+3000) - (600+3600+1800) = 10800 - 6000 = 4800
        $this->assertEquals(4800, $json['top_debtors'][0]['balance']);
    }

    public function test_series_counts_for_all_periods(): void
    {
        // Month: 30 عناصر
        $resMonth = $this->getJson('/api/reports/summary?period=month');
        $resMonth->assertStatus(200);
        $this->assertCount(30, $resMonth->json('series'));
        $this->assertEquals('2026-10-17', $resMonth->json('from'));
        $this->assertEquals('2026-11-15', $resMonth->json('to'));

        // Quarter: ~13 أسبوعاً
        $resQuarter = $this->getJson('/api/reports/summary?period=quarter');
        $resQuarter->assertStatus(200);
        $this->assertCount(13, $resQuarter->json('series'));
        $this->assertEquals('2026-08-18', $resQuarter->json('from'));
        $this->assertEquals('2026-11-15', $resQuarter->json('to'));

        // Year: 12 شهراً date = YYYY-MM-01
        $resYear = $this->getJson('/api/reports/summary?period=year');
        $resYear->assertStatus(200);
        $seriesYear = $resYear->json('series');
        $this->assertCount(12, $seriesYear);
        $this->assertEquals('2025-12-01', $resYear->json('from'));
        $this->assertEquals('2026-11-15', $resYear->json('to'));
        $this->assertEquals('2025-12-01', $seriesYear[0]['date']);
        $this->assertEquals('2026-11-01', $seriesYear[11]['date']);
    }

    public function test_previous_net_is_null_when_no_prior_activity(): void
    {
        $customer = Customer::create([
            'first_name' => 'سامر',
            'phone' => '0999888777',
        ]);

        // فقط حركة ضمن الأسبوع الحالي
        Invoice::create([
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-ONLY-THIS-WEEK',
            'amount' => 1000,
            'date' => '2026-11-12',
        ]);

        $response = $this->getJson('/api/reports/summary?period=week');

        $response->assertStatus(200);
        $this->assertNull($response->json('previous_net'));
    }

    public function test_top_debtors_limits_to_five_and_excludes_zero_or_negative_balance(): void
    {
        for ($i = 1; $i <= 7; $i++) {
            $customer = Customer::create([
                'first_name' => "عميل $i",
                'phone' => "0999000$i",
            ]);
            // عملاء بمبالغ مختلفة
            Invoice::create([
                'customer_id' => $customer->id,
                'invoice_number' => "INV-DEBT-$i",
                'amount' => $i * 1000,
                'date' => '2026-11-10',
            ]);
        }

        // عميل رصيده 0
        $customerZero = Customer::create([
            'first_name' => 'عميل رصيد صفر',
            'phone' => '09990008',
        ]);
        Invoice::create([
            'customer_id' => $customerZero->id,
            'invoice_number' => 'INV-ZERO',
            'amount' => 500,
            'date' => '2026-11-10',
        ]);
        Payment::create([
            'customer_id' => $customerZero->id,
            'amount' => 500,
            'date' => '2026-11-10',
        ]);

        $response = $this->getJson('/api/reports/summary?period=week');

        $response->assertStatus(200);
        $topDebtors = $response->json('top_debtors');

        $this->assertCount(5, $topDebtors);
        // أعلى رصيد هو عميل 7 (7000)، ثم 6 (6000)
        $this->assertEquals(7000, $topDebtors[0]['balance']);
        $this->assertEquals(6000, $topDebtors[1]['balance']);
        $this->assertEquals(5000, $topDebtors[2]['balance']);
        $this->assertEquals(4000, $topDebtors[3]['balance']);
        $this->assertEquals(3000, $topDebtors[4]['balance']);
    }

    public function test_customer_first_name_supports_json_object(): void
    {
        $customer = Customer::create([
            'first_name' => json_encode(['ar' => 'أبو أحمد']),
            'phone' => '0999123456',
        ]);

        Invoice::create([
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-JSON',
            'amount' => 1500,
            'date' => '2026-11-10',
        ]);

        $response = $this->getJson('/api/reports/summary?period=week');

        $response->assertStatus(200);
        $topDebtor = $response->json('top_debtors.0');
        $this->assertEquals(['ar' => 'أبو أحمد'], $topDebtor['customer']['first_name']);
    }
}
