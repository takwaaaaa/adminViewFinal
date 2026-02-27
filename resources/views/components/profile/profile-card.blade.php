{{--
    resources/views/components/profile/profile-card.blade.php
    Full profile edit: name, email, phone, bio + avatar — all in one POST form.
--}}

@php $user = auth()->user(); @endphp

<div x-data="{ avatarPreview: '{{ $user->avatar_url }}' }">

    {{-- Success / Error flash --}}
    @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-700 dark:bg-green-900/20 dark:text-green-400">
            Profile updated successfully.
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="mb-6 rounded-2xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 lg:p-6">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">

                {{-- Avatar preview + upload --}}
                <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
                    <div class="relative cursor-pointer group"
                         onclick="document.getElementById('avatar-input').click()">
                        <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-600">
                            <img :src="avatarPreview" alt="Avatar"
                                 class="h-full w-full object-cover" />
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                    <input id="avatar-input" type="file" name="avatar" class="hidden" accept="image/*"
                           @change="
                               const f = $event.target.files[0];
                               if (f) avatarPreview = URL.createObjectURL(f);
                           " />

                    <div>
                        <h4 class="mb-1 text-center text-lg font-semibold text-gray-800 dark:text-white xl:text-left">
                            {{ $user->name }}
                        </h4>
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 xl:text-left">
                            {{ $user->bio ?? 'No bio yet' }}
                        </p>
                        <p class="mt-1 text-center text-xs text-gray-400 dark:text-gray-500 xl:text-left">
                            Click photo to change avatar
                        </p>
                    </div>
                </div>

                {{-- Save button top-right --}}
                <button type="submit"
                    class="shadow-theme-xs flex w-full items-center justify-center gap-2 rounded-full border border-brand-500 bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600 xl:inline-flex xl:w-auto">
                    Save Changes
                </button>
            </div>
        </div>

        {{-- Personal Information fields --}}
        <div class="mb-6 rounded-2xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 p-5 lg:p-6">
            <h4 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white">Personal Information</h4>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                {{-- First Name --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        First Name
                    </label>
                    <input type="text" name="fname"
                        value="{{ old('fname', $user->first_name) }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white
                        @error('fname') border-red-500 @enderror" />
                    @error('fname')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Last Name
                    </label>
                    <input type="text" name="lname"
                        value="{{ old('lname', $user->last_name) }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white
                        @error('lname') border-red-500 @enderror" />
                    @error('lname')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <input type="email" name="email"
                        value="{{ old('email', $user->email) }}"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white
                        @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Phone
                    </label>
                    <input type="text" name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="+1 555 000 000"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>

                {{-- Bio --}}
                <div class="lg:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Bio / Role
                    </label>
                    <input type="text" name="bio"
                        value="{{ old('bio', $user->bio) }}"
                        placeholder="e.g. Team Manager"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-sm placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                </div>
            </div>

            {{-- Bottom save button --}}
            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="flex items-center gap-2 rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                    Save Profile
                </button>
            </div>
        </div>

    </form>
</div>