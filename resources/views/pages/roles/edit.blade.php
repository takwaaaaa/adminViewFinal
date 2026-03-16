@extends('layouts.app')

@section('content')

<div class="mb-5">
    <a href="{{ route('roles.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Roles
    </a>
</div>

<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Edit Role: <span class="capitalize">{{ $role->name }}</span></h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update the role name and its permissions.</p>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <form method="POST" action="{{ route('roles.update', $role) }}">
            @csrf
            @method('PUT')

            @if($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Role Name --}}
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Role Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}"
                    placeholder="e.g. manager"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white @error('name') border-red-500 @enderror" />
            </div>

            {{-- Permissions --}}
            @if($permissions->isNotEmpty())
            <div class="mb-5">
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Permissions
                </label>
                <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                    @foreach($permissions as $permission)
                    <label class="flex items-center gap-2 rounded-lg border border-gray-200 dark:border-gray-600 px-3 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                        <input type="checkbox"
                            name="permissions[]"
                            value="{{ $permission->name }}"
                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" />
                        <span class="capitalize">{{ $permission->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('roles.index') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>

@endsection