<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Users</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="page-title">Manage Users</h1>
                    <p class="page-subtitle">All registered users on the platform.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn-outline px-4 py-2 rounded-lg text-sm font-semibold">
                    ← Dashboard
                </a>
            </div>

            
            

            <div class="card rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background: var(--border)">
                            <th class="text-left px-4 py-3">Name</th>
                            <th class="text-left px-4 py-3">Email</th>
                            <th class="text-left px-4 py-3">Role</th>
                            <th class="text-left px-4 py-3">Status</th>
                            <th class="text-left px-4 py-3">Joined</th>
                            <th class="text-left px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-b transition hover:bg-gray-50" style="border-color: var(--border)">
                            <td class="px-4 py-3 font-semibold">{{ $user->name }}</td>
                            <td class="px-4 py-3" style="color: var(--muted)">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-1 rounded-full font-semibold
                                    @if($user->role === 'admin') badge-danger
                                    @elseif($user->role === 'seller') badge-info
                                    @else badge-success
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->is_suspended)
                                    <span class="badge-danger text-xs">Suspended</span>
                                @else
                                    <span class="badge-success text-xs">Active</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm" style="color: var(--muted)">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                @if($user->role !== 'admin')
                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}"
                                      onsubmit="return confirm('{{ $user->is_suspended ? 'Reactivate' : 'Suspend' }} {{ $user->name }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="{{ $user->is_suspended ? 'btn-outline' : 'btn-danger' }} px-3 py-1 rounded-lg text-xs font-semibold">
                                        {{ $user->is_suspended ? 'Reactivate' : 'Suspend' }}
                                    </button>
                                </form>
                                @else
                                    <span class="text-xs" style="color: var(--muted)">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center" style="color: var(--muted)">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $users->links() }}</div>
            </div>

        </div>
    </div>
</x-app-layout>
