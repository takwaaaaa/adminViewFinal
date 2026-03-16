@php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenuGroups();
    $currentPath = request()->path();
@endphp

<aside id="sidebar"
    class="fixed flex flex-col top-0 left-0 px-5 bg-white dark:bg-gray-900 h-screen transition-all duration-300 ease-in-out z-[99999] border-r border-gray-200 dark:border-gray-700 overflow-hidden"
    x-data="{
        openSubmenus: {},
        init() { this.initActiveMenus(); },
        initActiveMenus() {
            const p = window.location.pathname;
            @foreach ($menuGroups as $gi => $group)
                @foreach ($group['items'] as $ii => $item)
                    @if(isset($item['subItems']))
                        @foreach($item['subItems'] as $sub)
                            if (p === '{{ $sub['path'] }}') this.openSubmenus['{{ $gi }}-{{ $ii }}'] = true;
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        },
        toggle(gi, ii) {
            const k = gi+'-'+ii, v = !this.openSubmenus[k];
            if (v) this.openSubmenus = {};
            this.openSubmenus[k] = v;
        },
        isOpen(gi, ii)   { return !!this.openSubmenus[gi+'-'+ii]; },
        isActive(path)   {
            return window.location.pathname === path
                || '{{ $currentPath }}' === path.replace(/^\//, '');
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

    {{-- ── Logo ── --}}
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

    {{-- ── Nav ── --}}
    <div class="flex flex-col overflow-y-auto no-scrollbar flex-1">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">
                @foreach ($menuGroups as $gi => $group)
                <div>
                    {{-- Group title --}}
                    <h2 class="mb-4 flex text-xs font-medium uppercase tracking-widest text-gray-400 dark:text-gray-500"
                        :class="($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen) ? 'justify-start' : 'lg:justify-center'">
                        <template x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                            <span>{{ $group['title'] }}</span>
                        </template>
                        <template x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                            <span>···</span>
                        </template>
                    </h2>

                    <ul class="flex flex-col gap-0.5">
                        @foreach ($group['items'] as $ii => $item)
                        <li>
                            @if(isset($item['subItems']))
                            {{-- ── Parent with dropdown ── --}}
                            <button @click="toggle({{ $gi }}, {{ $ii }})"
                                class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 group"
                                :class="[
                                    isOpen({{ $gi }}, {{ $ii }})
                                        ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400'
                                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white',
                                    (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : ''
                                ]">

                                <span class="shrink-0"
                                    :class="isOpen({{ $gi }}, {{ $ii }}) ? 'text-brand-500' : 'text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200'">
                                    {!! MenuHelper::getIconSvg($item['icon']) !!}
                                </span>

                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                      class="flex-1 whitespace-nowrap overflow-hidden text-left">
                                    {{ $item['name'] }}
                                </span>

                                @if(!empty($item['new']))
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                      class="inline-flex items-center rounded bg-brand-500 px-1.5 py-0.5 text-[10px] font-semibold uppercase text-white">
                                    New
                                </span>
                                @endif

                                <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                     class="ml-auto h-4 w-4 shrink-0 transition-transform duration-200"
                                     :class="isOpen({{ $gi }}, {{ $ii }}) ? 'rotate-180 text-brand-500' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            {{-- Sub-items --}}
                            <div x-show="isOpen({{ $gi }}, {{ $ii }}) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0">
                                <ul class="mt-1 ml-9 space-y-0.5 border-l border-gray-100 dark:border-gray-700 pl-3">
                                    @foreach($item['subItems'] as $sub)
                                    <li>
                                        <a href="{{ $sub['path'] }}"
                                           class="flex items-center gap-2 rounded-lg px-2 py-2 text-sm transition-all duration-150"
                                           :class="isActive('{{ $sub['path'] }}')
                                               ? 'font-medium text-brand-600 dark:text-brand-400'
                                               : 'font-normal text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200'">
                                            {{ $sub['name'] }}
                                            @if(!empty($sub['new']))
                                            <span class="ml-auto inline-flex items-center rounded bg-brand-500 px-1.5 py-0.5 text-[10px] font-semibold uppercase text-white">new</span>
                                            @endif
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            @else
                            {{-- ── Simple link ── --}}
                            <a href="{{ $item['path'] }}"
                               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 group"
                               :class="[
                                   isActive('{{ $item['path'] }}')
                                       ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400'
                                       : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white',
                                   (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : ''
                               ]">

                                <span class="shrink-0"
                                    :class="isActive('{{ $item['path'] }}') ? 'text-brand-500' : 'text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200'">
                                    {!! MenuHelper::getIconSvg($item['icon']) !!}
                                </span>

                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                      class="flex-1 whitespace-nowrap overflow-hidden">
                                    {{ $item['name'] }}
                                </span>

                                @if(!empty($item['new']))
                                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                      class="inline-flex items-center rounded bg-brand-500 px-1.5 py-0.5 text-[10px] font-semibold uppercase text-white">
                                    New
                                </span>
                                @endif
                            </a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </nav>

        {{-- Sidebar widget --}}
        <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
             x-transition class="mt-auto pb-4">
            @include('layouts.sidebar-widget')
        </div>
    </div>
</aside>

{{-- Mobile overlay --}}
<div x-show="$store.sidebar.isMobileOpen"
     @click="$store.sidebar.setMobileOpen(false)"
     class="fixed inset-0 z-[9998] bg-gray-900/50 xl:hidden"></div>