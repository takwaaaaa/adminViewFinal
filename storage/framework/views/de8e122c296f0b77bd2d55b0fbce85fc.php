

<?php $__env->startSection('content'); ?>


<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">User Management</h1>
        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Manage all approved regular users</p>
    </div>
    <a href="<?php echo e(route('users.create')); ?>"
        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add User
    </a>
</div>

<?php if(session('success')): ?>
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
    class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-700/30 dark:bg-green-900/20 dark:text-green-400">
    <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40">
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">User</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Email</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Phone</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Joined</th>
                    <th class="px-5 py-3.5 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">

                    
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            
                            <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full border border-gray-200 dark:border-gray-600">
                                <img src="<?php echo e($user->avatar_url); ?>"
                                     alt="<?php echo e($user->name); ?>"
                                     class="h-full w-full object-cover" />
                            </div>
                            <div class="min-w-0">
                                <p class="truncate font-medium text-gray-800 dark:text-white"><?php echo e($user->name); ?></p>
                                <p class="truncate text-xs text-gray-400 dark:text-gray-500"><?php echo e($user->bio ?? '—'); ?></p>
                            </div>
                        </div>
                    </td>

                    <td class="px-5 py-3 text-gray-600 dark:text-gray-300 max-w-[200px] truncate">
                        <?php echo e($user->email); ?>

                    </td>

                    <td class="px-5 py-3 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                        <?php echo e($user->phone ?? '—'); ?>

                    </td>

                    <td class="px-5 py-3 whitespace-nowrap">
                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium
                            <?php echo e($user->status === 'active'
                                ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                                : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'); ?>">
                            <span class="h-1.5 w-1.5 rounded-full <?php echo e($user->status === 'active' ? 'bg-green-500' : 'bg-red-500'); ?>"></span>
                            <?php echo e(ucfirst($user->status)); ?>

                        </span>
                    </td>

                    <td class="px-5 py-3 text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                        <?php echo e($user->created_at->format('M d, Y')); ?>

                    </td>

                    <td class="px-5 py-3">
                        <div class="flex items-center justify-end gap-2 whitespace-nowrap">
                            
                            <form method="POST" action="<?php echo e(route('users.toggle-status', $user)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit"
                                    class="rounded-lg border px-3 py-1.5 text-xs font-medium transition-colors
                                    <?php echo e($user->status === 'active'
                                        ? 'border-orange-200 text-orange-600 hover:bg-orange-50 dark:border-orange-700/40 dark:text-orange-400 dark:hover:bg-orange-900/20'
                                        : 'border-green-200 text-green-600 hover:bg-green-50 dark:border-green-700/40 dark:text-green-400 dark:hover:bg-green-900/20'); ?>">
                                    <?php echo e($user->status === 'active' ? 'Deactivate' : 'Activate'); ?>

                                </button>
                            </form>

                            
                            <a href="<?php echo e(route('users.edit', $user)); ?>"
                                class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                Edit
                            </a>

                            
                            <form method="POST" action="<?php echo e(route('users.destroy', $user)); ?>"
                                onsubmit="return confirm('Delete <?php echo e(addslashes($user->name)); ?>? This cannot be undone.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                    class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 dark:border-red-700/40 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-5 py-14 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">No users yet</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Approved users will appear here.</p>
                            <a href="<?php echo e(route('users.create')); ?>"
                                class="mt-1 inline-flex items-center gap-1.5 rounded-lg bg-brand-500 px-4 py-2 text-xs font-medium text-white hover:bg-brand-600">
                                Add first user
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($users->hasPages()): ?>
    <div class="border-t border-gray-100 dark:border-gray-700 px-5 py-4">
        <?php echo e($users->links()); ?>

    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\AdminView\resources\views/pages/users/index.blade.php ENDPATH**/ ?>