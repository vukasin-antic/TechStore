<?php

namespace App\Traits;

use App\Models\Cart;

trait CartTrait
{
    private function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => session('user')['id']]);
    }
    private function getCartTotalInfo($cart, $cartItems): array
    {
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $promoApplied = (bool) $cart->promo_code;
        $promoCode = $cart->promo_code;
        $discountPercent = $cart->discount_percent ?? 0;
        $discount = $promoApplied ? $total * ($discountPercent / 100) : 0;

        return [
            'total' => $total,
            'promoApplied' => $promoApplied,
            'promoCode' => $promoCode,
            'discountPercent' => $discountPercent,
            'discount' => $discount,
            'finalTotal' => $total - $discount,
        ];
    }
}
