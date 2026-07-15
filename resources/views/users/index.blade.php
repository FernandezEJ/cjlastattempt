<x-app-layout>

     <x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
            Manage Users
        </h2>
        <a
            href="{{ route('dashboard') }}"
            class="rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">
            Back to Dashboard
        </a>
    </div>
</x-slot>

    <div class="p-8">

        <div class="mb-6">

            <h1 class="text-2xl font-bold">
                Registered Users
            </h1>

            <p class="text-gray-600">
                Change a user into an author.
            </p>

        </div>

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

        <div class="overflow-x-auto rounded border bg-white shadow">

            <table class="w-full text-left text-sm">

                <thead class="border-b bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Current Role</th>
                        <th class="px-6 py-3">Change Role</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($users as $user)

                        <tr class="border-b">

                            <td class="px-6 py-4">
                                {{ $user->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4">
                                {{ ucfirst($user->getRoleNames()->first() ?? 'No role') }}
                            </td>

                            <td class="px-6 py-4">

                                @if ($user->hasRole('admin'))

                                    <span class="font-semibold text-gray-500">
                                        Admin account
                                    </span>

                                @else

                                    <form
                                        action="{{ route('users.updateRole', $user) }}"
                                        method="POST"
                                        class="flex items-center gap-2">

                                        @csrf
                                        @method('PATCH')

                                        <select
                                            name="role"
                                            class="rounded border-gray-300">

                                            <option value="user"
                                                @selected($user->hasRole('user'))>
                                                User
                                            </option>

                                            <option value="author"
                                                @selected($user->hasRole('author'))>
                                                Author
                                            </option>

                                        </select>

                                        <button
                                            type="submit"
                                            class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                                            Save
                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4"
                                class="px-6 py-8 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>