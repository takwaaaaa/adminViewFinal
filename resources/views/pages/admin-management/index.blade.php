@extends('layouts.app')

@section('content')

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
    class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-700/30 dark:bg-green-900/20 dark:text-green-400">
    <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="mb-4">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Admins</h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage approved administrator accounts</p>
</div>

<div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40">
                    <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Admin</th>
                    <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Email</th>
                    <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Phone</th>
                    <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Approved</th>
                    <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border border-gray-200 dark:border-gray-600">
                                <img src="{{ $admin->avatar_url }}" alt="{{ $admin->name }}" class="h-full w-full object-cover" />
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white">{{ $admin->name }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $admin->bio ?? 'Admin' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-gray-600 dark:text-gray-300">{{ $admin->email }}</td>
                    <td class="px-5 py-4 text-gray-500 dark:text-gray-400">{{ $admin->phone ?? '—' }}</td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium
                            {{ $admin->status === 'active'
                                ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                                : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $admin->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ ucfirst($admin->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-xs text-gray-400 dark:text-gray-500">
                        {{ $admin->approved_at ? $admin->approved_at->format('M d, Y') : '—' }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="{{ route('admin-management.toggle-status', $admin) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="rounded-lg border px-3 py-1.5 text-xs font-medium transition-colors
                                    {{ $admin->status === 'active'
                                        ? 'border-orange-200 text-orange-600 hover:bg-orange-50 dark:border-orange-700/40 dark:text-orange-400'
                                        : 'border-green-200 text-green-600 hover:bg-green-50 dark:border-green-700/40 dark:text-green-400' }}">
                                    {{ $admin->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <a href="{{ route('admin-management.edit', $admin) }}"
                                class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin-management.destroy', $admin) }}"
                                onsubmit="return confirm('Delete admin {{ addslashes($admin->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 dark:border-red-700/40 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-sm text-gray-400 dark:text-gray-500">
                        No other admins found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($admins->hasPages())
    <div class="border-t border-gray-100 dark:border-gray-700 px-5 py-4">
        {{ $admins->links() }}
    </div>
    @endif
</div>

@endsection