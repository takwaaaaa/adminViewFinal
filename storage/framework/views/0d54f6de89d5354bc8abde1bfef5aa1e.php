

<?php $__env->startSection('content'); ?>

<div class="mb-5">
    <a href="<?php echo e(route('roles.index')); ?>"
        class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Roles
    </a>
</div>

<div class="max-w-lg">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Create Role</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Define a new role. You can assign permissions to it afterwards.
        </p>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <form method="POST" action="<?php echo e(route('roles.store')); ?>">
            <?php echo csrf_field(); ?>

            <?php if($errors->any()): ?>
            <div class="mb-5 rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
                <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?>

            <div class="mb-6">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Role Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>"
                    placeholder="e.g. manager, editor, moderator"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" />
                <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">
                    Use lowercase, no spaces (e.g. <code class="rounded bg-gray-100 dark:bg-gray-700 px-1">manager</code>, <code class="rounded bg-gray-100 dark:bg-gray-700 px-1">content_editor</code>)
                </p>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="<?php echo e(route('roles.index')); ?>"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    Create Role
                </button>
            </div>
        </form>
    </div>

    <p class="mt-4 text-xs text-gray-400 dark:text-gray-500 text-center">
        After creating, use <strong>Add Permissions</strong> on the roles list to assign permissions.
    </p>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\AdminView\resources\views/pages/roles/create.blade.php ENDPATH**/ ?>