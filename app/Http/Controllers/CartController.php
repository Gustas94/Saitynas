<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Product $product, Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;

        if ($cart) {
            $productIds = $cart->product_ids;
            $productIds[] = $product->id;
            $cart->product_ids = $productIds;
        } else {
            $cart = $user->cart()->create([
                'product_ids' => [$product->id],
            ]);
        }

        $cart->save();

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function show()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if ($cart) {
            $productIds = array_count_values($cart->product_ids);
            $cartItems = Product::whereIn('id', array_keys($productIds))->get();
            $totalPrice = $cartItems->sum(fn($item) => $item->price * $productIds[$item->id]);
        } else {
            $cartItems = collect();
            $totalPrice = 0;
            $productIds = []; // Ensure $productIds is defined
        }

        return view('cart.show', compact('cartItems', 'productIds', 'totalPrice'));
    }

    public function remove($id)
    {
        $user = Auth::user();
        $cart = $user->cart;

        if ($cart) {
            $productIds = $cart->product_ids; // This will be an array
            $key = array_search((string)$id, $productIds);
            if ($key !== false) {
                unset($productIds[$key]);
            }

            if (empty($productIds)) {
                // Delete the cart if no more items are left
                $cart->delete();
            } else {
                // Update the cart with remaining items
                $cart->product_ids = $productIds; // This will be converted back to a string in the Cart model
                $cart->save();
            }
        }

        return redirect()->route('cart.show')->with('success', 'Product removed from cart.');
    }
}
