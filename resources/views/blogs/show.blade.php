<x-guest-layout>

    <div class="mx-auto max-w-4xl p-8">

        <a href="{{ route('home') }}"
            class="mb-6 inline-block rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">
            Back
        </a>

        <div class="rounded-lg border bg-white p-6 shadow">

            <img
                src="{{ asset('images/' . $blog->image) }}"
                alt="{{ $blog->title }}"
                class="mb-6 h-96 w-full rounded object-cover">

            <h1 class="mb-2 text-4xl font-bold">
                {{ $blog->title }}
            </h1>

            <p class="mb-6 text-gray-500">
                Written by {{ $blog->user?->name ?? 'Unknown author' }}
            </p>

            <p class="whitespace-pre-line text-lg">
                {{ $blog->content }}
            </p>

        </div>

    </div>

</x-guest-layout>