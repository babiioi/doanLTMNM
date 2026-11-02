<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class RestoreCartOnLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;
        $saved = is_array($user->cart) ? $user->cart : [];
        $guest = session('cart', []);

        // Gộp giỏ đã lưu với giỏ vừa thêm lúc chưa đăng nhập (lấy số lượng lớn hơn).
        $merged = $saved;
        foreach ($guest as $key => $quantity) {
            $merged[$key] = max((int) ($merged[$key] ?? 0), (int) $quantity);
        }

        session(['cart' => $merged]);
        $user->forceFill(['cart' => $merged])->save();
    }
}
