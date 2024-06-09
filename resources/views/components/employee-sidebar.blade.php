<div class="w-1/6 p-6 bg-gray-100 dark:bg-gray-900 shadow-md h-screen">
    <h2 class="text-xl font-bold mb-6 text-gray-900 dark:text-gray-100">Employee Panel</h2>
    <ul>
        <li class="mb-4">
            <a href="{{ route('employee.products.index') }}"
                class="block px-4 py-2 rounded {{ request()->routeIs('employee.products.index') ? 'bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-100' : 'bg-gray-400 dark:bg-gray-800 text-gray-900 dark:text-gray-400' }} hover:bg-gray-300 dark:hover:bg-gray-600">
                Product List
            </a>
        </li>
        <li class="mb-4">
            <a href="{{ route('employee.products.create') }}"
                class="block px-4 py-2 rounded {{ request()->routeIs('employee.products.create') ? 'bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-100' : 'bg-gray-400 dark:bg-gray-800 text-gray-900 dark:text-gray-400' }} hover:bg-gray-300 dark:hover:bg-gray-600">
                Add Product
            </a>
        </li>
    </ul>
</div>
