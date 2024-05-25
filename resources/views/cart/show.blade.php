@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Cart</h1>
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($cartItems as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->mainImage)
                        <img src="{{ asset('storage/' . $item->mainImage->image_path) }}" alt="Product Image" class="w-32 h-32 object-contain">
                        @else
                        <img src="{{ asset('storage/images/image_missing.png') }}" alt="Image Missing" class="w-32 h-32 object-contain">
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $item->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-gray-200">{{ $productIds[$item->id] }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-gray-200">{{ $item->price * $productIds[$item->id] }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('products.show', $item->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Show</a>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-4 text-red-600 hover:text-red-900">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Total Price: {{ $totalPrice }}</h2>
        </div>
    </div>
</div>
@endsection
