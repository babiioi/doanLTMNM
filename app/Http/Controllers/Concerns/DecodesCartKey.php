<?php

namespace App\Http\Controllers\Concerns;

trait DecodesCartKey
{
    /**
     * Giải mã khóa giỏ hàng thành [loại, id, size].
     * Khóa hợp lệ: v_{id}[_s_S|M|L] (biến thể), p_{id}[_s_S|M|L] (sản phẩm), hoặc số thuần (giỏ cũ).
     */
    private function decodeKey(string $key): array
    {
        if (preg_match('/^v_(\d+)(?:_s_(S|M|L))?$/', $key, $m)) {
            return ['variant', (int) $m[1], $m[2] ?? null];
        }

        if (preg_match('/^p_(\d+)(?:_s_(S|M|L))?$/', $key, $m)) {
            return ['product', (int) $m[1], $m[2] ?? null];
        }

        // Giỏ hàng tạo từ phiên bản cũ dùng trực tiếp product_id làm khóa.
        if (ctype_digit($key)) {
            return ['product', (int) $key, null];
        }

        return ['invalid', 0, null];
    }
}
