<?php

namespace App\Traits;

use App\Models\Cart;

trait CartTrait
{
    private function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => session('user')['id']]);
    }
}
