@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb :pageTitle="$title ?? 'Coming Soon'" />

    <div class="min-h-[60vh] flex items-center justify-center rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="text-center px-6 py-16">
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-500/10">
                <svg class="text-brand-500" width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
            </div>

            <h2 class="mb-3 text-2xl font-semibold text-gray-800 dark:text-white">
                {{ $title ?? 'Coming Soon' }}
            </h2>

            <p class="mb-6 max-w-sm text-sm text-gray-500 dark:text-gray-400">
                This page is part of the TailAdmin Pro template. The route is registered and
                working — add your content here.
            </p>

            <a href="/"
               class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.70711 3.29289C10.0976 3.68342 10.0976 4.31658 9.70711 4.70711L5.41421 9H17C17.5523 9 18 9.44772 18 10C18 10.5523 17.5523 11 17 11H5.41421L9.70711 15.2929C10.0976 15.6834 10.0976 16.3166 9.70711 16.7071C9.31658 17.0976 8.68342 17.0976 8.29289 16.7071L2.29289 10.7071C1.90237 10.3166 1.90237 9.68342 2.29289 9.29289L8.29289 3.29289C8.68342 2.90237 9.31658 2.90237 9.70711 3.29289Z"
                        fill="currentColor"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
@endsection