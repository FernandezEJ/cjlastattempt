<x-guest-layout>

    <div class="flex min-h-screen items-center justify-center px-4 py-8">

        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow">

            <h1 class="mb-1 text-center text-2xl font-bold">
                Login
            </h1>

            <p class="mb-5 text-center text-gray-500">
                Welcome back! Please log in to your account.
            </p>

            <!-- Session Status -->
            <x-auth-session-status
                class="mb-4"
                :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <!-- Email -->
                <div>

                    <x-input-label
                        for="email"
                        :value="__('Email')" />

                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Enter your email" />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2" />

                </div>

                <!-- Password -->
                <div class="mt-4">

                    <x-input-label
                        for="password"
                        :value="__('Password')" />

                    <x-text-input
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password" />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2" />

                </div>

                <!-- Remember Me -->
                <div class="mt-4">

                    <label
                        for="remember_me"
                        class="inline-flex items-center">

                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">

                        <span class="ml-2 text-sm text-gray-600">
                            Remember me
                        </span>

                    </label>

                </div>

                <!-- Login Button -->
                <div class="mt-6">

                    <x-primary-button class="w-full justify-center">
                        Log In
                    </x-primary-button>

                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))

                    <div class="mt-4 text-center">

                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:underline">
                            Forgot your password?
                        </a>

                    </div>

                @endif

                <!-- Register and Home -->
                <div class="mt-5 text-center text-sm">

                    <a
                        href="{{ route('register') }}"
                        class="text-blue-600 hover:underline">
                        Create an account
                    </a>

                    <span class="mx-2 text-gray-400">
                        |
                    </span>

                    <a
                        href="{{ route('home') }}"
                        class="text-gray-600 hover:underline">
                        Back to Home
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-guest-layout>