@extends('layouts.app')

@section('content')
<div class="container mx-auto my-10 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">User Profile</h1>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">Name:</label>
        <p class="text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">Email:</label>
        <p class="text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">Country:</label>
        <p class="text-gray-900 dark:text-gray-100">{{ $user->country ? $user->country->name : 'N/A' }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">City:</label>
        <p class="text-gray-900 dark:text-gray-100">{{ $user->city ? $user->city->name : 'N/A' }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">Address:</label>
        <p class="text-gray-900 dark:text-gray-100">{{ $user->address ?? 'N/A' }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">Zip Code:</label>
        <p class="text-gray-900 dark:text-gray-100">{{ $user->zip_code ?? 'N/A' }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">Gender:</label>
        <p class="text-gray-900 dark:text-gray-100">
            @if ($user->gender == 'M')
                Male
            @elseif ($user->gender == 'F')
                Female
            @elseif ($user->gender == 'O')
                Other
            @endif
        </p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">Hobbies:</label>
        <p class="text-gray-900 dark:text-gray-100">
            @foreach ($user->hobbies as $hobby)
                {{ $hobby->name }}@if (!$loop->last), @endif
            @endforeach
        </p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300">Role:</label>
        <p class="text-gray-900 dark:text-gray-100">
            @foreach ($user->roles as $role)
                {{ $role->name }}@if (!$loop->last), @endif
            @endforeach
        </p>
    </div>
</div>
@endsection
