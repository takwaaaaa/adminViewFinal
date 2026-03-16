

<?php $__env->startSection('content'); ?>

<div class="mb-5">
    <a href="<?php echo e(route('users.index')); ?>"
        class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to User Management
    </a>
</div>

<div class="max-w-2xl">
    <div class="mb-6 flex items-center gap-4">
        <div class="h-12 w-12 overflow-hidden rounded-full border border-gray-200 dark:border-gray-600">
            <img src="<?php echo e($editUser->avatar_url); ?>" alt="<?php echo e($editUser->name); ?>" class="h-full w-full object-cover" />
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Edit <?php echo e($editUser->name); ?></h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Joined <?php echo e($editUser->created_at->format('M d, Y')); ?></p>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <form method="POST" action="<?php echo e(route('users.update', $editUser)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <?php if($errors->any()): ?>
            <div class="mb-5 rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
                <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                    <input type="text" name="fname" value="<?php echo e(old('fname', $editUser->first_name)); ?>"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                    <input type="text" name="lname" value="<?php echo e(old('lname', $editUser->last_name)); ?>"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $editUser->email)); ?>"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $editUser->phone)); ?>" placeholder="+1 555 000 000"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                    <input type="text" name="bio" value="<?php echo e(old('bio', $editUser->bio)); ?>" placeholder="e.g. Editor"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10" />
                </div>

                
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <?php if($roles->isEmpty()): ?>
                    <div class="rounded-lg border border-yellow-300 bg-yellow-50 px-4 py-3 text-sm text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400 dark:border-yellow-700">
                        No roles available. <a href="<?php echo e(route('roles.create')); ?>" class="font-semibold underline">Create a role first</a>.
                    </div>
                    <?php else: ?>
                    <select name="role"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- Select a role --</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($r->name); ?>"
                            <?php echo e(old('role', $editUser->getRoleNames()->first()) === $r->name ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($r->name)); ?>

                            <?php if($r->permissions->count()): ?>
                                (<?php echo e($r->permissions->count()); ?> permissions)
                            <?php endif; ?>
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="mt-5 flex items-center gap-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 px-4 py-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">Account status:</span>
                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium
                    <?php echo e($editUser->status === 'active'
                        ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                        : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'); ?>">
                    <span class="h-1.5 w-1.5 rounded-full <?php echo e($editUser->status === 'active' ? 'bg-green-500' : 'bg-red-500'); ?>"></span>
                    <?php echo e(ucfirst($editUser->status)); ?>

                </span>
                <form method="POST" action="<?php echo e(route('users.toggle-status', $editUser)); ?>" class="ml-auto">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button type="submit"
                        class="rounded-lg border px-3 py-1.5 text-xs font-medium transition-colors
                        <?php echo e($editUser->status === 'active'
                            ? 'border-orange-200 text-orange-600 hover:bg-orange-50 dark:border-orange-700/40 dark:text-orange-400'
                            : 'border-green-200 text-green-600 hover:bg-green-50 dark:border-green-700/40 dark:text-green-400'); ?>">
                        <?php echo e($editUser->status === 'active' ? 'Deactivate' : 'Activate'); ?>

                    </button>
                </form>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="<?php echo e(route('users.index')); ?>"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\AdminView\resources\views/pages/users/edit.blade.php ENDPATH**/ ?>