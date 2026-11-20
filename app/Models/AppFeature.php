<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'icon',
        'is_enabled',
        'action_type',
        'disabled_message',
        'sort_order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * نطاق للميزات المفعلة فقط
     */
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    /**
     * فحص سريع عما إذا كانت ميزة معينة مفعلة
     */
    public static function isFeatureEnabled(string $key): bool
    {
        $feature = static::where('key', $key)->first();

        return $feature ? (bool) $feature->is_enabled : true;
    }

    /**
     * جلب كائن الميزة بالـ key
     */
    public static function findByKey(string $key): ?self
    {
        return static::where('key', $key)->first();
    }
}
