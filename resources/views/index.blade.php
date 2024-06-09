<!-- resources/views/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Discounted Products</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                    @if ($product->mainImage)
                        <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" alt="Product Image" class="w-full h-48 object-cover mb-4">
                    @else
                        <img src="{{ asset('storage/images/image_missing.png') }}" alt="Image Missing" class="w-full h-48 object-cover mb-4">
                    @endif
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h2>
                    <p class="text-gray-700 dark:text-gray-300">${{ $product->price }}</p>
                    @if ($product->discount)
                        <p class="text-red-500 dark:text-red-400">Discount: {{ $product->discount->discount_percentage }}%</p>
                        <p class="text-gray-900 dark:text-gray-100">New Price: ${{ $product->price - ($product->price * $product->discount->discount_percentage / 100) }}</p>
                    @endif
                    <a href="{{ route('products.show', $product->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">View Details</a>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
