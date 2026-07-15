<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Dashboard
        </h2>
    </x-slot>

    <div class="p-8">

        <h1 class="mb-2 text-3xl font-bold">
            Welcome, {{ auth()->user()->name }}!
        </h1>

        <p class="mb-8 text-gray-600">
            Your role:

            <span class="font-semibold">
                {{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}
            </span>
        </p>

        {{-- Admin statistics --}}
        @role('admin')

            <h2 class="mb-4 text-2xl font-bold">
                Blog Statistics
            </h2>

            <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Approved posts --}}
                <div class="rounded-lg border bg-white p-6 shadow">

                    <p class="text-sm font-semibold text-gray-500">
                        Approved Posts
                    </p>

                    <p class="mt-2 text-4xl font-bold text-green-600">
                        {{ $approvedPosts }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Posts visible on the homepage
                    </p>

                </div>

                {{-- Pending posts --}}
                <div class="rounded-lg border bg-white p-6 shadow">

                    <p class="text-sm font-semibold text-gray-500">
                        Pending Posts
                    </p>

                    <p class="mt-2 text-4xl font-bold text-yellow-600">
                        {{ $pendingPosts }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Posts waiting for approval
                    </p>

                </div>

                {{-- Total users --}}
                <div class="rounded-lg border bg-white p-6 shadow">

                    <p class="text-sm font-semibold text-gray-500">
                        Total Users
                    </p>

                    <p class="mt-2 text-4xl font-bold text-blue-600">
                        {{ $totalUsers }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        All registered accounts
                    </p>

                </div>

                {{-- Total authors --}}
                <div class="rounded-lg border bg-white p-6 shadow">

                    <p class="text-sm font-semibold text-gray-500">
                        Total Authors
                    </p>

                    <p class="mt-2 text-4xl font-bold text-purple-600">
                        {{ $totalAuthors }}
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Users allowed to create blogs
                    </p>

                </div>

            </div>

        @endrole

        {{-- Dashboard buttons --}}
        <div class="flex flex-wrap gap-3">

            <a
                href="{{ route('home') }}"
                class="rounded bg-gray-600 px-5 py-2 text-white hover:bg-gray-700">
                View Blogs
            </a>

            @hasanyrole('admin|author')

                <a
                    href="{{ route('blogs.index') }}"
                    class="rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                    Manage Blogs
                </a>

            @endhasanyrole

            @role('admin')

                <a
                    href="{{ route('users.index') }}"
                    class="rounded bg-green-600 px-5 py-2 text-white hover:bg-green-700">
                    Manage Users
                </a>

                <a
                    href="{{ route('categories.index') }}"
                    class="rounded bg-purple-600 px-5 py-2 text-white hover:bg-purple-700">
                    Manage Categories
                </a>

            @endrole

        </div>

    </div>

</x-app-layout>