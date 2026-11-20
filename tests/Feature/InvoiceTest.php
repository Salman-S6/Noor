<?php

namespace Tests\Feature;

use App\Models\AppFeature;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->customer = Customer::create([
            'first_name' => 'خالد',
            'last_name' => 'العلي',
            'phone' => '0999888777',
        ]);

        Sanctum::actingAs($this->user);
    }

    public function test_can_create_invoice_without_items_classic_mode(): void
    {
        $response = $this->postJson('/api/invoices', [
            'customer_id' => $this->customer->id,
            'invoice_number' => '1001',
            'amount' => 50000,
            'date' => '2026-11-18',
            'notes' => 'فاتورة بدون تفاصيل',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('invoice_number', '1001');
        $response->assertJsonPath('amount', 50000);
        $response->assertJsonCount(0, 'items');

        $this->assertDatabaseHas('invoices', [
            'invoice_number' => '1001',
            'amount' => 50000,
        ]);
        $this->assertDatabaseCount('invoice_items', 0);
    }

    public function test_can_create_invoice_with_detailed_items(): void
    {
        $response = $this->postJson('/api/invoices', [
            'customer_id' => $this->customer->id,
            'invoice_number' => '1002',
            'amount' => 25000,
            'date' => '2026-11-18',
            'notes' => 'فاتورة بتفاصيل البنود',
            'items' => [
                [
                    'description' => 'زيت زيتون 1 لتر',
                    'quantity' => 2,
                    'unit_price' => 10000,
                    'total_price' => 20000,
                ],
                [
                    'description' => 'علبة شاي',
                    'quantity' => 1,
                    'unit_price' => 5000,
                    'total_price' => 5000,
                ],
            ],
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('invoice_number', '1002');
        $response->assertJsonCount(2, 'items');
        $response->assertJsonPath('items.0.description', 'زيت زيتون 1 لتر');
        $response->assertJsonPath('items.0.quantity', 2);
        $response->assertJsonPath('items.0.unit_price', 10000);
        $response->assertJsonPath('items.0.total_price', 20000);

        $this->assertDatabaseHas('invoices', [
            'invoice_number' => '1002',
            'amount' => 25000,
        ]);
        $this->assertDatabaseCount('invoice_items', 2);
        $this->assertDatabaseHas('invoice_items', [
            'description' => 'زيت زيتون 1 لتر',
            'quantity' => 2,
            'unit_price' => 10000,
            'total_price' => 20000,
        ]);
    }

    public function test_invoice_amount_is_calculated_automatically_if_omitted_when_items_present(): void
    {
        $response = $this->postJson('/api/invoices', [
            'customer_id' => $this->customer->id,
            'invoice_number' => '1003',
            'date' => '2026-11-18',
            'items' => [
                [
                    'description' => 'أرز بسمتي',
                    'quantity' => 3,
                    'unit_price' => 4000,
                    'total_price' => 12000,
                ],
                [
                    'description' => 'سكر 1 كغ',
                    'quantity' => 2,
                    'unit_price' => 3000,
                ],
            ],
        ]);

        $response->assertStatus(201);
        // 12000 + (2 * 3000) = 18000
        $response->assertJsonPath('amount', 18000);
        $this->assertDatabaseHas('invoices', [
            'invoice_number' => '1003',
            'amount' => 18000,
        ]);
    }

    public function test_can_view_single_invoice_with_items_and_customer(): void
    {
        $invoice = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_number' => '1004',
            'amount' => 15000,
            'date' => '2026-11-18',
        ]);

        $invoice->items()->create([
            'description' => 'بند تفصيلي',
            'quantity' => 3,
            'unit_price' => 5000,
            'total_price' => 15000,
        ]);

        // عبر مسار show/{id}
        $responseShow = $this->getJson("/api/invoices/show/{$invoice->id}");
        $responseShow->assertStatus(200);
        $responseShow->assertJsonPath('id', $invoice->id);
        $responseShow->assertJsonCount(1, 'items');
        $responseShow->assertJsonPath('customer.id', $this->customer->id);

        // عبر مسار details/{id}
        $responseDetails = $this->getJson("/api/invoices/details/{$invoice->id}");
        $responseDetails->assertStatus(200);
        $responseDetails->assertJsonPath('id', $invoice->id);
        $responseDetails->assertJsonCount(1, 'items');
    }

    public function test_can_get_customer_invoices_with_items_loaded(): void
    {
        $invoice = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_number' => '1005',
            'amount' => 8000,
            'date' => '2026-11-18',
        ]);

        $invoice->items()->create([
            'description' => 'مادة أ',
            'quantity' => 1,
            'unit_price' => 8000,
            'total_price' => 8000,
        ]);

        $response = $this->getJson("/api/invoices/{$this->customer->id}");
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonPath('0.items.0.description', 'مادة أ');
    }

    public function test_can_update_invoice_and_replace_items(): void
    {
        $invoice = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_number' => '1006',
            'amount' => 10000,
            'date' => '2026-11-18',
        ]);

        $invoice->items()->create([
            'description' => 'بند قديم',
            'quantity' => 1,
            'unit_price' => 10000,
            'total_price' => 10000,
        ]);

        $response = $this->putJson("/api/invoices/{$invoice->id}", [
            'amount' => 30000,
            'items' => [
                [
                    'description' => 'بند جديد 1',
                    'quantity' => 2,
                    'unit_price' => 10000,
                    'total_price' => 20000,
                ],
                [
                    'description' => 'بند جديد 2',
                    'quantity' => 1,
                    'unit_price' => 10000,
                    'total_price' => 10000,
                ],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('amount', 30000);
        $response->assertJsonCount(2, 'items');
        $this->assertDatabaseCount('invoice_items', 2);
        $this->assertDatabaseMissing('invoice_items', ['description' => 'بند قديم']);
        $this->assertDatabaseHas('invoice_items', ['description' => 'بند جديد 1']);
    }

    public function test_update_invoice_with_empty_items_array_deletes_all_items_and_makes_it_simple(): void
    {
        $invoice = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_number' => '1006B',
            'amount' => 25000,
            'date' => '2026-11-18',
        ]);

        $invoice->items()->create([
            'description' => 'بند تفصيلي',
            'quantity' => 2,
            'unit_price' => 12500,
            'total_price' => 25000,
        ]);

        $this->assertDatabaseCount('invoice_items', 1);

        // إرسال items = [] لحذف البنود وإبقاء الفاتورة بسيطة
        $response = $this->putJson("/api/invoices/{$invoice->id}", [
            'amount' => 25000,
            'items' => [],
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('amount', 25000);
        $response->assertJsonCount(0, 'items');
        $this->assertDatabaseCount('invoice_items', 0);
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'amount' => 25000,
        ]);
    }

    public function test_update_invoice_without_items_key_keeps_existing_items_untouched(): void
    {
        $invoice = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_number' => '1006C',
            'amount' => 15000,
            'date' => '2026-11-18',
            'notes' => 'ملاحظة قديمة',
        ]);

        $invoice->items()->create([
            'description' => 'بند محفوظ لا يجب حذفه',
            'quantity' => 3,
            'unit_price' => 5000,
            'total_price' => 15000,
        ]);

        // تعديل الملاحظات فقط دون إرسال حقل items
        $response = $this->putJson("/api/invoices/{$invoice->id}", [
            'notes' => 'ملاحظة محدثة',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('notes', 'ملاحظة محدثة');
        $response->assertJsonCount(1, 'items');
        $response->assertJsonPath('items.0.description', 'بند محفوظ لا يجب حذفه');
        $this->assertDatabaseCount('invoice_items', 1);
    }

    public function test_update_invoice_calculates_amount_automatically_if_omitted_when_items_present(): void
    {
        $invoice = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_number' => '1006D',
            'amount' => 5000,
            'date' => '2026-11-18',
        ]);

        // تحديث البنود بدون إرسال حقل amount
        $response = $this->putJson("/api/invoices/{$invoice->id}", [
            'items' => [
                [
                    'description' => 'بند جديد 1',
                    'quantity' => 2,
                    'unit_price' => 15000,
                    'total_price' => 30000,
                ],
                [
                    'description' => 'بند جديد 2',
                    'quantity' => 1,
                    'unit_price' => 10000,
                    'total_price' => 10000,
                ],
            ],
        ]);

        $response->assertStatus(200);
        // 30000 + 10000 = 40000
        $response->assertJsonPath('amount', 40000);
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'amount' => 40000,
        ]);
    }

    public function test_deleting_invoice_cascades_and_deletes_items(): void
    {
        $invoice = Invoice::create([
            'customer_id' => $this->customer->id,
            'invoice_number' => '1007',
            'amount' => 5000,
            'date' => '2026-11-18',
        ]);

        $invoice->items()->create([
            'description' => 'بند سيحذف',
            'quantity' => 1,
            'unit_price' => 5000,
            'total_price' => 5000,
        ]);

        $this->assertDatabaseCount('invoice_items', 1);

        $response = $this->deleteJson("/api/invoices/{$invoice->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
        $this->assertDatabaseCount('invoice_items', 0);
    }

    public function test_feature_flag_invoice_items_exists_in_api_features(): void
    {
        $response = $this->getJson('/api/app-features');
        $response->assertStatus(200);

        $this->assertTrue($response->json('features.invoice_items.is_enabled'));
        $this->assertEquals('تفاصيل وبنود الفواتير', $response->json('features.invoice_items.name'));
    }

    public function test_creating_or_updating_with_items_fails_with_403_when_feature_disabled(): void
    {
        $feature = AppFeature::findByKey('invoice_items');
        $this->assertNotNull($feature);

        // تعطيل ميزة بنود الفواتير
        $feature->update([
            'is_enabled' => false,
            'action_type' => 'lock',
            'disabled_message' => 'ميزة تفاصيل وبنود الفواتير معطلة حالياً لأعمال الصيانة.',
        ]);

        // 1. محاولة إنشاء فاتورة تحتوي على items يجب أن تُرفض بـ 403
        $resStoreWithItems = $this->postJson('/api/invoices', [
            'customer_id' => $this->customer->id,
            'invoice_number' => '2001',
            'amount' => 10000,
            'date' => '2026-11-18',
            'items' => [
                [
                    'description' => 'بند تجريبي',
                    'quantity' => 1,
                    'unit_price' => 10000,
                ],
            ],
        ]);

        $resStoreWithItems->assertStatus(403);
        $resStoreWithItems->assertJson([
            'status' => 'disabled',
            'feature' => 'invoice_items',
            'message' => 'ميزة تفاصيل وبنود الفواتير معطلة حالياً لأعمال الصيانة.',
            'action' => 'lock',
        ]);

        // 2. إنشاء فاتورة بدون items (كلاسيكية) يجب أن تنجح حتى لو الميزة معطلة!
        $resStoreClassic = $this->postJson('/api/invoices', [
            'customer_id' => $this->customer->id,
            'invoice_number' => '2002',
            'amount' => 10000,
            'date' => '2026-11-18',
        ]);
        $resStoreClassic->assertStatus(201);

        $createdInvoiceId = $resStoreClassic->json('id');

        // 3. محاولة تعديل الفاتورة مع إرسال items يجب أن تُرفض بـ 403
        $resUpdateWithItems = $this->putJson("/api/invoices/{$createdInvoiceId}", [
            'items' => [
                [
                    'description' => 'تعديل بند',
                    'quantity' => 1,
                    'unit_price' => 10000,
                ],
            ],
        ]);

        $resUpdateWithItems->assertStatus(403);
        $resUpdateWithItems->assertJson([
            'status' => 'disabled',
            'feature' => 'invoice_items',
            'message' => 'ميزة تفاصيل وبنود الفواتير معطلة حالياً لأعمال الصيانة.',
            'action' => 'lock',
        ]);

        // 4. تعديل الفاتورة الكلاسيكي (بدون items) يجب أن ينجح
        $resUpdateClassic = $this->putJson("/api/invoices/{$createdInvoiceId}", [
            'amount' => 12000,
            'notes' => 'تعديل المبلغ فقط',
        ]);
        $resUpdateClassic->assertStatus(200);
        $resUpdateClassic->assertJsonPath('amount', 12000);
    }
}
