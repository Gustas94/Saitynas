@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Monitors</h1>
    
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/4 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Search & Sort</h2>
            <form method="GET" action="{{ route('products.headphones') }}">
                <input type="hidden" name="previous_url" value="{{ url()->full() }}">
                <div class="mb-4">
                    <label for="min_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Min Price</label>
                    <input type="number" name="min_price" id="min_price" value="{{ request()->min_price }}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                </div>
                <div class="mb-4">
                    <label for="max_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Price</label>
                    <input type="number" name="max_price" id="max_price" value="{{ request()->max_price }}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" name="name" id="name" value="{{ request()->name }}" class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                </div>
                <div class="mb-4">
                    <button type="submit" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Search</button>
                </div>
            </form>
        </div>

        <!-- Main Content -->
        <div class="w-3/4 ml-4 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <a href="{{ route('products.headphones', array_merge(request()->query(), ['sort_by' => 'name', 'order' => request('order') == 'asc' ? 'desc' : 'asc'])) }}">Name</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <a href="{{ route('products.headphones', array_merge(request()->query(), ['sort_by' => 'price', 'order' => request('order') == 'asc' ? 'desc' : 'asc'])) }}">Price</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->mainImage)
                            <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" alt="Product Image" class="w-32 h-32 object-contain">
                            @else
                            <img src="{{ asset('storage/images/image_missing.png') }}" alt="Image Missing" class="w-32 h-32 object-contain">
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('products.show', $product->id) }}" class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ Str::limit($product->name, 80) }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-200">{{ $product->price }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Add to Cart</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
