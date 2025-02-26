<x-guest-layout>
    <!-- Logo dan Nama Aplikasi -->
    <div class="flex flex-col items-center mt-8">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        {{-- <h1 class="text-2xl font-bold text-gray-700 mt-4">LEVI</h1>
        <p class="text-sm text-gray-500">Leave and Overtime Input</p> --}}
    </div>

    <!-- Status Session -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Formulir Login -->
    <form method="POST" action="{{ route('login') }}" class="mt-8">
        @csrf

        <!-- Alamat Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Kata Sandi -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Ingat Saya -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Tindakan Formulir -->
        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3 bg-blue-600 hover:bg-blue-700">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
