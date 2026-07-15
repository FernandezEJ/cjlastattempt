<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Edit Blog
        </h2>
    </x-slot>

    <link
        href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
        rel="stylesheet">

    <div class="mx-auto max-w-3xl p-8">

        <div class="rounded-lg border bg-white p-6 shadow">

            <h1 class="mb-6 text-2xl font-bold">
                Edit Blog
            </h1>

            @if ($errors->any())

                <div class="mb-5 rounded bg-red-100 p-4 text-red-700">

                    <ul class="list-inside list-disc">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                id="blog-form"
                action="{{ route('blogs.update', $blog) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-5">

                    <p class="mb-2 font-semibold">
                        Current Image
                    </p>

                    <img
                        src="{{ asset('images/' . $blog->image) }}"
                        alt="{{ $blog->title }}"
                        class="mb-4 h-40 w-40 rounded object-cover">

                    <label
                        for="image"
                        class="mb-2 block font-semibold">
                        New Image
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        class="w-full rounded border border-gray-300 p-2">

                </div>

                <div class="mb-5">

                    <label
                        for="title"
                        class="mb-2 block font-semibold">
                        Title
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $blog->title) }}"
                        class="w-full rounded border border-gray-300"
                        required>

                </div>

                <div class="mb-5">

                    <label
                        for="category_id"
                        class="mb-2 block font-semibold">
                        Category
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full rounded border border-gray-300"
                        required>

                        <option value="">
                            Select a category
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old('category_id', $blog->category_id)
                                    == $category->id
                                )>
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-6">

                    <label class="mb-2 block font-semibold">
                        Content
                    </label>

                    <div id="toolbar">

                        <select class="ql-header">
                            <option selected></option>
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                        </select>

                        <button type="button" class="ql-bold"></button>
                        <button type="button" class="ql-italic"></button>
                        <button type="button" class="ql-underline"></button>
                        <button type="button" class="ql-strike"></button>

                        <button
                            type="button"
                            class="ql-list"
                            value="ordered">
                        </button>

                        <button
                            type="button"
                            class="ql-list"
                            value="bullet">
                        </button>

                        <button
                            type="button"
                            class="ql-blockquote">
                        </button>

                        <select class="ql-align"></select>

                        <button
                            type="button"
                            class="ql-clean">
                        </button>

                    </div>

                    <div
                        id="editor"
                        class="min-h-64 bg-white">
                        {!! old('content', $blog->content) !!}
                    </div>

                    <input
                        type="hidden"
                        id="content"
                        name="content"
                        value="{{ old('content', $blog->content) }}">

                </div>

                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                        Update Blog
                    </button>

                    <a
                        href="{{ route('blogs.index') }}"
                        class="rounded bg-gray-500 px-5 py-2 text-white hover:bg-gray-600">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>

    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: '#toolbar'
            },
            placeholder: 'Write your blog content here...'
        });

        const blogForm = document.getElementById('blog-form');
        const contentInput = document.getElementById('content');

        blogForm.addEventListener('submit', function (event) {
            const plainText = quill.getText().trim();

            if (plainText === '') {
                event.preventDefault();
                alert('Please enter your blog content.');
                return;
            }

            contentInput.value = quill.root.innerHTML;
        });
    </script>

</x-app-layout>