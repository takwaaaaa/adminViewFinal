<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | AdminView</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine stores: theme + sidebar --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    // Always default to dark
                    const saved = localStorage.getItem('theme') || 'dark';
                    this.theme = saved;
                    this.updateTheme();
                },
                theme: 'dark',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    if (this.theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            });

            Alpine.store('sidebar', {
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,
                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;
                },
                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },
                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },
                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    {{-- Prevent flash: always dark --}}
    <script>
        (function() {
            const saved = localStorage.getItem('theme') || 'dark';
            if (saved === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

<body
    class="bg-gray-900 dark:bg-gray-900 min-h-screen"
    x-data="{ loaded: true }"
    x-init="
        $store.sidebar.isExpanded = window.innerWidth >= 1280;
        const checkMobile = () => {
            if (window.innerWidth < 1280) {
                $store.sidebar.setMobileOpen(false);
                $store.sidebar.isExpanded = false;
            } else {
                $store.sidebar.isMobileOpen = false;
                $store.sidebar.isExpanded = true;
            }
        };
        window.addEventListener('resize', checkMobile);
    ">

    {{-- Preloader --}}
    <x-common.preloader />

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Main Content Wrapper --}}
    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden transition-all duration-300 ease-in-out"
        :class="{
            'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
            'xl:ml-[90px]':  !$store.sidebar.isExpanded && !$store.sidebar.isHovered
        }">

        {{-- Header --}}
        @include('layouts.app-header')

        {{-- Page Content --}}
        <main>
            <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
                @yield('content')
            </div>
        </main>
    </div>

</body>

@stack('scripts')

</html>