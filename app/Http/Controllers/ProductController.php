<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showPhones(Request $request)
    {
        $query = Product::where('category', 'phones')->with('mainImage');
        $request->session()->put('previous_url', url()->full());

        // Filter by price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Sorting
        $sort_by = $request->get('sort_by', 'name');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort_by, $order);

        $products = $query->paginate(30);
        return view('products.show.phones', compact('products'));
    }

    public function showMonitors(Request $request)
    {
        $query = Product::where('category', 'monitors')->with('mainImage');
        $request->session()->put('previous_url', url()->full());

        // Filter by price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Sorting
        $sort_by = $request->get('sort_by', 'name');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort_by, $order);

        $products = $query->paginate(30);
        return view('products.show.monitors', compact('products'));
    }

    public function showHeadphones(Request $request)
    {
        $query = Product::where('category', 'headphones')->with('mainImage');
        $request->session()->put('previous_url', url()->full());

        // Filter by price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Sorting
        $sort_by = $request->get('sort_by', 'name');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort_by, $order);

        $products = $query->paginate(30);
        return view('products.show.headphones', compact('products'));
    }

    public function show(Product $product, Request $request)
    {
        $previousUrl = $request->session()->get('previous_url');
        return view('products.show', compact('product', 'previousUrl'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(30);

        return view('products.show.search', compact('products', 'query'));
    }

    public function showDiscountedProducts()
    {
        $products = Product::whereHas('discount', function ($query) {
            $query->where('discount_percentage', '>', 0);
        })->with('mainImage', 'discount')->paginate(30);

        return view('index', compact('products'));
    }
}