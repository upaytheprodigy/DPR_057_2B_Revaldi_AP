<x-guest-layout>
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-indigo-100">
            <!-- Logo / Judul -->
            <div class="flex flex-col items-center mb-6">
                <svg class="w-12 h-12 text-indigo-600 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke="currentColor" stroke-width="2" d="M8 12l2 2 4-4"/>
                </svg>
                <h2 class="text-2xl font-bold text-indigo-700">Login Gaji DPR</h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username -->
                <div class="mb-4">
                    <x-input-label for="username" :value="__('Username')" class="font-semibold text-gray-700" />
                    <x-text-input id="username" class="block mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  type="text"
                                  name="username"
                                  :value="old('username')"
                                  required
                                  autofocus
                                  autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700" />
                    <x-text-input id="password" class="block mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input id="remember_me" type="checkbox"
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                           name="remember">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600">{{ __('Remember me') }}</label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-md">
                        {{ __('LOG IN') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>