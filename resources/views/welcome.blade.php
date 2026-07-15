<x-guest-layout>

    <div class="flex justify-end gap-3 p-6">

        <a href="{{ route('login') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Login
        </a>

        <a href="{{ route('register') }}"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Register
        </a>

    </div>

    <h1 class="text-4xl font-bold text-center mb-8">
        MY ANIME BLOGS
    </h1>

    <div class="p-8">
        <div class="grid grid-cols-4 gap-4">

            @foreach($blogs as $blog)

                <div class="bg-white border rounded-lg shadow p-4">

                    <img
                        src="{{ asset('images/' . $blog->image) }}"
                        alt="{{ $blog->title }}"
                        class="rounded w-full h-48 object-cover">

                    <h2 class="text-xl font-bold mt-4">
                        {{ $blog->title }}
                    </h2>

                    <p class="mt-2">
                        {{ $blog->content }}
                    </p>

                    <a href="#"
                        class="inline-block mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                        Read More
                    </a>

                </div>

            @endforeach

        </div>
    </div>

</x-guest-layout>