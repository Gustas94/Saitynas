<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Support\Facades\Session;

class MergeCart
{
    public function handle(UserLoggedIn $event)
    {
        $user = $event->user;
        $sessionCart = Session::get('cart', []);

        if (!empty($sessionCart)) {
            $cart = $user->cart;

            if ($cart) {
                $cart->product_ids = array_merge($cart->product_ids, $sessionCart);
            } else {
                $user->cart()->create([
                    'product_ids' => $sessionCart,
                ]);
            }

            $cart->save();
            Session::forget('cart');
        }
    }
}


