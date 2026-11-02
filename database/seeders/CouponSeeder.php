<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            ['code' => 'GIAM10', 'label' => 'Giảm 10% tiền hàng', 'type' => 'percent', 'value' => 10, 'min_order' => 0],
            ['code' => 'GIAM50K', 'label' => 'Giảm 50.000₫', 'type' => 'fixed', 'value' => 50000, 'min_order' => 200000],
            ['code' => 'FREESHIP', 'label' => 'Giảm phí vận chuyển tối đa 30.000₫', 'type' => 'shipping', 'value' => 30000, 'min_order' => 0],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(['code' => $coupon['code']], $coupon + ['is_active' => true]);
        }
    }
}