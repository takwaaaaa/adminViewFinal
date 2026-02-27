@extends('layouts.fullscreen-layout')

@section('content')
    <div class="relative z-1 bg-white dark:bg-gray-900 p-6 sm:p-0">
        <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row">
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto w-full max-w-md pt-10">
                    <a href="/signin"
                        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400">
                        <svg class="stroke-current mr-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Back to sign in
                    </a>
                </div>
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                    <div class="mb-5 sm:mb-8">
                        <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white">
                            Reset Password
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Enter your new password below.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}" />

                        <div class="space-y-5">

                            @if ($errors->any())
                                <div class="rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email<span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $request->email) }}"
                                    placeholder="Enter your email"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    New Password<span class="text-red-500">*</span>
                                </label>
                                <div x-data="{ show: false }" class="relative">
                                    <input :type="show ? 'text' : 'password'" name="password"
                                        placeholder="Enter new password"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-4 pr-11 text-sm text-gray-800 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                                    <span @click="show = !show"
                                        class="absolute top-1/2 right-4 -translate-y-1/2 cursor-pointer text-gray-400">
                                        <svg x-show="!show" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 13.862A3.862 3.862 0 1 1 10 6.138a3.862 3.862 0 0 1 0 7.724zm0-9.224C6.2 4.638 3 7.01 2 10c1 2.99 4.2 5.362 8 5.362S17 12.99 18 10c-1-2.99-4.2-5.362-8-5.362z" clip-rule="evenodd"/>
                                        </svg>
                                        <svg x-show="show" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.76-1.76A8.67 8.67 0 0 0 18 10c-1-2.99-4.2-5.362-8-5.362a8.6 8.6 0 0 0-3.9.92L3.28 2.22zM10 5.638a4.362 4.362 0 0 1 3.11 7.42l-1.1-1.1a2.862 2.862 0 0 0-3.93-3.93L6.98 6.93A4.35 4.35 0 0 1 10 5.638zM6.89 8.75l1.1 1.1a2.862 2.862 0 0 0 3.26 3.26l1.1 1.1A4.362 4.362 0 0 1 6.89 8.75z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Confirm Password<span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation"
                                    placeholder="Confirm new password"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                            </div>

                            <button type="submit"
                                class="flex w-full items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-brand-950 relative hidden h-full w-full items-center lg:grid lg:w-1/2">
                <div class="z-1 flex items-center justify-center">
                    <x-common.common-grid-shape />
                    <div class="flex max-w-xs flex-col items-center">
                        <a href="/" class="mb-4 block">
                            <img src="/images/logo/auth-logo.svg" alt="Logo" />
                        </a>
                        <p class="text-center text-gray-400">
                            Free and Open-Source Tailwind CSS Admin Dashboard Template
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection