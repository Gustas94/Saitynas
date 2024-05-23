@extends('layouts.app')

@section('content')
<div class="flex">
    @include('components.employee-sidebar')

    <div class="w-5/6 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Manage Products</h1>
        <a href="{{ route('employee.products.create') }}" class="mb-4 inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Add New Product</a>

        <!-- Filters -->
        <div class="mb-4 flex items-center">
            <form method="GET" action="{{ route('employee.products.index') }}" class="flex space-x-4">
                <div>
                    <label for="category" class="block text-gray-700 dark:text-gray-300 mb-2">Filter by Category:</label>
                    <select name="category" id="category" class="p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200" onchange="this.form.submit()">
                        <option value="all">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category }}" {{ request('category') == $category->category ? 'selected' : '' }}>{{ ucfirst($category->category) }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="sort_by" value="{{ $sort_by }}">
                <input type="hidden" name="order" value="{{ $order }}">
            </form>
        </div>

        <table class="min-w-full bg-white dark:bg-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    @php
                        $next_order = $order == 'asc' ? 'desc' : 'asc';
                    @endphp
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <a href="{{ route('employee.products.index', ['sort_by' => 'id', 'order' => $next_order, 'category' => request('category')]) }}">ID</a>
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <a href="{{ route('employee.products.index', ['sort_by' => 'name', 'order' => $next_order, 'category' => request('category')]) }}">Name</a>
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <a href="{{ route('employee.products.index', ['sort_by' => 'category', 'order' => $next_order, 'category' => request('category')]) }}">Category</a>
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <a href="{{ route('employee.products.index', ['sort_by' => 'price', 'order' => $next_order, 'category' => request('category')]) }}">Price</a>
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Delete</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($products as $product)
                    <tr>
                        <td class="py-4 px-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->id }}</td>
                        <td class="py-4 px-4 text-sm text-gray-500 dark:text-gray-300">{{ $product->name }}</td>
                        <td class="py-4 px-4 text-sm text-gray-500 dark:text-gray-300">{{ $product->category }}</td>
                        <td class="py-4 px-4 text-sm text-gray-500 dark:text-gray-300">{{ $product->price }}</td>
                        <td class="py-4 px-4 text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('employee.products.show', $product->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">Show</a>
                                <a href="{{ route('employee.products.edit', $product->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-500 hover:bg-gray-600">Edit</a>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm">
                            <form action="{{ route('employee.products.destroy', $product->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
