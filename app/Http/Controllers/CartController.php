<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Product $product, Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;

            if ($cart) {
                $cart->product_ids = array_merge($cart->product_ids, [$product->id]);
            } else {
                $user->cart()->create([
                    'product_ids' => [$product->id],
                ]);
            }

            $cart->save();
        } else {
            $cart = Session::get('cart', []);
            $cart[] = $product->id;
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function show()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;

            if ($cart) {
                $productIds = array_count_values($cart->product_ids);
                $cartItems = Product::whereIn('id', array_keys($productIds))->get();
                $totalPrice = $cartItems->sum(fn ($item) => $item->price * $productIds[$item->id]);
            } else {
                $cartItems = collect();
                $totalPrice = 0;
                $productIds = [];
            }
        } else {
            $cart = Session::get('cart', []);
            if ($cart) {
                $productIds = array_count_values($cart);
                $cartItems = Product::whereIn('id', array_keys($productIds))->get();
                $totalPrice = $cartItems->sum(fn ($item) => $item->price * $productIds[$item->id]);
            } else {
                $cartItems = collect();
                $totalPrice = 0;
                $productIds = [];
            }
        }

        return view('cart.show', compact('cartItems', 'productIds', 'totalPrice'));
    }

    public function remove($id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;
            if ($cart) {
                $productIds = $cart->product_ids;
                $key = array_search($id, $productIds);
                if ($key !== false) {
                    unset($productIds[$key]);
                    $cart->product_ids = array_values($productIds); // Re-index array
                    if (empty($productIds)) {
                        $cart->delete();
                    } else {
                        $cart->save();
                    }
                }
            }
        } else {
            $cart = Session::get('cart', []);
            $key = array_search($id, $cart);
            if ($key !== false) {
                unset($cart[$key]);
                Session::put('cart', array_values($cart)); // Re-index array
            }
        }

        return redirect()->route('cart.show')->with('success', 'Product removed from cart.');
    }
}
