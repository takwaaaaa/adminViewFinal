@extends('layouts.app')

@section('content')

@php
    use App\Models\User;
    use Spatie\Permission\Models\Role;

    $user         = auth()->user();
    $isSuperAdmin = $user->isSuperAdmin();

    $totalUsers    = User::where('role', '!=', 'superadmin')->count();
    $activeUsers   = User::where('role', '!=', 'superadmin')->where('status', 'active')->count();
    $inactiveUsers = User::where('role', '!=', 'superadmin')->where('status', 'inactive')->count();
    $totalRoles    = Role::where('name', '!=', 'superadmin')->count();

    $recentUsers = User::where('role', '!=', 'superadmin')
        ->with('roles')
        ->latest()
        ->take(8)
        ->get();
@endphp

{{-- ── Stats Cards ────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">

    {{-- Total Users --}}
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/10">
                <svg class="h-5 w-5 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
            </div>
            @if($isSuperAdmin || $user->hasPermissionTo('consult_user_list'))
            <a href="{{ route('users.index') }}" class="text-xs text-brand-500 hover:text-brand-600 font-medium">View all →</a>
            @endif
        </div>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalUsers }}</p>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Total Users</p>
    </div>

    {{-- Active Users --}}
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 dark:bg-green-500/10">
                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $activeUsers }}</p>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Active Users</p>
    </div>

    {{-- Inactive Users --}}
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 dark:bg-red-500/10">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $inactiveUsers }}</p>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Inactive Users</p>
    </div>

    {{-- Total Roles --}}
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 dark:bg-purple-500/10">
                <svg class="h-5 w-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 1.667L3.333 4.167v5c0 4.917 3.334 8.583 6.667 9.333 3.333-.75 6.667-4.416 6.667-9.333v-5L10 1.667zm3.09 6.416a1 1 0 00-1.414-1.414L9 9.252 7.923 8.174a1 1 0 00-1.414 1.414l1.667 1.667a1 1 0 001.414 0l3.5-3.172z" clip-rule="evenodd"/>
                </svg>
            </div>
            @if($isSuperAdmin || $user->hasPermissionTo('consult_roles_list'))
            <a href="{{ route('roles.index') }}" class="text-xs text-brand-500 hover:text-brand-600 font-medium">Manage →</a>
            @endif
        </div>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalRoles }}</p>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Active Roles</p>
    </div>
</div>

{{-- ── Recent Users + Quick Actions ───────────────────────────────────────── --}}
<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

    {{-- Recent Users Table --}}
    <div class="xl:col-span-2 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Recent Users</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Latest added users</p>
            </div>
            @if($isSuperAdmin || $user->hasPermissionTo('create_user'))
            <a href="{{ route('users.create') }}"
                class="inline-flex items-center gap-1.5 rounded-lg bg-brand-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-brand-600 transition-colors">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add User
            </a>
            @endif
        </div>

        @if($recentUsers->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">No users yet.</p>
            @if($isSuperAdmin || $user->hasPermissionTo('create_user'))
            <a href="{{ route('users.create') }}" class="mt-3 text-xs text-brand-500 hover:underline font-medium">Add your first user</a>
            @endif
        </div>
        @else
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($recentUsers as $u)
            <div class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border border-gray-200 dark:border-gray-600">
                    <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="h-full w-full object-cover" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $u->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $u->email }}</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @if($u->roles->isNotEmpty())
                    <span class="inline-flex items-center rounded px-2 py-0.5 text-[11px] font-medium bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-400 capitalize">
                        {{ $u->roles->first()->name }}
                    </span>
                    @endif
                    <span class="inline-flex items-center rounded px-2 py-0.5 text-[11px] font-medium
                        {{ $u->status === 'active'
                            ? 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400'
                            : 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400' }}">
                        {{ ucfirst($u->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @if($isSuperAdmin || $user->hasPermissionTo('consult_user_list'))
        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700">
            <a href="{{ route('users.index') }}" class="text-xs text-brand-500 hover:text-brand-600 font-medium">View all users →</a>
        </div>
        @endif
        @endif
    </div>

    {{-- Quick Actions + Roles Overview --}}
    <div class="flex flex-col gap-6">

        {{-- Quick Actions --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Quick Actions</h3>
            <div class="flex flex-col gap-2">

                @if($isSuperAdmin || $user->hasPermissionTo('create_user'))
                <a href="{{ route('users.create') }}"
                    class="flex items-center gap-3 rounded-xl border border-gray-100 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 dark:bg-brand-500/10">
                        <svg class="h-4 w-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    Add New User
                </a>
                @endif

                @if($isSuperAdmin || $user->hasPermissionTo('create_role'))
                <a href="{{ route('roles.create') }}"
                    class="flex items-center gap-3 rounded-xl border border-gray-100 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 dark:bg-purple-500/10">
                        <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    Create New Role
                </a>
                @endif

                @if($isSuperAdmin || $user->hasPermissionTo('consult_logs'))
                <a href="{{ route('audit-logs.index') }}"
                    class="flex items-center gap-3 rounded-xl border border-gray-100 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-50 dark:bg-orange-500/10">
                        <svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    View Audit Logs
                </a>
                @endif

                {{-- Fallback if user has no actions available --}}
                @if(!$isSuperAdmin && !$user->hasAnyPermission(['create_user','create_role','consult_logs']))
                <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-2">No quick actions available.</p>
                @endif
            </div>
        </div>

        {{-- Roles Overview --}}
        @if($isSuperAdmin || $user->hasPermissionTo('consult_roles_list'))
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 flex-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Roles Overview</h3>
                <a href="{{ route('roles.index') }}" class="text-xs text-brand-500 hover:text-brand-600 font-medium">Manage →</a>
            </div>
            @php $roles = \Spatie\Permission\Models\Role::where('name', '!=', 'superadmin')->withCount('users')->get(); @endphp
            @forelse($roles as $role)
            <div class="flex items-center justify-between py-2.5 border-b border-gray-100 dark:border-gray-700 last:border-0">
                <span class="text-sm text-gray-700 dark:text-gray-300 capitalize">{{ $role->name }}</span>
                <span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-700 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:text-gray-300">
                    {{ $role->users_count }} {{ Str::plural('user', $role->users_count) }}
                </span>
            </div>
            @empty
            <p class="text-xs text-gray-400 text-center py-4">No roles created yet.</p>
            @endforelse
        </div>
        @endif

    </div>
</div>

@endsection