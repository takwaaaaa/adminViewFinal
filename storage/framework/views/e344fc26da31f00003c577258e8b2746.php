

<?php $__env->startSection('content'); ?>
<div class="flex min-h-screen items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
    <div class="w-full max-w-md text-center">
        <div class="mb-6 flex justify-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                <svg class="h-10 w-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <h1 class="mb-3 text-2xl font-semibold text-gray-800 dark:text-white">Account Pending Approval</h1>
        <p class="mb-2 text-gray-500 dark:text-gray-400">
            Hi <strong class="text-gray-700 dark:text-gray-200"><?php echo e(auth()->user()->name); ?></strong>,
        </p>
        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
            Your account has been created and is waiting for a super administrator to approve it.
            You'll get access to the dashboard once approved.
        </p>

        <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-700 dark:border-yellow-700/30 dark:bg-yellow-900/20 dark:text-yellow-400 mb-6">
            Please check back later or contact your administrator for assistance.
        </div>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign Out
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.fullscreen-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\AdminView\resources\views/pages/auth/pending-approval.blade.php ENDPATH**/ ?>