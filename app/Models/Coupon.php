<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'max_uses',
        'used_count',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'is_active'  => 'boolean',
    ];

    public function isValid($orderTotal): bool
    {
        if (!$this->is_active) return false;
        if ($this->used_count >= $this->max_uses) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($orderTotal < $this->min_order) return false;

        return true;
    }

    public function calculateDiscount($orderTotal): float
    {
        if ($this->type === 'percentage') {
            return round($orderTotal * ($this->value / 100), 2);
        }

        return min($this->value, $orderTotal);
    }
}