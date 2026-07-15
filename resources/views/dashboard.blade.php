<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Dashboard
        </h2>
    </x-slot>

    <div class="p-8">

        <h1 class="text-3xl font-bold mb-3">
            Welcome Admin!
        </h1>

        <p class="mb-6">
            You are now logged in.
        </p>

        <a href="{{ route('blogs.index') }}"
            class="bg-blue-500 text-white px-5 py-2 rounded">
            Manage Blogs
        </a>

    </div>

</x-app-layout>