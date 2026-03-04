@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Audit Logs</h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
            Immutable record of every admin action
        </p>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="mb-5 flex flex-wrap items-end gap-3">
    {{-- Action --}}
    <div>
        <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">Action</label>
        <select name="action"
            class="h-9 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 focus:border-brand-300 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
            <option value="">All actions</option>
            @foreach($actions as $action)
            <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                {{ ucfirst(str_replace(['.', '_'], ' ', $action)) }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- Actor --}}
    <div>
        <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">Admin</label>
        <select name="actor_id"
            class="h-9 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 focus:border-brand-300 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
            <option value="">All admins</option>
            @foreach($admins as $admin)
            <option value="{{ $admin->id }}" {{ request('actor_id') == $admin->id ? 'selected' : '' }}>
                {{ $admin->name }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- Date from --}}
    <div>
        <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">From</label>
        <input type="date" name="from" value="{{ request('from') }}"
            class="h-9 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 focus:border-brand-300 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300" />
    </div>

    {{-- Date to --}}
    <div>
        <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">To</label>
        <input type="date" name="to" value="{{ request('to') }}"
            class="h-9 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-700 focus:border-brand-300 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300" />
    </div>

    <button type="submit"
        class="h-9 rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
        Filter
    </button>

    @if(request()->hasAny(['action', 'actor_id', 'from', 'to']))
    <a href="{{ route('audit-logs.index') }}"
        class="h-9 flex items-center rounded-lg border border-gray-300 px-4 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
        Clear
    </a>
    @endif
</form>

{{-- Table --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40">
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">When</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Admin</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Action</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Target</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Changes</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors"
                    x-data="{ expanded: false }">

                    {{-- When --}}
                    <td class="px-5 py-3 whitespace-nowrap">
                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                            {{ $log->created_at->format('M d, Y') }}
                        </p>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">
                            {{ $log->created_at->format('h:i A') }}
                        </p>
                    </td>

                    {{-- Actor --}}
                    <td class="px-5 py-3 whitespace-nowrap">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ $log->actor_name }}
                        </p>
                        @if(!$log->actor_id)
                        <p class="text-[11px] text-gray-400">(deleted)</p>
                        @endif
                    </td>

                    {{-- Action badge --}}
                    <td class="px-5 py-3 whitespace-nowrap">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $log->action_color }}">
                            {{ $log->action_label }}
                        </span>
                    </td>

                    {{-- Target --}}
                    <td class="px-5 py-3">
                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ $log->target_name }}
                        </p>
                        @if($log->target_email)
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">
                            {{ $log->target_email }}
                        </p>
                        @endif
                    </td>

                    {{-- Changes --}}
                    <td class="px-5 py-3 max-w-xs">
                        @if($log->changes)
                        <button @click="expanded = !expanded"
                            class="text-xs font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400">
                            <span x-text="expanded ? 'Hide' : 'Show changes'"></span>
                        </button>
                        <div x-show="expanded" x-transition class="mt-2 space-y-1">
                            @foreach($log->changes as $field => $change)
                            <div class="rounded-lg bg-gray-50 dark:bg-gray-900/50 px-2 py-1.5 text-[11px]">
                                <span class="font-semibold text-gray-600 dark:text-gray-400 uppercase">{{ $field }}</span>
                                @if(isset($change['from']) && isset($change['to']))
                                <div class="mt-0.5 flex items-center gap-1.5 flex-wrap">
                                    <span class="line-through text-red-500">{{ $change['from'] ?? '—' }}</span>
                                    <svg class="h-3 w-3 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    <span class="text-green-600 dark:text-green-400">{{ $change['to'] ?? '—' }}</span>
                                </div>
                                @else
                                <span class="text-gray-500 dark:text-gray-400">{{ json_encode($change) }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <span class="text-xs text-gray-400 dark:text-gray-600">—</span>
                        @endif
                    </td>

                    {{-- IP --}}
                    <td class="px-5 py-3 text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap font-mono">
                        {{ $log->ip_address ?? '—' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-14 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">No logs yet</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                Actions will appear here as admins use the system.
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
    <div class="border-t border-gray-100 dark:border-gray-700 px-5 py-4">
        {{ $logs->links() }}
    </div>
    @endif
</div>

@endsection