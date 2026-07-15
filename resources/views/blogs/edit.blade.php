<x-guest-layout>
    <div class="p-4 mt-4">
        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Current Image
                </label>

                <img src="{{ asset('images/' . $blog->image) }}"
                     class="w-40 mb-2">

                <input type="file" name="image" class="mt-1 block w-full">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Title
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $blog->title) }}"
                    class="mt-1 block w-full">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Content
                </label>

                <textarea
                    name="content"
                    class="mt-1 block w-full">{{ old('content', $blog->content) }}</textarea>
            </div>

            <x-primary-button>
                Update Blog
            </x-primary-button>

        </form>
    </div>
</x-guest-layout>