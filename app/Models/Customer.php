<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
    ];

    protected $appends = ['balance'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getBalanceAttribute()
    {
        if (array_key_exists('total_invoices', $this->attributes) && array_key_exists('total_payments', $this->attributes)) {
            return round(((float) ($this->attributes['total_invoices'] ?? 0)) - ((float) ($this->attributes['total_payments'] ?? 0)), 2) + 0;
        }

        if ($this->relationLoaded('invoices') && $this->relationLoaded('payments')) {
            return round(((float) $this->invoices->sum('amount')) - ((float) $this->payments->sum('amount')), 2) + 0;
        }

        $invoicesSum = (float) $this->invoices()->sum('amount');
        $paymentsSum = (float) $this->payments()->sum('amount');

        return round($invoicesSum - $paymentsSum, 2) + 0;
    }

    public function formatForApi(): array
    {
        $firstName = $this->first_name;
        if (is_string($firstName)) {
            $decoded = json_decode($firstName, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $firstName = $decoded;
            }
        }

        return [
            'id' => (int) $this->id,
            'first_name' => $firstName,
            'phone' => $this->phone,
        ];
    }
}
