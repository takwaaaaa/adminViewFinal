

<?php $__env->startSection('content'); ?>

<?php
    $sort    = in_array(request('sort'), ['name','email','status','created_at']) ? request('sort') : 'created_at';
    $dir     = request('direction') === 'asc' ? 'asc' : 'desc';
    $sortIcon = fn($col) => $sort === $col ? ($dir === 'asc' ? '↑' : '↓') : '';
    $sortUrl  = fn($col) => route('users.index', array_merge(request()->query(), [
        'sort'      => $col,
        'direction' => ($sort === $col && $dir === 'asc') ? 'desc' : 'asc',
        'page'      => 1,
    ]));
?>


<div class="mb-7 flex items-start justify-between">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">User Management</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            <?php echo e($users->total()); ?> <?php echo e(Str::plural('user', $users->total())); ?> registered
            <?php if(request('search') || request('status')): ?>
                <span class="ml-1.5 inline-flex items-center gap-1 rounded-full bg-brand-50 px-2 py-0.5 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                    filtered
                </span>
            <?php endif; ?>
        </p>
    </div>
    <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermissionTo('create_user')): ?>
    <a href="<?php echo e(route('users.create')); ?>"
        class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-brand-500/30 hover:bg-brand-600 hover:shadow-brand-500/40 transition-all duration-150">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Add User
    </a>
    <?php endif; ?>
</div>


<?php if(session('success')): ?>
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
    x-transition:leave="transition duration-300" x-transition:leave-end="opacity-0 -translate-y-1"
    class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700 dark:border-green-700/30 dark:bg-green-900/20 dark:text-green-400">
    <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<form method="GET" action="<?php echo e(route('users.index')); ?>" class="mb-4 flex flex-wrap items-center gap-2.5">

    
    <div class="relative flex-1 min-w-[200px] max-w-sm">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search users..."
            class="h-10 w-full rounded-xl border border-gray-200 bg-white pl-9 pr-4 text-sm text-gray-800 placeholder:text-gray-400 shadow-xs transition focus:border-brand-400 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800/80 dark:text-white dark:placeholder:text-gray-500" />
    </div>

    
    <div class="flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white p-1 dark:border-gray-700 dark:bg-gray-800/80">
        <?php $__currentLoopData = ['' => 'All', 'active' => 'Active', 'inactive' => 'Inactive']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button type="submit" name="status" value="<?php echo e($val); ?>"
            class="rounded-lg px-3 py-1.5 text-xs font-medium transition-all
            <?php echo e(request('status', '') === $val
                ? 'bg-brand-500 text-white shadow-sm'
                : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
            <?php echo e($label); ?>

        </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="relative">
        <select name="per_page" onchange="this.form.submit()"
            class="h-10 appearance-none rounded-xl border border-gray-200 bg-white pl-3 pr-8 text-sm font-medium text-gray-700 shadow-xs transition focus:border-brand-400 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-300 cursor-pointer">
            <?php $__currentLoopData = [10, 25, 50]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($n); ?>" <?php echo e(request('per_page', 10) == $n ? 'selected' : ''); ?>><?php echo e($n); ?> / page</option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    
    <?php if(request('sort')): ?>      <input type="hidden" name="sort"      value="<?php echo e(request('sort')); ?>"> <?php endif; ?>
    <?php if(request('direction')): ?> <input type="hidden" name="direction" value="<?php echo e(request('direction')); ?>"> <?php endif; ?>

    
    <?php if(request('search') || request('status')): ?>
    <a href="<?php echo e(route('users.index')); ?>"
        class="inline-flex h-10 items-center gap-1.5 rounded-xl border border-gray-200 px-3 text-xs font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700/50 transition-colors">
        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Clear
    </a>
    <?php endif; ?>
</form>


<div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700/60 bg-white dark:bg-gray-800 shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">

            
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-700/60">
                    <?php $__currentLoopData = [
                        ['col' => 'name',       'label' => 'User'],
                        ['col' => 'email',      'label' => 'Email'],
                        ['col' => null,          'label' => 'Phone'],
                        ['col' => 'status',     'label' => 'Status'],
                        ['col' => 'created_at', 'label' => 'Joined'],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $th): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th class="px-5 py-3.5">
                        <?php if($th['col']): ?>
                        <a href="<?php echo e($sortUrl($th['col'])); ?>"
                            class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-widest transition-colors
                            <?php echo e($sort === $th['col']
                                ? 'text-brand-500 dark:text-brand-400'
                                : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'); ?>">
                            <?php echo e($th['label']); ?>

                            <span class="text-[10px]"><?php echo e($sortIcon($th['col'])); ?></span>
                        </a>
                        <?php else: ?>
                        <span class="text-[11px] font-semibold uppercase tracking-widest text-gray-400"><?php echo e($th['label']); ?></span>
                        <?php endif; ?>
                    </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <th class="px-5 py-3.5 text-right text-[11px] font-semibold uppercase tracking-widest text-gray-400">Actions</th>
                </tr>
            </thead>

            
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="group border-b border-gray-50 dark:border-gray-700/40 last:border-0 hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors duration-100">

                    
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="relative shrink-0">
                                <div class="h-9 w-9 overflow-hidden rounded-full ring-2 ring-white dark:ring-gray-800 shadow-sm">
                                    <img src="<?php echo e($user->avatar_url); ?>" alt="<?php echo e($user->name); ?>" class="h-full w-full object-cover" />
                                </div>
                                <span class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full border-2 border-white dark:border-gray-800
                                    <?php echo e($user->status === 'active' ? 'bg-green-400' : 'bg-gray-300 dark:bg-gray-600'); ?>"></span>
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-800 dark:text-white"><?php echo e($user->name); ?></p>
                                <p class="truncate text-xs font-medium capitalize text-gray-400 dark:text-gray-500">
                                    <?php echo e($user->roles->first()?->name ?? 'No role'); ?>

                                </p>
                            </div>
                        </div>
                    </td>

                    
                    <td class="px-5 py-3.5">
                        <span class="text-sm text-gray-600 dark:text-gray-300"><?php echo e($user->email); ?></span>
                    </td>

                    
                    <td class="px-5 py-3.5">
                        <span class="text-sm <?php echo e($user->phone ? 'text-gray-600 dark:text-gray-300' : 'text-gray-300 dark:text-gray-600'); ?>">
                            <?php echo e($user->phone ?? '—'); ?>

                        </span>
                    </td>

                    
                    <td class="px-5 py-3.5">
                        <?php if($user->status === 'active'): ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-400 ring-1 ring-green-200/60 dark:ring-green-500/20">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                            Active
                        </span>
                        <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-500 dark:bg-gray-700 dark:text-gray-400 ring-1 ring-gray-200/60 dark:ring-gray-600/40">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400 dark:bg-gray-500"></span>
                            Inactive
                        </span>
                        <?php endif; ?>
                    </td>

                    
                    <td class="px-5 py-3.5">
                        <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                    </td>

                    
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-1.5">

                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['activate_user','deactivate_user'])): ?>
                            <form method="POST" action="<?php echo e(route('users.toggle-status', $user)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit"
                                    class="inline-flex h-8 items-center gap-1 rounded-lg border px-2.5 text-xs font-medium transition-all duration-150
                                    <?php echo e($user->status === 'active'
                                        ? 'border-orange-200 text-orange-600 hover:bg-orange-50 dark:border-orange-700/40 dark:text-orange-400 dark:hover:bg-orange-900/20'
                                        : 'border-green-200 text-green-600 hover:bg-green-50 dark:border-green-700/40 dark:text-green-400 dark:hover:bg-green-900/20'); ?>">
                                    <?php echo e($user->status === 'active' ? 'Deactivate' : 'Activate'); ?>

                                </button>
                            </form>
                            <?php endif; ?>

                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermissionTo('edit_user')): ?>
                            <a href="<?php echo e(route('users.edit', $user)); ?>"
                                class="inline-flex h-8 items-center gap-1 rounded-lg border border-gray-200 px-2.5 text-xs font-medium text-gray-600 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-all duration-150">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <?php endif; ?>

                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermissionTo('delete_user')): ?>
                            <form method="POST" action="<?php echo e(route('users.destroy', $user)); ?>"
                                onsubmit="return confirm('Delete <?php echo e(addslashes($user->name)); ?>? This cannot be undone.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                    class="inline-flex h-8 items-center gap-1 rounded-lg border border-red-100 px-2.5 text-xs font-medium text-red-500 hover:bg-red-50 hover:border-red-200 dark:border-red-900/40 dark:text-red-400 dark:hover:bg-red-900/20 transition-all duration-150">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                            <?php endif; ?>

                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-700/50">
                                <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <?php echo e(request('search') ? 'No users match "'.request('search').'"' : 'No users yet'); ?>

                                </p>
                                <p class="mt-0.5 text-xs text-gray-400">
                                    <?php echo e(request('search') || request('status') ? 'Try adjusting your filters.' : 'Create your first user to get started.'); ?>

                                </p>
                            </div>
                            <?php if(request('search') || request('status')): ?>
                            <a href="<?php echo e(route('users.index')); ?>" class="mt-1 text-xs font-medium text-brand-500 hover:text-brand-600 hover:underline">Clear filters</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-700/60 px-5 py-3.5 bg-gray-50/50 dark:bg-gray-800/50">

        <p class="text-xs text-gray-500 dark:text-gray-400">
            <?php if($users->total() > 0): ?>
                Showing <span class="font-semibold text-gray-700 dark:text-gray-300"><?php echo e($users->firstItem()); ?>–<?php echo e($users->lastItem()); ?></span>
                of <span class="font-semibold text-gray-700 dark:text-gray-300"><?php echo e($users->total()); ?></span>
                <?php echo e(Str::plural('user', $users->total())); ?>

            <?php else: ?>
                No users found
            <?php endif; ?>
        </p>

        <?php if($users->hasPages()): ?>
        <div class="flex items-center gap-1">

            
            <?php if($users->onFirstPage()): ?>
            <span class="inline-flex h-8 items-center rounded-lg px-3 text-xs font-medium text-gray-300 dark:text-gray-600 cursor-not-allowed select-none">← Prev</span>
            <?php else: ?>
            <a href="<?php echo e($users->previousPageUrl()); ?>"
                class="inline-flex h-8 items-center rounded-lg border border-gray-200 dark:border-gray-700 px-3 text-xs font-medium text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-700 transition-colors">← Prev</a>
            <?php endif; ?>

            
            <?php $__currentLoopData = $users->getUrlRange(1, $users->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $users->currentPage()): ?>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-500 text-xs font-bold text-white shadow-sm shadow-brand-500/30"><?php echo e($page); ?></span>
                <?php elseif(abs($page - $users->currentPage()) <= 1 || $page == 1 || $page == $users->lastPage()): ?>
                <a href="<?php echo e($url); ?>"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-xs font-medium text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-700 transition-colors"><?php echo e($page); ?></a>
                <?php elseif(abs($page - $users->currentPage()) == 2): ?>
                <span class="inline-flex h-8 w-8 items-center justify-center text-xs text-gray-400">…</span>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($users->hasMorePages()): ?>
            <a href="<?php echo e($users->nextPageUrl()); ?>"
                class="inline-flex h-8 items-center rounded-lg border border-gray-200 dark:border-gray-700 px-3 text-xs font-medium text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-700 transition-colors">Next →</a>
            <?php else: ?>
            <span class="inline-flex h-8 items-center rounded-lg px-3 text-xs font-medium text-gray-300 dark:text-gray-600 cursor-not-allowed select-none">Next →</span>
            <?php endif; ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\AdminView\resources\views/pages/users/index.blade.php ENDPATH**/ ?>