<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'type',
        'link',
        'version',
        'is_mandatory',
        'is_active',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('latest_app_update');
            \Illuminate\Support\Facades\Cache::forget('welcome_latest_app_update');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('latest_app_update');
            \Illuminate\Support\Facades\Cache::forget('welcome_latest_app_update');
        });
    }

    /**
     * المستخدم الموجه له الإشعار (في حال كان إشعاراً خاصاً)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * سجلات القراءة
     */
    public function reads(): HasMany
    {
        return $this->hasMany(AppNotificationRead::class, 'app_notification_id');
    }

    /**
     * المستخدمون الذين قرأوا هذا الإشعار
     */
    public function readByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'app_notification_reads', 'app_notification_id', 'user_id')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    /**
     * نطاق للإشعارات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * نطاق للإشعارات الموجهة للمستخدم (العامة + الموجهة له بالاسم)
     */
    public function scopeForUser($query, ?int $userId = null)
    {
        if ($userId) {
            return $query->where(function ($q) use ($userId) {
                $q->whereNull('user_id')->orWhere('user_id', $userId);
            });
        }

        return $query->whereNull('user_id');
    }
}
