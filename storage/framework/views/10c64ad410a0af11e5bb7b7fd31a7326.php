

<?php $__env->startSection('content'); ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Role Management</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create and manage roles and their permissions.</p>
    </div>
    <a href="<?php echo e(route('roles.create')); ?>"
        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Create Role
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

<?php if(session('error')): ?>
<div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700 dark:bg-red-900/20 dark:text-red-400">
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
    <?php if($roles->isEmpty()): ?>
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
            <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">No roles yet</p>
        <p class="mt-1 text-xs text-gray-400">Create your first role to assign to users.</p>
        <a href="<?php echo e(route('roles.create')); ?>"
            class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
            Create first role
        </a>
    </div>
    <?php else: ?>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40">
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Role</th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Permissions</th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Users</th>
                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                <td class="px-6 py-4">
                    <span class="font-medium text-gray-800 dark:text-white capitalize"><?php echo e($role->name); ?></span>
                    <?php if($role->name === 'superadmin'): ?>
                    <span class="ml-2 inline-flex items-center rounded px-1.5 py-0.5 text-[10px] font-semibold uppercase bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                        System
                    </span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                        <?php $__empty_1 = true; $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <span class="inline-flex items-center rounded px-2 py-0.5 text-[11px] font-medium bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-400">
                            <?php echo e($perm->name); ?>

                        </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">No permissions yet</span>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                    <?php echo e($role->users()->count()); ?>

                </td>
                <td class="px-6 py-4 text-right">
                    <?php if($role->name !== 'superadmin'): ?>
                    <div class="flex items-center justify-end gap-2">
                        
                        <a href="<?php echo e(route('roles.permissions', $role)); ?>"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-brand-50 border border-brand-200 dark:bg-brand-500/10 dark:border-brand-500/30 px-3 py-1.5 text-xs font-medium text-brand-700 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-500/20 transition-colors">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Add Permissions
                        </a>

                        
                        <form method="POST" action="<?php echo e(route('roles.destroy', $role)); ?>"
                            onsubmit="return confirm('Delete role <?php echo e($role->name); ?>?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                class="inline-flex items-center gap-1 rounded-lg border border-red-200 dark:border-red-800 px-3 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                    <?php else: ?>
                    <span class="text-xs text-gray-400">Protected</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
        <?php echo e($roles->links()); ?>

    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\AdminView\resources\views/pages/roles/index.blade.php ENDPATH**/ ?>