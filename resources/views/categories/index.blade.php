<x-app-layout>

     <x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            Manage Categories
        </h2>
        <a
            href="{{ route('dashboard') }}"
            class="rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">
            Back to Dashboard
        </a>
    </div>
</x-slot>

    <div class="mx-auto max-w-5xl p-8">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            {{-- Add category form --}}
            <div class="rounded-lg border bg-white p-6 shadow">

                <h1 class="mb-4 text-xl font-bold">
                    Add Category
                </h1>

                <form
                    action="{{ route('categories.store') }}"
                    method="POST">

                    @csrf

                    <div class="mb-4">

                        <label
                            for="name"
                            class="mb-2 block font-semibold">
                            Category Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Example: Mystery"
                            class="w-full rounded border border-gray-300"
                            required>

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <button
                        type="submit"
                        class="w-full rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                        Add Category
                    </button>

                </form>

            </div>

            {{-- Category list --}}
            <div class="md:col-span-2">

                @if (session('success'))

                    <div class="mb-4 rounded bg-green-100 p-3 text-green-700">
                        {{ session('success') }}
                    </div>

                @endif

                @if (session('error'))

                    <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
                        {{ session('error') }}
                    </div>

                @endif

                <div class="overflow-x-auto rounded-lg border bg-white shadow">

                    <table class="w-full text-left text-sm">

                        <thead class="border-b bg-gray-100">

                            <tr>
                                <th class="px-5 py-3">
                                    Category
                                </th>

                                <th class="px-5 py-3">
                                    Blogs
                                </th>

                                <th class="px-5 py-3">
                                    Actions
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($categories as $category)

                                <tr class="border-b">

                                    <td class="px-5 py-4">

                                        <form
                                            action="{{ route('categories.update', $category) }}"
                                            method="POST"
                                            class="flex items-center gap-2">

                                            @csrf
                                            @method('PUT')

                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ $category->name }}"
                                                class="w-full rounded border border-gray-300"
                                                required>

                                            <button
                                                type="submit"
                                                class="rounded bg-yellow-500 px-3 py-2 text-white hover:bg-yellow-600">
                                                Update
                                            </button>

                                        </form>

                                    </td>

                                    <td class="px-5 py-4">
                                        {{ $category->blogs_count }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <form
                                            action="{{ route('categories.destroy', $category) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded bg-red-600 px-3 py-2 text-white hover:bg-red-700"
                                                onclick="return confirm('Delete this category?')">
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="3"
                                        class="px-5 py-8 text-center text-gray-500">
                                        No categories found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>