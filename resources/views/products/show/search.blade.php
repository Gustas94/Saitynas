<!-- resources/views/products/show/search.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6 mt-2 text-gray-900 dark:text-gray-100">Search Results for "{{ $query }}"</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h2>
                    <p class="text-gray-700 dark:text-gray-300">${{ $product->price }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">View Details</a>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->appends(['query' => $query])->links() }}
        </div>
    </div>
@endsection