@extends('layouts.app')

@section('content')
    <div class="flex">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="w-5/6 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Roles for {{ $user->name }}</h1>

            <form action="{{ route('admin.users.updateRoles', $user->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Roles:</label>
                    @foreach ($roles as $role)
                        <div>
                            <label class="inline-flex items-center dark:text-gray-300">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ $user->roles->contains($role) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $role->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800">
                        Update Roles
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
