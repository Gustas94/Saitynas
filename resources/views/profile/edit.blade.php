@extends('layouts.app')

@section('content')
    <div class="flex justify-center mt-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Profile</h1>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Country -->
                <div class="mt-4">
                    <x-input-label for="country_id" :value="__('Country')" />
                    <select id="country_id" name="country_id" class="block mt-1 w-full" required>
                        <option value="">{{ __('Select Country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
                </div>

                <!-- City -->
                <div class="mt-4">
                    <x-input-label for="city_id" :value="__('City')" />
                    <select id="city_id" name="city_id" class="block mt-1 w-full" required>
                        <option value="">{{ __('Select City') }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                </div>

                <!-- Address -->
                <div class="mt-4">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $user->address)" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Zip Code -->
                <div class="mt-4">
                    <x-input-label for="zip_code" :value="__('Zip Code')" />
                    <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code', $user->zip_code)" required />
                    <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
                </div>

                <!-- Hobbies -->
                <div class="mt-4">
                    <x-input-label :value="__('Hobbies')" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 text-gray-300">
                        @foreach ($hobbies as $hobby)
                            <label class="flex items-center">
                                <input type="checkbox" name="hobbies[]" value="{{ $hobby->id }}" {{ in_array($hobby->id, old('hobbies', $user->hobbies->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $hobby->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('hobbies')" class="mt-2" />
                </div>

                <!-- Gender -->
                <div class="mt-4">
                    <x-input-label for="gender" :value="__('Gender')" />
                    <div class="flex items-center mt-2 text-gray-300">
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="M" {{ old('gender', $user->gender) == 'M' ? 'checked' : '' }}>
                            <span class="ml-2">{{ __('Male') }}</span>
                        </label>
                        <label class="flex items-center ml-4">
                            <input type="radio" name="gender" value="F" {{ old('gender', $user->gender) == 'F' ? 'checked' : '' }}>
                            <span class="ml-2">{{ __('Female') }}</span>
                        </label>
                        <label class="flex items-center ml-4">
                            <input type="radio" name="gender" value="O" {{ old('gender', $user->gender) == 'O' ? 'checked' : '' }}>
                            <span class="ml-2">{{ __('Other') }}</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Update Profile') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add a script to handle city dropdown based on selected country -->
    <script>
        document.getElementById('country_id').addEventListener('change', function() {
            var countryId = this.value;
            var citiesDropdown = document.getElementById('city_id');

            // Clear existing options
            citiesDropdown.innerHTML = '<option value="">{{ __('Select City') }}</option>';

            // Fetch cities based on selected country
            fetch(`/api/cities?country_id=${countryId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(city => {
                        var option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citiesDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));
        });
    </script>
@endsection
