
<?php $user = auth()->user(); ?>

<div class="p-5 mb-6 border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-2xl lg:p-6">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white lg:mb-6">
                Personal Information
            </h4>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">First Name</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white"><?php echo e($user->first_name); ?></p>
                </div>

                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Last Name</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white"><?php echo e($user->last_name); ?></p>
                </div>

                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Email address</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white"><?php echo e($user->email); ?></p>
                </div>

                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Phone</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        <?php echo e($user->phone ?? '—'); ?>

                    </p>
                </div>

                <div>
                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Bio</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        <?php echo e($user->bio ?? '—'); ?>

                    </p>
                </div>
            </div>
        </div>

        
        <a href="<?php echo e(route('profile')); ?>"
            class="flex w-full items-center justify-center gap-2 rounded-full bg-brand-500 border border-brand-500 px-4 py-3 text-sm font-medium text-white shadow-sm hover:bg-brand-600 hover:border-brand-600 transition-colors lg:inline-flex lg:w-auto">
            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206Z"
                    fill="" />
            </svg>
            Edit
        </a>
    </div>
</div><?php /**PATH C:\laragon\www\AdminView\resources\views/components/profile/personal-info-card.blade.php ENDPATH**/ ?>