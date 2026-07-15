<x-guest-layout>

    <div class="flex justify-end gap-3 p-6">

        @auth

            <a href="{{ route('dashboard') }}"
                class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
                Dashboard
            </a>

        @else

            <a href="{{ route('login') }}"
                class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
                Login
            </a>

            <a href="{{ route('register') }}"
                class="rounded bg-green-500 px-4 py-2 text-white hover:bg-green-600">
                Register
            </a>

        @endauth

    </div>

    <h1 class="mb-8 text-center text-4xl font-bold">
        MY BLOGS
    </h1>

    <div class="p-8">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

            @forelse ($blogs as $blog)

                <div class="rounded-lg border bg-white p-4 shadow">

                    <img
                        src="{{ asset('images/' . $blog->image) }}"
                        alt="{{ $blog->title }}"
                        class="h-48 w-full rounded object-cover">

                    <h2 class="mt-4 text-xl font-bold">
                        {{ $blog->title }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        By {{ $blog->user?->name ?? 'Unknown author' }}
                    </p>

                    <p class="mt-2">
                        {{ \Illuminate\Support\Str::limit($blog->content, 100) }}
                    </p>

                    <a href="{{ route('blogs.show', $blog) }}"
                        class="mt-4 inline-block rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
                        Read More
                    </a>

                </div>

            @empty

                <div class="col-span-full text-center text-gray-500">
                    No approved blogs available.
                </div>

            @endforelse

        </div>

    </div>

</x-guest-layout>