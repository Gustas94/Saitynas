@extends('layouts.app')

@section('content')
<div class="flex">
    @include('components.employee-sidebar')

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
            <label class="block text-gray-700 dark:text-gray-300">Images:</label>
            @foreach ($product->images as $image)
                <div>
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" class="w-32 h-32 object-cover">
                    @if ($image->is_main)
                        <span class="text-green-500">(Main Image)</span>
                    @endif
                </div>
            @endforeach
        </div>
        <form action="{{ route('employee.products.index') }}" method="GET" class="inline">
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Back</button>
        </form>
    </div>
</div>
@endsection
