@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <div class="w-1/6 p-6 bg-gray-100 dark:bg-gray-900 shadow-md h-screen">
        <h2 class="text-xl font-bold mb-6 text-gray-900 dark:text-gray-100">Admin Panel</h2>
        <ul>
            <li class="mb-4">
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">User List</a>
            </li>
            <li class="mb-4">
                <a href="{{ route('admin.roles.index') }}" class="block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">Manage Roles</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="w-5/6 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Add New Role</h1>

        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300" for="name">Role Name:</label>
                <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Role</button>
        </form>
    </div>
</div>
@endsection
