<?php

use App\Http\Controllers\Admin\AppFeatureController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Middleware\AdminBasicAuth;
use App\Models\AppNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $latestUpdate = null;

    if (Schema::hasTable('app_notifications')) {
        try {
            $latestUpdate = Cache::remember('welcome_latest_app_update', 3600, function () {
                return AppNotification::active()
                    ->where('type', 'update')
                    ->whereNotNull('link')
                    ->get()
                    ->sort(function ($a, $b) {
                        $cmp = version_compare($b->version, $a->version);

                        return $cmp !== 0 ? $cmp : ($b->id <=> $a->id);
                    })
                    ->first();
            });
        } catch (Throwable $e) {
            $latestUpdate = null;
        }
    }

    $downloadUrl = $latestUpdate?->link ?: asset('downloads/noor.apk');
    $version = $latestUpdate?->version ?: '2.0.0';

    return view('welcome', compact('latestUpdate', 'downloadUrl', 'version'));
});

Route::prefix('admin')->middleware([AdminBasicAuth::class, 'throttle:30,1'])->name('admin.')->group(function () {

    // مسارات إدارة الإشعارات وتحديثات التطبيق
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/', [NotificationController::class, 'store'])->name('store');
        Route::patch('/{notification}/toggle', [NotificationController::class, 'toggle'])->name('toggle');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // مسارات التحكم بميزات وواجهات التطبيق (App Features Management)
    Route::prefix('features')->name('features.')->group(function () {
        Route::get('/', [AppFeatureController::class, 'index'])->name('index');
        Route::post('/', [AppFeatureController::class, 'store'])->name('store');
        Route::put('/{feature}', [AppFeatureController::class, 'update'])->name('update');
        Route::patch('/{feature}/toggle', [AppFeatureController::class, 'toggle'])->name('toggle');
        Route::delete('/{feature}', [AppFeatureController::class, 'destroy'])->name('destroy');
    });

});
