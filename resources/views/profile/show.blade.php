@extends('layouts.app')
@section('content')
    <div class="container mx-auto my-10 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Profile</h1>

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
            <label class="block text-gray-700 dark:text-gray-300">Hobbies:</label>
            <p class="text-gray-900 dark:text-gray-100">
                @foreach ($user->hobbies as $hobby)
                    {{ $hobby->name }}@if (!$loop->last), @endif
                @endforeach
            </p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Gender:</label>
            <p class="text-gray-900 dark:text-gray-100">
                @if($user->gender == 'M')
                    {{ __('Male') }}
                @elseif($user->gender == 'F')
                    {{ __('Female') }}
                @elseif($user->gender == 'O')
                    {{ __('Other') }}
                @else
                    {{ __('N/A') }}
                @endif
            </p>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Edit Profile</a>
            <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your profile?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete Profile</button>
            </form>
        </div>
    </div>
@endsection
