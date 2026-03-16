@extends('layouts.app')

@section('content')

<div class="mb-5">
    <a href="{{ route('users.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to User Management
    </a>
</div>

<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Add New User</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">User will be active immediately.</p>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            @if($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
                {{ $errors->first() }}
            </div>
            @endif

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                    <input type="text" name="fname" value="{{ old('fname') }}" placeholder="John"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white @error('fname') border-red-500 @enderror" />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                    <input type="text" name="lname" value="{{ old('lname') }}" placeholder="Doe"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white @error('lname') border-red-500 @enderror" />
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white @error('email') border-red-500 @enderror" />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input type="password" name="password"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 @error('password') border-red-500 @enderror" />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10" />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Phone <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+1 555 000 000"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10" />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Bio <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" name="bio" value="{{ old('bio') }}" placeholder="Short bio..."
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10" />
                </div>

                {{-- Role --}}
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Assign Role <span class="text-red-500">*</span>
                    </label>
                    @if($roles->isEmpty())
                    <div class="rounded-lg border border-yellow-300 bg-yellow-50 px-4 py-3 text-sm text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400 dark:border-yellow-700">
                        No roles available. <a href="{{ route('roles.create') }}" class="font-semibold underline">Create a role first</a>.
                    </div>
                    @else
                    <select name="role"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-600 dark:bg-gray-900 dark:text-white @error('role') border-red-500 @enderror">
                        <option value="">-- Select a role --</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                            @if($role->permissions->count())
                                ({{ $role->permissions->count() }} permissions)
                            @endif
                        </option>
                        @endforeach
                    </select>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('users.index') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>

@endsection