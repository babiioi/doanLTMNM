<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'label', 'type', 'value', 'min_order',
        'max_uses', 'used_count', 'starts_at', 'expires_at', 'is_active',
    ];

    protected $casts = [
        'value' => 'integer',
        'min_order' => 'integer',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public static function findByCode(?string $code): ?self
    {
        if (!$code) {
            return null;
        }
        return static::where('code', strtoupper(trim($code)))->first();
    }

    /** Trả về thông báo lỗi nếu mã không dùng được, null nếu hợp lệ. */
    public function validationError(float $subtotal): ?string
    {
        if (!$this->is_active) {
            return 'Mã giảm giá hiện không còn hiệu lực.';
        }
        if ($this->starts_at && now()->lt($this->starts_at)) {
            return 'Mã giảm giá chưa đến thời gian áp dụng.';
        }
        if ($this->expires_at && now()->gt($this->expires_at)) {
            return 'Mã giảm giá đã hết hạn.';
        }
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return 'Mã giảm giá đã hết lượt sử dụng.';
        }
        if ($subtotal < $this->min_order) {
            return 'Đơn hàng cần tối thiểu ' . number_format($this->min_order, 0, ',', '.') . '₫ để dùng mã này.';
        }
        return null;
    }

    public function discountFor(float $subtotal, float $shippingFee): float
    {
        return match ($this->type) {
            'percent' => round($subtotal * $this->value / 100),
            'fixed' => min((float) $this->value, $subtotal),
            'shipping' => min((float) $this->value, $shippingFee),
            default => 0,
        };
    }
}