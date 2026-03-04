<?php $user = auth()->user(); ?>

<div class="relative" x-data="{
    dropdownOpen: false,
    toggleDropdown() { this.dropdownOpen = !this.dropdownOpen; },
    closeDropdown() { this.dropdownOpen = false; }
}" @click.away="closeDropdown()">

    <!-- User Button -->
    <button class="flex items-center gap-2 text-gray-700 dark:text-gray-300"
        @click.prevent="toggleDropdown()" type="button">

        
        <span class="block h-10 w-10 shrink-0 overflow-hidden rounded-full border border-gray-200 dark:border-gray-600">
            <img src="<?php echo e($user->avatar_url); ?>"
                 alt="<?php echo e($user->name); ?>"
                 class="h-full w-full object-cover" />
        </span>

        <span class="hidden xl:block text-sm font-medium"><?php echo e($user->first_name); ?></span>

        <svg class="hidden xl:block w-4 h-4 transition-transform duration-200 shrink-0"
             :class="{ 'rotate-180': dropdownOpen }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
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
        class="absolute right-0 mt-3 w-64 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl z-50"
        style="display: none;">

        
        <div class="flex items-center gap-3 border-b border-gray-100 dark:border-gray-700 px-4 py-3.5">
            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-gray-200 dark:border-gray-600">
                <img src="<?php echo e($user->avatar_url); ?>" alt="<?php echo e($user->name); ?>" class="h-full w-full object-cover" />
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-gray-800 dark:text-white"><?php echo e($user->name); ?></p>
                <p class="truncate text-xs text-gray-500 dark:text-gray-400"><?php echo e($user->email); ?></p>
                <?php if($user->isSuperAdmin()): ?>
                <span class="mt-0.5 inline-flex items-center rounded px-1.5 py-0.5 text-[10px] font-semibold uppercase bg-brand-100 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">
                    Admin
                </span>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="py-2">
            <a href="<?php echo e(route('profile')); ?>"
                class="flex items-center gap-3 rounded-lg mx-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Edit Profile
            </a>

            <?php if($user->isSuperAdmin()): ?>
            <a href="<?php echo e(route('users.index')); ?>"
                class="flex items-center gap-3 rounded-lg mx-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="h-4 w-4 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
                User Management
            </a>
            <a href="<?php echo e(route('admin-management.index')); ?>"
                class="flex items-center gap-3 rounded-lg mx-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="h-4 w-4 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Admin Management
            </a>
            <?php endif; ?>
        </div>

        
        <div class="border-t border-gray-100 dark:border-gray-700 p-2">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" @click="closeDropdown()"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\AdminView\resources\views/components/header/user-dropdown.blade.php ENDPATH**/ ?>