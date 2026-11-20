<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerSummaryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $apiKey = 'test-secret-key-123';

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.api_secret_key' => $this->apiKey]);

        $this->user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_summary_requires_authentication(): void
    {
        $response = $this->getJson('/api/customers/summary');
        $response->assertStatus(401);
    }

    public function test_summary_works_with_sanctum_bearer_token(): void
    {
        Sanctum::actingAs($this->user);

        $customer = Customer::create([
            'first_name' => 'ابو خالد ونوسة',
            'phone' => '0999111222',
        ]);

        Invoice::create([
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-01',
            'amount' => 1993.9,
            'date' => '2026-05-01',
        ]);

        Payment::create([
            'customer_id' => $customer->id,
            'amount' => 1366.8,
            'date' => '2026-05-10',
        ]);

        $response = $this->getJson('/api/customers/summary');

        $response->assertStatus(200);
        $json = $response->json();

        $this->assertArrayHasKey('customers', $json);
        $this->assertCount(1, $json['customers']);

        $c = $json['customers'][0];
        $this->assertEquals($customer->id, $c['id']);
        $this->assertEquals('ابو خالد ونوسة', $c['first_name']);
        $this->assertEquals('0999111222', $c['phone']);
        $this->assertEquals(1993.9, $c['total_invoices']);
        $this->assertEquals(1366.8, $c['total_payments']);
        $this->assertEquals(627.1, $c['balance']);

        // التحقق من أن القيم أرقام وليست نصوصاً
        $this->assertIsNumeric($c['total_invoices']);
        $this->assertIsNumeric($c['total_payments']);
        $this->assertIsNumeric($c['balance']);
    }

    public function test_summary_rejects_x_api_key_without_bearer_token(): void
    {
        $response = $this->withHeader('X-API-KEY', 'some-key')
            ->getJson('/api/customers/summary');

        $response->assertStatus(401);
    }

    public function test_summary_handles_negative_balance_and_zero_balance_customers(): void
    {
        Sanctum::actingAs($this->user);

        // زبون 1: دفع أكثر من فواتيره (رصيد سالب)
        $customerNegative = Customer::create([
            'first_name' => 'زبون دافع زيادة',
            'phone' => '0999111111',
        ]);
        Invoice::create([
            'customer_id' => $customerNegative->id,
            'invoice_number' => 'INV-NEG',
            'amount' => 500,
            'date' => '2026-05-01',
        ]);
        Payment::create([
            'customer_id' => $customerNegative->id,
            'amount' => 800,
            'date' => '2026-05-02',
        ]);

        // زبون 2: جديد لا يملك أي فواتير ولا دفعات
        $customerZero = Customer::create([
            'first_name' => 'زبون جديد بدون حركات',
            'phone' => '0999222222',
        ]);

        $response = $this->getJson('/api/customers/summary');

        $response->assertStatus(200);
        $customers = collect($response->json('customers'));

        $cNeg = $customers->firstWhere('id', $customerNegative->id);
        $this->assertEquals(500, $cNeg['total_invoices']);
        $this->assertEquals(800, $cNeg['total_payments']);
        $this->assertEquals(-300, $cNeg['balance']); // لم يتم تعديله لصفر

        $cZero = $customers->firstWhere('id', $customerZero->id);
        $this->assertEquals(0, $cZero['total_invoices']);
        $this->assertEquals(0, $cZero['total_payments']);
        $this->assertEquals(0, $cZero['balance']);
    }
}
