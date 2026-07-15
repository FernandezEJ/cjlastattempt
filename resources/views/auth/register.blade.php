<x-guest-layout>

    <div class="flex min-h-screen items-center justify-center px-4 py-8">

        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow">

            <h1 class="mb-1 text-center text-2xl font-bold">
                Register
            </h1>

            <p class="mb-5 text-center text-gray-500">
                Create your account to start blogging.
            </p>

            <form method="POST" action="{{ route('register') }}">

                @csrf

                <!-- Name -->
                <div>

                    <x-input-label
                        for="name"
                        :value="__('Name')" />

                    <x-text-input
                        id="name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Enter your name" />

                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2" />

                </div>

                <!-- Email -->
                <div class="mt-4">

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
                        autocomplete="new-password"
                        placeholder="Enter your password" />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2" />

                </div>

                <!-- Confirm Password -->
                <div class="mt-4">

                    <x-input-label
                        for="password_confirmation"
                        :value="__('Confirm Password')" />

                    <x-text-input
                        id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm your password" />

                    <x-input-error
                        :messages="$errors->get('password_confirmation')"
                        class="mt-2" />

                </div>

                <!-- Register Button -->
                <div class="mt-6">

                    <x-primary-button class="w-full justify-center">
                        Register
                    </x-primary-button>

                </div>

                <!-- Login & Home -->
                <div class="mt-5 text-center text-sm">

                    <a
                        href="{{ route('login') }}"
                        class="text-blue-600 hover:underline">
                        Already have an account?
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