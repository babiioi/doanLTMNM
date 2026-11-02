<?php

namespace App\Http\Controllers\Concerns;

trait DecodesCartKey
{

    private function decodeKey(string $key): array
    {
        if (preg_match('/^v_(\d+)(?:_s_(S|M|L))?$/', $key, $m)) {
            return ['variant', (int) $m[1], $m[2] ?? null];
        }

        if (preg_match('/^p_(\d+)(?:_s_(S|M|L))?$/', $key, $m)) {
            return ['product', (int) $m[1], $m[2] ?? null];
        }

        if (ctype_digit($key)) {
            return ['product', (int) $key, null];
        }

        return ['invalid', 0, null];
    }
}
