<?php

namespace App\Http\Controllers\Concerns;

trait StoresCart
{
    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);

        if ($user = auth()->user()) {
            $user->forceFill(['cart' => $cart])->save();
        }
    }
}
