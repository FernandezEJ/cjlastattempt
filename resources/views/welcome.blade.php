<x-guest-layout>

    <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
        rel="stylesheet">

    <div class="flex items-center justify-between p-6">

        <a href="{{ route('home') }}" class="text-2xl font-bold">
            MY BLOGS
        </a>

        <div class="flex gap-3">

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

    </div>

    <div class="mx-auto max-w-7xl px-6 pb-10">

        <h1 class="mb-8 text-center text-4xl font-bold">
            Latest Blog Posts
        </h1>

        <form
            action="{{ route('home') }}"
            method="GET"
            class="mb-8 rounded-lg border bg-white p-5 shadow">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                <div>
                    <label for="search" class="mb-2 block font-semibold">
                        Search
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search title or author"
                        class="w-full rounded border border-gray-300">
                </div>

                <div>
                    <label for="category" class="mb-2 block font-semibold">
                        Category
                    </label>

                    <select
                        id="category"
                        name="category"
                        class="w-full rounded border border-gray-300">

                        <option value="">
                            All Categories
                        </option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(request('category') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                        Search
                    </button>

                    <a href="{{ route('home') }}"
                        class="rounded bg-gray-500 px-5 py-2 text-white hover:bg-gray-600">
                        Clear
                    </a>
                </div>

            </div>

        </form>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">

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

                    @if ($blog->categoryData)

                        <a
                            href="{{ route('home', ['category' => $blog->categoryData->id]) }}"
                            class="mt-3 inline-block rounded bg-blue-100 px-3 py-1 text-sm text-blue-700 hover:bg-blue-200">
                            {{ $blog->categoryData->name }}
                        </a>

                    @endif

                    <div class="ql-snow mt-3">
                        <div class="ql-editor max-h-48 overflow-hidden p-0">
                            {!! $blog->content !!}
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-3 text-xs text-gray-600">
                        <span>👁 {{ $blog->views }}</span>
                        <span>❤️ {{ $blog->likes_count }}</span>
                        <span>💬 {{ $blog->comments_count }}</span>
                    </div>

                    <a
                        href="{{ route('blogs.show', $blog) }}"
                        class="mt-4 inline-block rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
                        Read More
                    </a>

                </div>

            @empty

                <div class="col-span-full rounded bg-white p-10 text-center shadow">
                    <p class="text-xl font-semibold text-gray-600">
                        No approved blogs found.
                    </p>
                </div>

            @endforelse

        </div>

        @if ($blogs->hasPages())
            <div class="mt-10">
                {{ $blogs->links() }}
            </div>
        @endif

    </div>

</x-guest-layout>