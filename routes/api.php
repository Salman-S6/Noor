<?php

use App\Http\Controllers\Api\V1\AppFeatureApiController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\NotificationApiController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('notifications/latest-update', [NotificationApiController::class, 'getLatestUpdate']);
Route::get('app-features', [AppFeatureApiController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('change-password', 'changePassword')->middleware('feature:change_password');
        Route::post('logout', 'logout');
        Route::get('me', 'me');
    });

    Route::prefix('notifications')
        ->controller(NotificationApiController::class)
        ->middleware('feature:notifications')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/{id}/read', 'markAsRead');
            Route::post('/read-all', 'markAllAsRead');
        });

    Route::prefix('customers/')
        ->controller(CustomerController::class)
        ->group(function () {
            Route::get('summary', 'summary')->middleware('feature:customers_summary');
            Route::get('total-debts', 'getTotalDebts');
            Route::get('overdue', 'getOverdue')->middleware('feature:overdue_debts');
        });
    Route::apiResource('customers', CustomerController::class)->middleware('feature:customers_management');

    Route::prefix('invoices/')
        ->controller(InvoiceController::class)
        ->middleware('feature:invoices')
        ->group(function () {
            Route::get('show/{invoice}', 'show');
            Route::get('details/{invoice}', 'show');
            Route::get('{customer}', 'getAllInvoicesForACustomer');
            Route::post('', 'store');
            Route::put('{invoice}', 'update');
            Route::delete('{invoice}', 'destroy');
        });

    Route::prefix('payments/')
        ->controller(PaymentController::class)
        ->middleware('feature:payments')
        ->group(function () {
            Route::post('', 'store');
            Route::put('{payment}', 'update');
            Route::delete('{payment}', 'destroy');
        });

    Route::controller(ReportController::class)->group(function () {
        Route::get('balance/{customer}', 'customerBalance');
        Route::get('movement', 'getMovement')->middleware('feature:account_movement');
        Route::get('reports/summary', 'summary')->middleware('feature:reports_summary');
    });
});
