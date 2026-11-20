<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest\StoreInvoiceRequest;
use App\Http\Requests\InvoiceRequest\UpdateInvoiceRequest;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function getAllInvoicesForACustomer(Customer $customer)
    {
        return response()->json($customer->invoices()->with('items')->get(), 200);
    }

    public function show(Invoice $invoice)
    {
        return response()->json($invoice->load(['customer', 'items']), 200);
    }

    public function store(StoreInvoiceRequest $request)
    {
        $validated = $request->validated();
        $itemsData = $validated['items'] ?? null;
        unset($validated['items']);

        $invoice = DB::transaction(function () use ($validated, $itemsData) {
            $invoice = Invoice::create($validated);

            if (!empty($itemsData) && is_array($itemsData)) {
                $items = [];
                foreach ($itemsData as $item) {
                    $qty = (float) ($item['quantity'] ?? 1);
                    $price = (float) ($item['unit_price'] ?? 0);
                    $total = isset($item['total_price']) ? (float) $item['total_price'] : ($qty * $price);

                    $items[] = [
                        'description' => $item['description'],
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'total_price' => $total,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $invoice->items()->createMany($items);
            }

            return $invoice;
        });

        return response()->json($invoice->load(['customer', 'items']), 201);
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $validated = $request->validated();
        $itemsData = $validated['items'] ?? null;
        $hasItemsKey = array_key_exists('items', $validated);
        unset($validated['items']);

        $invoice = DB::transaction(function () use ($invoice, $validated, $itemsData, $hasItemsKey) {
            $invoice->update($validated);

            if ($hasItemsKey) {
                $invoice->items()->delete();

                if (!empty($itemsData) && is_array($itemsData)) {
                    $items = [];
                    foreach ($itemsData as $item) {
                        $qty = (float) ($item['quantity'] ?? 1);
                        $price = (float) ($item['unit_price'] ?? 0);
                        $total = isset($item['total_price']) ? (float) $item['total_price'] : ($qty * $price);

                        $items[] = [
                            'description' => $item['description'],
                            'quantity' => $qty,
                            'unit_price' => $price,
                            'total_price' => $total,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    $invoice->items()->createMany($items);
                }
            }

            return $invoice;
        });

        return response()->json($invoice->load(['customer', 'items']), 200);
    }

    public function destroy(Invoice $invoice)
    {
        try {
            DB::transaction(function () use ($invoice) {
                $invoice->items()->delete();
                $invoice->delete();
            });

            return response()->json([
                'status' => 'success',
                'message' => 'تم حذف الفاتورة بنجاح'
            ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting invoice: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء حذف الفاتورة',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
