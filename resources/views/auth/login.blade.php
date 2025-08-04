<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-4">
            <a href="{{ route('auth.google') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12.24 10.28c-.24-.84-.72-1.56-1.44-2.04-.72-.48-1.68-.72-2.76-.72-2.28 0-4.08 1.2-5.4 3.6-1.32 2.4-1.98 5.28-1.98 8.64 0 3.36.66 6.24 1.98 8.64 1.32 2.4 3.12 3.6 5.4 3.6 1.08 0 2.04-.24 2.76-.72.72-.48 1.2-1.2 1.44-2.04h-2.88c-.12.48-.36.84-.72 1.08-.36.24-.84.36-1.44.36-1.08 0-1.92-.48-2.52-1.44-.6-.96-.9-2.16-.9-3.6 0-1.44.3-2.64.9-3.6.6-.96 1.44-1.44 2.52-1.44.6 0 1.08.12 1.44.36.36.24.6.6.72 1.08h2.88z" fill="#4285F4"/><path d="M23.76 12.24c0-.72-.06-1.44-.18-2.16H12.24v4.32h6.24c-.36 1.44-1.2 2.64-2.52 3.6-.96.72-2.16 1.08-3.6 1.08-2.28 0-4.08-1.2-5.4-3.6-1.32-2.4-1.98-5.28-1.98-8.64 0-3.36.66-6.24 1.98-8.64 1.32-2.4 3.12-3.6 5.4-3.6 1.08 0 2.04.24 2.76.72.72.48 1.2 1.2 1.44 2.04h-2.88c-.12.48-.36.84-.72 1.08-.36.24-.84.36-1.44.36-1.08 0-1.92-.48-2.52-1.44-.6-.96-.9-2.16-.9-3.6 0-1.44.3-2.64.9-3.6.6-.96 1.44-1.44 2.52-1.44.6 0 1.08.12 1.44.36.36.24.6.6.72 1.08h2.88z" fill="#FBBC05"/><path d="M12.24 23.76c-1.08 0-2.04-.24-2.76-.72-.72-.48-1.2-1.2-1.44-2.04h2.88c.12.48.36.84.72 1.08.36.24.84.36 1.44.36 1.08 0 1.92-.48 2.52-1.44.6-.96.9-2.16.9-3.6 0-1.44-.3-2.64-.9-3.6-.6-.96-1.44-1.44-2.52-1.44-.6 0-1.08.12-1.44.36-.36.24-.6.6-.72 1.08h-2.88c.12-.48.36-.84.72-1.08.36-.24.84-.36 1.44-.36 2.28 0 4.08 1.2 5.4 3.6 1.32 2.4 1.98 5.28 1.98 8.64 0 3.36-.66 6.24-1.98 8.64-1.32 2.4-3.12 3.6-5.4 3.6z" fill="#34A853"/><path d="M23.76 12.24c0-.72-.06-1.44-.18-2.16H12.24v4.32h6.24c-.36 1.44-1.2 2.64-2.52 3.6-.96.72-2.16 1.08-3.6 1.08-2.28 0-4.08-1.2-5.4-3.6-1.32-2.4-1.98-5.28-1.98-8.64 0-3.36.66-6.24 1.98-8.64 1.32-2.4 3.12-3.6 5.4-3.6 1.08 0 2.04.24 2.76.72.72.48 1.2 1.2 1.44 2.04h-2.88c-.12.48-.36.84-.72 1.08-.36.24-.84.36-1.44.36-1.08 0-1.92-.48-2.52-1.44-.6-.96-.9-2.16-.9-3.6 0-1.44.3-2.64.9-3.6.6-.96 1.44-1.44 2.52-1.44.6 0 1.08.12 1.44.36.36.24.6.6.72 1.08h2.88z" fill="#EA4335"/></svg>
                Login with Google
            </a>
        </div>
    </form>
</x-guest-layout>
