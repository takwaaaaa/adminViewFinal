<?php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenuGroups();
    $currentPath = request()->path();
?>

<aside id="sidebar"
    class="fixed flex flex-col top-0 left-0 px-5 bg-white dark:bg-gray-900 h-screen transition-all duration-300 ease-in-out z-[99999] border-r border-gray-200 dark:border-gray-700 overflow-hidden"
    x-data="{
        openSubmenus: {},
        init() { this.initActiveMenus(); },
        initActiveMenus() {
            const p = window.location.pathname;
            <?php $__currentLoopData = $menuGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gi => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ii => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($item['subItems'])): ?>
                        <?php $__currentLoopData = $item['subItems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            if (p === '<?php echo e($sub['path']); ?>') this.openSubmenus['<?php echo e($gi); ?>-<?php echo e($ii); ?>'] = true;
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        },
        toggle(gi, ii) {
            const k = gi+'-'+ii, v = !this.openSubmenus[k];
            if (v) this.openSubmenus = {};
            this.openSubmenus[k] = v;
        },
        isOpen(gi, ii)   { return !!this.openSubmenus[gi+'-'+ii]; },
        isActive(path)   {
            return window.location.pathname === path
                || '<?php echo e($currentPath); ?>' === path.replace(/^\//, '');
        }
    }"
    :class="{
        'w-[290px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[90px]':  !$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen,
        'translate-x-0':               $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">

    
    <div class="flex pt-8 pb-7"
        :class="($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen) ? 'justify-start' : 'xl:justify-center'">
        <a href="/">
            <img x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                 class="dark:hidden block" src="/images/logo/logo.svg"      alt="Logo" width="150" height="40" />
            <img x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                 class="hidden dark:block"  src="/images/logo/logo-dark.svg" alt="Logo" width="150" height="40" />
            <img x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen"
                 src="/images/logo/logo-icon.svg" alt="Logo" width="32" height="32" />
        </a>
    </div>

    
    <div class="flex flex-col overflow-y-auto no-scrollbar flex-1">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">
                <?php $__currentLoopData = $menuGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gi => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                
                <?php if(!empty($group['superadmin']) && (!auth()->check() || !auth()->user()->isSuperAdmin())): ?>
                    <?php continue; ?>
                <?php endif; ?>

                <div>
                    
                    <h2 class="mb-4 flex text-xs font-medium uppercase tracking-widest text-gray-400 dark:text-gray-500"
                        :class="($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen) ? 'justify-start' : 'lg:justify-center'">
                        <template x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                            <span><?php echo e($group['title']); ?></span>
                        </template>
                        <template x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                            <span>···</span>
                        </template>
                    </h2>

                    <ul class="flex flex-col gap-0.5">
                        <?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ii => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php if(isset($item['subItems'])): ?>
                            
                            <button @click="toggle(<?php echo e($gi); ?>, <?php echo e($ii); ?>)"
                                class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 group"
                                :class="[
                                    isOpen(<?php echo e($gi); ?>, <?php echo e($ii); ?>)
                                        ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400'
                                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white',
                                    (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : ''
                                ]">

                                
                                <span class="shrink-0"
                                    :class="isOpen(<?php echo e($gi); ?>, <?php echo e($ii); ?>) ? 'text-brand-500' : 'text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200'">
                                    <?php echo MenuHelper::getIconSvg($item['icon']); ?>

                                </span>

                                
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                      class="flex-1 whitespace-nowrap overflow-hidden text-left">
                                    <?php echo e($item['name']); ?>

                                </span>

                                
                                <?php if(!empty($item['new'])): ?>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                      class="inline-flex items-center rounded bg-brand-500 px-1.5 py-0.5 text-[10px] font-semibold uppercase text-white">
                                    New
                                </span>
                                <?php endif; ?>

                                
                                <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                     class="ml-auto h-4 w-4 shrink-0 transition-transform duration-200"
                                     :class="isOpen(<?php echo e($gi); ?>, <?php echo e($ii); ?>) ? 'rotate-180 text-brand-500' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            
                            <div x-show="isOpen(<?php echo e($gi); ?>, <?php echo e($ii); ?>) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0">
                                <ul class="mt-1 ml-9 space-y-0.5 border-l border-gray-100 dark:border-gray-700 pl-3">
                                    <?php $__currentLoopData = $item['subItems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e($sub['path']); ?>"
                                           class="flex items-center gap-2 rounded-lg px-2 py-2 text-sm transition-all duration-150"
                                           :class="isActive('<?php echo e($sub['path']); ?>')
                                               ? 'font-medium text-brand-600 dark:text-brand-400'
                                               : 'font-normal text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200'">
                                            <?php echo e($sub['name']); ?>

                                            <?php if(!empty($sub['new'])): ?>
                                            <span class="ml-auto inline-flex items-center rounded bg-brand-500 px-1.5 py-0.5 text-[10px] font-semibold uppercase text-white">new</span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>

                            <?php else: ?>
                            
                            <a href="<?php echo e($item['path']); ?>"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 group"
                               :class="[
                                   isActive('<?php echo e($item['path']); ?>')
                                       ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400'
                                       : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white',
                                   (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : ''
                               ]">

                                <span class="shrink-0"
                                    :class="isActive('<?php echo e($item['path']); ?>') ? 'text-brand-500' : 'text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200'">
                                    <?php echo MenuHelper::getIconSvg($item['icon']); ?>

                                </span>

                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                      class="flex-1 whitespace-nowrap overflow-hidden">
                                    <?php echo e($item['name']); ?>

                                </span>

                                <?php if(!empty($item['new'])): ?>
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                      class="inline-flex items-center rounded bg-brand-500 px-1.5 py-0.5 text-[10px] font-semibold uppercase text-white">
                                    New
                                </span>
                                <?php endif; ?>
                            </a>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </nav>

        
        <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
             x-transition class="mt-auto pb-4">
            <?php echo $__env->make('layouts.sidebar-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
</aside>


<div x-show="$store.sidebar.isMobileOpen"
     @click="$store.sidebar.setMobileOpen(false)"
     class="fixed inset-0 z-[9998] bg-gray-900/50 xl:hidden"></div><?php /**PATH C:\laragon\www\AdminView\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>