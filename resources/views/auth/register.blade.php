<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Country -->
        <div class="mt-4">
            <x-input-label for="country_id" :value="__('Country')" />
            <select id="country_id" name="country_id" class="block mt-1 w-full" required>
                <option value="">{{ __('Select Country') }}</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
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
                <!-- Cities will be populated by JavaScript -->
            </select>
            <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Zip Code -->
        <div class="mt-4">
            <x-input-label for="zip_code" :value="__('Zip Code')" />
            <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code')" required />
            <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
        </div>

        <!-- Hobbies -->
        <div class="mt-4">
            <x-input-label :value="__('Hobbies')" />
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 text-gray-300">
                @foreach ($hobbies as $hobby)
                    <label class="flex items-center">
                        <input type="checkbox" name="hobbies[]" value="{{ $hobby->id }}"
                            {{ in_array($hobby->id, old('hobbies', [])) ? 'checked' : '' }}>
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
                    <input type="radio" name="gender" value="M" {{ old('gender') == 'M' ? 'checked' : '' }}>
                    <span class="ml-2">{{ __('Male') }}</span>
                </label>
                <label class="flex items-center ml-4">
                    <input type="radio" name="gender" value="F" {{ old('gender') == 'F' ? 'checked' : '' }}>
                    <span class="ml-2">{{ __('Female') }}</span>
                </label>
                <label class="flex items-center ml-4">
                    <input type="radio" name="gender" value="O" {{ old('gender') == 'O' ? 'checked' : '' }}>
                    <span class="ml-2">{{ __('Other') }}</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

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
</x-guest-layout>
