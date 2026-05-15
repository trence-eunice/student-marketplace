<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Users</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left px-4 py-3">Name</th>
                            <th class="text-left px-4 py-3">Email</th>
                            <th class="text-left px-4 py-3">Role</th>
                            <th class="text-left px-4 py-3">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs
                                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' :
                                      ($user->role === 'seller' ? 'bg-blue-100 text-blue-700' :
                                       'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-3 text-gray-500">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $users->links() }}</div>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="mt-4 inline-block text-blue-600">← Back to Dashboard</a>
        </div>
    </div>
</x-app-layout>
