<x-guest-layout>

    <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <div class="mx-auto max-w-4xl p-8">

        <a
            href="{{ route('home') }}"
            class="mb-6 inline-block rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">
            Back to Blogs
        </a>

        @if (session('success'))
            <div class="mb-5 rounded bg-green-100 p-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-lg border bg-white p-6 shadow">

            <img
                src="{{ asset('images/' . $blog->image) }}"
                alt="{{ $blog->title }}"
                class="mb-6 h-96 w-full rounded object-cover">

            <h1 class="mb-2 text-4xl font-bold">
                {{ $blog->title }}
            </h1>

            <p class="text-gray-500">
                Written by {{ $blog->user?->name ?? 'Unknown author' }}
            </p>

            @if ($blog->categoryData)
                <a
                    href="{{ route('home', ['category' => $blog->categoryData->id]) }}"
                    class="mt-4 inline-block rounded bg-blue-100 px-3 py-1 text-blue-700">
                    {{ $blog->categoryData->name }}
                </a>
            @endif

            {{-- Blog content --}}
            <div class="ql-snow mt-6">

                <div class="ql-editor p-0 text-lg leading-relaxed border border-gray-300 bg-white">
                    {!! $blog->content !!}
                </div>

            </div>

            {{-- Counts --}}
                    <div class="mt-5 flex items-center gap-6 text-gray-600">

                        <span class="flex items-center gap-1">
                            <div class="text-lg">{{ $blog->views }}</div>
                            <i class="bi bi-eye-fill text-blue-600 text-base"></i>
                        </span>

                        <span class="flex items-center gap-1">
                            <div class="text-lg">{{ $blog->likes_count }}</div>
                            <i class="bi bi-heart-fill text-red-600"></i>
                        </span>

                        <span class="flex items-center gap-1">
                            <div class="text-lg">{{ $blog->comments_count }}</div>
                            <i class="bi bi-chat-left-text-fill text-green-600"></i>
                        </span>

                    </div>

            {{-- Like button --}}
            <div class="mt-5">

                @auth

                    <form
                        action="{{ route('blogs.like', $blog) }}"
                        method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="rounded px-5 py-2 text-white
                                {{ $userHasLiked
                                    ? 'bg-gray-600 hover:bg-gray-700'
                                    : 'bg-red-600 hover:bg-red-700' }}">

                            @if ($userHasLiked)
                                Unlike
                            @else
                                Like
                            @endif

                        </button>

                    </form>

                @else

                    <p class="text-sm text-gray-600">

                        <a
                            href="{{ route('login') }}"
                            class="font-semibold text-blue-600 hover:underline">
                            Login
                        </a>

                        to like this blog.

                    </p>

                @endauth

            </div>

        </div>

        {{-- Comment section --}}
        <div class="mt-8 rounded-lg border bg-white p-6 shadow">

            <h2 class="mb-5 text-2xl font-bold">
                Comments ({{ $blog->comments_count }})
            </h2>

            @auth

                <form
                    action="{{ route('comments.store', $blog) }}"
                    method="POST"
                    class="mb-8">

                    @csrf

                    <label
                        for="comment"
                        class="mb-2 block font-semibold">
                        Add a Comment
                    </label>

                    <textarea
                        id="comment"
                        name="comment"
                        rows="4"
                        maxlength="1000"
                        placeholder="Write your comment..."
                        class="w-full rounded border border-gray-300"
                        required>{{ old('comment') }}</textarea>

                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <button
                        type="submit"
                        class="mt-3 rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                        Post Comment
                    </button>

                </form>

            @else

                <div class="mb-8 rounded bg-gray-100 p-4">

                    <a
                        href="{{ route('login') }}"
                        class="font-semibold text-blue-600 hover:underline">
                        Login
                    </a>

                    to write a comment.

                </div>

            @endauth

            {{-- Comment list --}}
            <div class="space-y-4">

                @forelse ($blog->comments->sortByDesc('created_at') as $comment)

                    <div class="rounded border bg-gray-50 p-4">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="font-bold">
                                    {{ $comment->user?->name ?? 'Deleted user' }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ $comment->created_at->format('M d, Y h:i A') }}
                                </p>

                            </div>

                            @auth

                                @if (
                                    auth()->id() === $comment->user_id
                                    || auth()->user()->hasRole('admin')
                                )

                                    <form
                                        action="{{ route('comments.destroy', $comment) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-sm text-red-600 hover:underline"
                                            onclick="return confirm('Delete this comment?')">
                                            Delete
                                        </button>

                                    </form>

                                @endif

                            @endauth

                        </div>

                        <p class="mt-3 whitespace-pre-line text-gray-700">
                            {{ $comment->comment }}
                        </p>

                    </div>

                @empty

                    <p class="text-gray-500">
                        No comments yet. Be the first to comment.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

</x-guest-layout>