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

<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
        Permissions for <span class="text-brand-500 capitalize">{{ $role->name }}</span>
    </h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        Check the permissions this role should have access to.
    </p>
</div>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
    class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-700/30 dark:bg-green-900/20 dark:text-green-400">
    <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('roles.permissions.update', $role) }}">
    @csrf @method('PATCH')

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

        @foreach($allPermissions as $group => $permissions)
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">

            {{-- Group header --}}
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">{{ $group }}</h3>
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="checkbox"
                        class="group-toggle h-3.5 w-3.5 rounded border-gray-300 text-brand-500 focus:ring-brand-500"
                        data-group="{{ Str::slug($group) }}"
                        title="Toggle all in {{ $group }}" />
                    <span class="text-xs text-gray-400">All</span>
                </label>
            </div>

            {{-- Permission checkboxes --}}
            <div class="space-y-2.5">
                @foreach($permissions as $label => $slug)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input
                        type="checkbox"
                        name="permissions[]"
                        value="{{ $slug }}"
                        data-group="{{ Str::slug($group) }}"
                        {{ $role->hasPermissionTo($slug) ? 'checked' : '' }}
                        class="perm-checkbox h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600"
                    />
                    <span class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                        {{ $label }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>

    <div class="mt-6 flex items-center justify-end gap-3">
        <a href="{{ route('roles.index') }}"
            class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
            Cancel
        </a>
        <button type="submit"
            class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
            Save Permissions
        </button>
    </div>
</form>

<script>
// "All" toggle per group
document.querySelectorAll('.group-toggle').forEach(toggle => {
    const group = toggle.dataset.group;
    const boxes = document.querySelectorAll(`.perm-checkbox[data-group="${group}"]`);

    // Set initial state
    toggle.checked = [...boxes].every(b => b.checked);
    toggle.indeterminate = !toggle.checked && [...boxes].some(b => b.checked);

    toggle.addEventListener('change', () => {
        boxes.forEach(b => b.checked = toggle.checked);
    });

    boxes.forEach(b => b.addEventListener('change', () => {
        toggle.checked = [...boxes].every(b => b.checked);
        toggle.indeterminate = !toggle.checked && [...boxes].some(b => b.checked);
    }));
});
</script>

@endsection