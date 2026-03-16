@php
    use App\Models\AdminNotification;
    $notifications = AdminNotification::with('user')
        ->latest()
        ->take(10)
        ->get();
    $unreadCount = AdminNotification::where('is_read', false)->count();
@endphp

<div class="relative"
    x-data="{ isOpen: false }"
    @click.away="isOpen = false"
    style="position: relative;">

    {{-- Bell button --}}
    <button
        class="relative flex items-center justify-center text-gray-500 dark:text-gray-400 transition-colors bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 h-11 w-11"
        style="overflow: visible;"
        @click="isOpen = !isOpen"
        aria-label="Notifications">
        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 2a6 6 0 00-6 6v1.5c0 .414-.168.789-.44 1.06L2.22 11.9A1 1 0 003 13.5h14a1 1 0 00.78-1.6l-1.34-1.34A1.5 1.5 0 0116 9.5V8a6 6 0 00-6-6zm0 16a2 2 0 01-2-2h4a2 2 0 01-2 2z"/>
        </svg>

        @if($unreadCount > 0)
        <span style="position: absolute; top: -6px; right: -6px; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; border-radius: 9999px; background: #3b82f6; color: white; font-size: 10px; font-weight: 700; line-height: 1; padding: 0 4px; border: 2px solid white; z-index: 10;">
            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
        @endif
    </button>

    {{-- Dropdown panel --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute right-0 mt-2 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl"
        style="display:none; width:360px; top:100%; z-index:999999;">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 px-4 py-3">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-800 dark:text-white">Notifications</span>
                @if($unreadCount > 0)
                <span class="inline-flex items-center rounded-full bg-brand-100 px-2 py-0.5 text-[10px] font-semibold text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">
                    {{ $unreadCount }} new
                </span>
                @endif
            </div>
            @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                @csrf
                <button type="submit" class="text-xs font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400">
                    Mark all read
                </button>
            </form>
            @endif
        </div>

        {{-- List --}}
        <div class="max-h-72 overflow-y-auto">
            @forelse($notifications as $notification)
            <div class="flex items-start gap-3 border-b border-gray-100 dark:border-gray-700/50 px-4 py-3 transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/30
                {{ !$notification->is_read ? 'bg-brand-50/40 dark:bg-brand-500/5' : '' }}">

                {{-- Avatar --}}
                <div class="relative shrink-0">
                    <div class="h-8 w-8 overflow-hidden rounded-full border border-gray-200 dark:border-gray-600">
                        @if($notification->user)
                            <img src="{{ $notification->user->avatar_url }}"
                                 alt="{{ $notification->user->name }}"
                                 class="h-full w-full object-cover" />
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-brand-100 dark:bg-brand-500/20">
                                <svg class="h-4 w-4 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    @if(!$notification->is_read)
                    <span class="absolute -top-0.5 -right-0.5 h-2 w-2 rounded-full border border-white dark:border-gray-800 bg-brand-500"></span>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <p class="text-xs leading-relaxed text-gray-700 dark:text-gray-300">
                        {{ $notification->message }}
                    </p>
                    <div class="mt-1 flex items-center gap-2 flex-wrap">
                        @php
                            $typeColors = [
                                'new_signup'          => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'account_approved'    => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                'account_rejected'    => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                'account_deactivated' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                'account_activated'   => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            ];
                            $typeLabels = [
                                'new_signup'          => 'New Sign Up',
                                'account_approved'    => 'Approved',
                                'account_rejected'    => 'Rejected',
                                'account_deactivated' => 'Deactivated',
                                'account_activated'   => 'Activated',
                            ];
                            $colorClass = $typeColors[$notification->type] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300';
                            $typeLabel  = $typeLabels[$notification->type] ?? ucfirst(str_replace('_', ' ', $notification->type));
                        @endphp
                        <span class="inline-flex items-center rounded px-1.5 py-0.5 text-[10px] font-semibold {{ $colorClass }}">
                            {{ $typeLabel }}
                        </span>
                        <span class="text-[11px] text-gray-400 dark:text-gray-500">
                            {{ $notification->time_ago }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">No notifications</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">You're all caught up!</p>
            </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if($notifications->count() > 0 && auth()->check() && auth()->user()->isSuperAdmin())
        <div class="border-t border-gray-100 dark:border-gray-700 px-4 py-2.5">
            <a href="{{ route('users.index') }}"
                class="flex w-full items-center justify-center gap-1 text-xs font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400">
                View pending approvals
                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
</div>