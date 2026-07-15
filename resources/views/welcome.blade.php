<x-guest-layout>

    {{-- Quill styles --}}
    <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    {{-- Top navigation --}}
    <div class="flex items-center justify-between p-6">

        <a
            href="{{ route('home') }}"
            class="text-2xl font-bold">
            BLOGS POST
        </a>

        <div class="flex gap-3">

            @auth

                <a
                    href="{{ route('dashboard') }}"
                    class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
                    Dashboard
                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
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

        {{-- Search and category filter --}}
        <form
            action="{{ route('home') }}"
            method="GET"
            class="mb-8 rounded-lg border bg-white p-5 shadow">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                {{-- Search --}}
                <div>

                    <label
                        for="search"
                        class="mb-2 block font-semibold">
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

                {{-- Category --}}
                <div>

                    <label
                        for="category"
                        class="mb-2 block font-semibold">
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

                {{-- Search buttons --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="flex items-center gap-2 rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">

                        <i class="bi bi-search"></i>

                        Search

                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="flex items-center gap-2 rounded bg-red-600 px-5 py-2 text-white hover:bg-red-900">

                        <i class="bi bi-x-circle"></i>

                        Clear

                    </a>

                </div>

            </div>

        </form>

        {{-- Search result --}}
        @if (request('search') || request('category'))

            <div class="mb-5 rounded bg-blue-50 p-4 text-blue-700">

                Found {{ $blogs->total() }}

                @if ($blogs->total() === 1)
                    blog post.
                @else
                    blog posts.
                @endif

            </div>

        @endif

        {{-- Blog cards --}}
        <div class="grid grid-cols-1 items-stretch gap-6 md:grid-cols-2 lg:grid-cols-4">

            @forelse ($blogs as $blog)

                <div class="flex h-full flex-col rounded-lg border bg-white p-4 shadow">

                    {{-- Blog image --}}
                    <img
                        src="{{ asset('images/' . $blog->image) }}"
                        alt="{{ $blog->title }}"
                        class="h-48 w-full rounded object-cover">

                    {{-- Blog title --}}
                    <h2 class="mt-4 min-h-14 text-xl font-bold">
                        {{ $blog->title }}
                    </h2>

                    {{-- Author --}}
                    <p class="mt-1 flex items-center gap-2 text-sm text-gray-500">

                        <i class="bi bi-person-fill"></i>

                        {{ $blog->user?->name ?? 'Unknown author' }}

                    </p>

                    {{-- Category --}}
                    <div class="min-h-12">

                        @if ($blog->categoryData)

                            <a
                                href="{{ route('home', ['category' => $blog->categoryData->id]) }}"
                                class="mt-3 inline-flex items-center gap-2 rounded bg-blue-100 px-3 py-1 text-sm text-blue-700 hover:bg-blue-200">

                                <i class="bi bi-bookmark-fill"></i>

                                {{ $blog->categoryData->name }}

                            </a>

                        @endif

                    </div>

                    {{-- Fixed rich-text preview --}}
                    <div class="ql-snow mt-3 h-48 overflow-hidden">

                        <div class="ql-editor h-full overflow-hidden p-0">
                            {!! $blog->content !!}
                        </div>

                    </div>

                    {{-- Bottom section --}}
                    <div class="mt-auto pt-4">

                        {{-- Views, likes, and comments --}}
                        <div class="grid grid-cols-3 gap-2 border-t pt-4 text-center text-sm text-gray-600">

                            <span class="flex flex-col items-center gap-1">
                                <span>
                                    <div class="text-lg">{{ $blog->views }}</div>
                                    <i class="bi bi-eye-fill text-lg text-blue-500"></i>
                                </span>

                                <span class="text-xs">
                                    Views
                                </span>

                            </span>

                            <span class="flex flex-col items-center gap-1">
                                <span>
                                    <div class="text-lg">{{ $blog->likes_count }}</div>
                                    <i class="bi bi-heart-fill text-lg text-red-500"></i>
                                </span>

                                <span class="text-xs">
                                    Likes
                                </span>

                            </span>

                            <span class="flex flex-col items-center gap-1">

                                <span>
                                    <div class="text-lg">{{ $blog->comments_count }}</div>
                                    <i class="bi bi-chat-left-text-fill text-lg text-green-500"></i>
                                </span>

                                <span class="text-xs">
                                    Comments
                                </span>

                            </span>

                        </div>

                        {{-- Read More button --}}
                        <a
                            href="{{ route('blogs.show', $blog) }}"
                            class="mt-4 flex w-full items-center justify-center gap-2 rounded bg-blue-500 px-4 py-2 text-center text-white hover:bg-blue-600">

                            <i class="bi bi-book"></i>

                            Read More

                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-full rounded bg-white p-10 text-center shadow">

                    <i class="bi bi-journal-x text-5xl text-gray-400"></i>

                    <p class="mt-4 text-xl font-semibold text-gray-600">
                        No approved blogs found.
                    </p>

                    <p class="mt-2 text-gray-500">
                        Try changing your search or category.
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="mt-4 inline-flex items-center gap-2 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">

                        <i class="bi bi-arrow-clockwise"></i>

                        Show All Blogs

                    </a>

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($blogs->hasPages())

            <div class="mt-10">
                {{ $blogs->links() }}
            </div>

        @endif

    </div>

</x-guest-layout>