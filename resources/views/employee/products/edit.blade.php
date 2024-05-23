@extends('layouts.app')

@section('content')
    <div class="flex">
        @include('components.employee-sidebar')

        <div class="w-5/6 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Product</h1>

            <form action="{{ route('employee.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300">Name:</label>
                    <input type="text" name="name" id="name"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                        value="{{ $product->name }}" required>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-gray-700 dark:text-gray-300">Category:</label>
                    <select name="category" id="category"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                        required>
                        <option value="phones" {{ $product->category == 'phones' ? 'selected' : '' }}>Phones</option>
                        <option value="headphones" {{ $product->category == 'headphones' ? 'selected' : '' }}>Headphones
                        </option>
                        <option value="monitors" {{ $product->category == 'monitors' ? 'selected' : '' }}>Monitors</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300">Description:</label>
                    <textarea name="description" id="description"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">{{ $product->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Specifications:</label>
                    <div id="specifications-container">
                        @if ($product->specifications)
                            @foreach (explode('; ', $product->specifications) as $spec)
                                @php
                                    $parts = explode(': ', $spec);
                                @endphp
                                <div class="flex items-center mb-2">
                                    <input type="text" name="specifications[key][]"
                                        class="w-1/2 p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                                        value="{{ $parts[0] }}" required>
                                    <span class="mx-2 text-white">:</span>
                                    <input type="text" name="specifications[value][]"
                                        class="w-1/2 p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                                        value="{{ $parts[1] }}" required>
                                    <button type="button"
                                        class="remove-specification px-2 py-1 ml-2 bg-red-500 text-white rounded-lg hover:bg-red-700">-</button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center mb-2">
                                <input type="text" name="specifications[key][]"
                                    class="w-1/2 p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                                    placeholder="Key" required>
                                <span class="mx-2 text-white">:</span>
                                <input type="text" name="specifications[value][]"
                                    class="w-1/2 p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                                    placeholder="Value" required>
                                <button type="button"
                                    class="remove-specification px-2 py-1 ml-2 bg-red-500 text-white rounded-lg hover:bg-red-700">-</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-specification"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">+</button>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 dark:text-gray-300">Price:</label>
                    <input type="number" name="price" id="price"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                        value="{{ $product->price }}" required step="0.01">
                </div>
                <div class="mb-4">
                    <label for="images" class="block text-gray-700 dark:text-gray-300">Images:</label>
                    <input type="file" name="images[]" id="images"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                        multiple>
                    <label for="main_image" class="block text-gray-700 dark:text-gray-300 mt-2">Main Image:</label>
                    <input type="number" name="main_image" id="main_image"
                        class="w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200"
                        placeholder="Enter the image number (starting from 0) for the main image">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Current Images:</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ($product->images as $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image"
                                    class="w-32 h-32 object-cover">
                                <form action="{{ route('employee.products.destroyImage', $image->id) }}" method="POST"
                                    class="absolute top-0 right-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white rounded-full p-1 ml-20"
                                        onclick="return confirm('Are you sure you want to delete this image?');">Delete</button>
                                </form>
                                @if ($image->is_main)
                                    <span
                                        class="absolute bottom-0 left-0 bg-gray-600 text-white px-2 py-1 rounded-tr-md">Main</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Update
                    Product</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-specification').addEventListener('click', function() {
            const container = document.getElementById('specifications-container');
            const count = container.children.length;

            if (count < 30) {
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'mb-2');
                div.innerHTML = `
                <input type="text" name="specifications[key][]" class="w-1/2 p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200" placeholder="Key" required>
                <span class="mx-2 text-white">:</span>
                <input type="text" name="specifications[value][]" class="w-1/2 p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200" placeholder="Value" required>
                <button type="button" class="remove-specification px-2 py-1 bg-red-500 text-white rounded-full ml-2">-</button>
            `;
                container.appendChild(div);
            }
        });

        document.getElementById('specifications-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-specification')) {
                event.target.parentElement.remove();
            }
        });
    </script>
@endsection
