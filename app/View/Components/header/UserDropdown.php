{{-- resources/views/components/header/user-dropdown.blade.php --}}
@php $user = auth()->user(); @endphp

<div class="relative" x-data="{
    dropdownOpen: false,
    toggleDropdown() { this.dropdownOpen = !this.dropdownOpen; },
    closeDropdown() { this.dropdownOpen = false; }
}" @click.away="closeDropdown()">

    <!-- User Button -->
    <button class="flex items-center text-gray-700 dark:text-gray-300"
        @click.prevent="toggleDropdown()" type="button">
        <span class="mr-3 overflow-hidden rounded-full h-11 w-11 border border-gray-200 dark:border-gray-600">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-full w-full object-cover" />
        </span>
        <span class="block mr-1 font-medium text-theme-sm">{{ $user->first_name }}</span>
        <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': dropdownOpen }"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown -->
    <div x-show="dropdownOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 shadow-lg z-50"
        style="display: none;">

        <!-- User Info -->
        <div class="mb-3">
            <span class="block font-medium text-gray-700 dark:text-white text-theme-sm">{{ $user->name }}</span>
            <span class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</span>
        </div>

        <!-- Menu Items -->
        <ul class="flex flex-col gap-1 pt-3 pb-3 border-t border-b border-gray-200 dark:border-gray-700">
            <li>
                <a href="{{ route('profile') }}"
                    class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 dark:text-gray-300 rounded-lg group text-theme-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Edit profile
                </a>
            </li>
        </ul>

        <!-- Sign Out -->
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" @click="closeDropdown()"
                class="flex items-center w-full gap-3 px-3 py-2 font-medium text-gray-700 dark:text-gray-300 rounded-lg group text-theme-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700 dark:group-hover:text-white"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign out
            </button>
        </form>
    </div>
</div>