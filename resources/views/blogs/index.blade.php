<x-app-layout>

    <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
        rel="stylesheet">

    <x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            Manage Blogs
        </h2>
        <a
            href="{{ route('dashboard') }}"
            class="rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">
            Back to Dashboard
        </a>
    </div>
</x-slot>
    <div class="p-8">

        <div class="mb-6 flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-bold">
                    Blog Management
                </h1>

                <p class="text-gray-600">
                    Create and manage blog posts.
                </p>

            </div>

            <a
                href="{{ route('blogs.create') }}"
                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                Create Blog
            </a>

        </div>

        @if (session('success'))

            <div class="mb-4 rounded bg-green-100 p-3 text-green-700">
                {{ session('success') }}
            </div>

        @endif

        <div class="overflow-x-auto rounded border bg-white shadow">

            <table class="w-full text-left text-sm">

                <thead class="border-b bg-gray-100">

                    <tr>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Blog</th>
                        <th class="px-4 py-3">Author</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Views</th>
                        <th class="px-4 py-3">Likes</th>
                        <th class="px-4 py-3">Comments</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($blogs as $blog)

                        <tr class="border-b align-top">

                            <td class="px-4 py-4">

                                <img
                                    src="{{ asset('images/' . $blog->image) }}"
                                    alt="{{ $blog->title }}"
                                    class="h-16 w-16 rounded object-cover">

                            </td>

                            <td class="px-4 py-4">

                                <p class="font-semibold">
                                    {{ $blog->title }}
                                </p>

                                <div class="ql-snow mt-2">

                                    <div class="ql-editor max-h-40 overflow-hidden p-0">
                                        {!! $blog->content !!}
                                    </div>

                                </div>

                            </td>

                            <td class="px-4 py-4">
                                {{ $blog->user?->name ?? 'Unknown' }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $blog->categoryData?->name ?? 'No category' }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $blog->views }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $blog->likes_count }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $blog->comments_count }}
                            </td>

                            <td class="px-4 py-4">

                                @if ($blog->status === 'approved')

                                    <span class="rounded bg-green-100 px-3 py-1 text-green-700">
                                        Approved
                                    </span>

                                @elseif ($blog->status === 'rejected')

                                    <span class="rounded bg-red-100 px-3 py-1 text-red-700">
                                        Rejected
                                    </span>

                                @else

                                    <span class="rounded bg-yellow-100 px-3 py-1 text-yellow-700">
                                        Pending
                                    </span>

                                @endif

                            </td>

                            <td class="px-4 py-4">

                                <div class="flex flex-wrap gap-2">

                                    <a
                                        href="{{ route('blogs.edit', $blog) }}"
                                        class="rounded bg-yellow-500 px-3 py-2 text-white">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('blogs.destroy', $blog) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded bg-red-600 px-3 py-2 text-white"
                                            onclick="return confirm('Delete this blog?')">
                                            Delete
                                        </button>

                                    </form>

                                    @role('admin')

                                        @if ($blog->status !== 'approved')

                                            <form
                                                action="{{ route('blogs.approve', $blog) }}"
                                                method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded bg-green-600 px-3 py-2 text-white">
                                                    Approve
                                                </button>

                                            </form>

                                        @endif

                                        @if ($blog->status !== 'rejected')

                                            <form
                                                action="{{ route('blogs.reject', $blog) }}"
                                                method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded bg-gray-700 px-3 py-2 text-white">
                                                    Reject
                                                </button>

                                            </form>

                                        @endif

                                    @endrole

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="px-5 py-8 text-center text-gray-500">
                                No blogs found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>