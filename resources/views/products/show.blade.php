@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center mt-4">
    <div class="w-5/6 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Product Details</h1>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Name:</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $product->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Category:</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $product->category }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Description:</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $product->description }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Specifications:</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $product->specifications }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Price:</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $product->price }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Has Discount:</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $product->hasDiscount ? 'Yes' : 'No' }}</p>
        </div>
        @if ($product->hasDiscount)
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Discount Percentage:</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $product->discount->discount_percentage }}%</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">New Price:</label>
            <p class="text-gray-900 dark:text-gray-100">{{ $product->price - ($product->price * $product->discount->discount_percentage / 100) }}</p>
        </div>
        @endif
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Images:</label>
            <div class="grid grid-cols-10 gap-1 mt-2">
                @foreach ($product->images as $image)
                <div>
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" class="w-32 h-32 object-cover">
                </div>
                @endforeach
            </div>
        </div>
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Add to Cart</button>
        </form>
        <form action="{{ $previousUrl ?? route('products.index') }}" method="GET" class="inline">
            @if(isset($previousUrl))
                @php
                    $queryParams = [];
                    parse_str(parse_url($previousUrl, PHP_URL_QUERY), $queryParams);
                @endphp
                @foreach($queryParams as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
            @endif
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</button>
        </form>
    </div>
</div>
@endsection
