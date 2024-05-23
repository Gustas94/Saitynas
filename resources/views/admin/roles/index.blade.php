@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="w-5/6 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Manage Roles</h1>
        <a href="{{ route('admin.roles.create') }}" class="mb-4 inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Add New Role</a>

        <table class="min-w-full bg-white dark:bg-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Delete</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($roles as $role)
                    <tr>
                        <td class="py-4 px-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $role->id }}</td>
                        <td class="py-4 px-4 text-sm text-gray-500 dark:text-gray-300">{{ $role->name }}</td>
                        <td class="py-4 px-4 text-sm space-x-2">
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800">Edit</a>
                        </td>
                        <td class="py-4 px-4 text-sm">
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800" onclick="return confirm('Are you sure you want to delete this role?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
