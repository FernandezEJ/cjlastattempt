<x-guest-layout>
    <div class="p-8">
        <div class="mb-6">
            <a href="{{ route('blogs.create') }}" class="">Create Blog</a>
        </div>
            <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Image
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Content
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blog as $blogs)
                            <tr class="bg-neutral-primary border-b border-default">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $blogs->id }}
                                </th>
                                <td class="px-6 py-4">
                                    <img class="" src="{{ asset('images/' . $blogs->image) }}" alt="{{ $blogs->title }}" class="w-16 h-16 object-cover">
                                </td>
                                <td class="px-6 py-4">
                                    {{ $blogs->title }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $blogs->content }}
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('blogs.edit', $blogs->id) }}" class="border border-blue-600 p-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Edit</a>
                                    <form action="{{ route('blogs.destroy', $blogs->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border border-red-600 p-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

    </div>
</x-guest-layout>
