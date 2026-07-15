<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Dashboard
        </h2>
    </x-slot>

    <div class="p-8">

        <h1 class="mb-3 text-3xl font-bold">
            Welcome, {{ auth()->user()->name }}!
        </h1>

        <p class="mb-6">
            Your role:

            <span class="font-semibold">
                {{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}
            </span>
        </p>

        <div class="flex flex-wrap gap-3">

            <a href="{{ route('home') }}"
                class="rounded bg-gray-600 px-5 py-2 text-white hover:bg-gray-700">
                View Blogs
            </a>

            @hasanyrole('admin|author')
                <a href="{{ route('blogs.index') }}"
                    class="rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                    Manage Blogs
                </a>
            @endhasanyrole

            @role('admin')
                <a href="{{ route('users.index') }}"
                    class="rounded bg-green-600 px-5 py-2 text-white hover:bg-green-700">
                    Manage Users
                </a>
            @endrole

        </div>

    </div>

</x-app-layout>