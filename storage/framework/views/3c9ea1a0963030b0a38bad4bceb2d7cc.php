<?php $__env->startSection('content'); ?>
    <div class="relative z-1 bg-white dark:bg-gray-900 p-6 sm:p-0">
        <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row">

            <!-- ── Form ───────────────────────────────────────────────────── -->
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto w-full max-w-md pt-10">
                    <a href="/"
                        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="stroke-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Back to dashboard
                    </a>
                </div>
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                    <div>
                        <div class="mb-5 sm:mb-8">
                            <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white">
                                Sign In
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Enter your email and password to sign in!
                            </p>
                        </div>
                        <div>
                            
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-5">
                                <a href="<?php echo e(route('socialite.redirect', 'google')); ?>"
                                    class="inline-flex items-center justify-center gap-3 rounded-lg bg-gray-100 px-7 py-3 text-sm font-normal text-gray-700 transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.7511 10.1944C18.7511 9.47495 18.6915 8.94995 18.5626 8.40552H10.1797V11.6527H15.1003C15.0011 12.4597 14.4654 13.675 13.2749 14.4916L13.2582 14.6003L15.9087 16.6126L16.0924 16.6305C17.7788 15.1041 18.7511 12.8583 18.7511 10.1944Z" fill="#4285F4" />
                                        <path d="M10.1788 18.75C12.5895 18.75 14.6133 17.9722 16.0915 16.6305L13.274 14.4916C12.5201 15.0068 11.5081 15.3666 10.1788 15.3666C7.81773 15.3666 5.81379 13.8402 5.09944 11.7305L4.99473 11.7392L2.23868 13.8295L2.20264 13.9277C3.67087 16.786 6.68674 18.75 10.1788 18.75Z" fill="#34A853" />
                                        <path d="M5.10014 11.7305C4.91165 11.186 4.80257 10.6027 4.80257 9.99992C4.80257 9.3971 4.91165 8.81379 5.09022 8.26935L5.08523 8.1534L2.29464 6.02954L2.20333 6.0721C1.5982 7.25823 1.25098 8.5902 1.25098 9.99992C1.25098 11.4096 1.5982 12.7415 2.20333 13.9277L5.10014 11.7305Z" fill="#FBBC05" />
                                        <path d="M10.1789 4.63331C11.8554 4.63331 12.9864 5.34303 13.6312 5.93612L16.1511 3.525C14.6035 2.11528 12.5895 1.25 10.1789 1.25C6.68676 1.25 3.67088 3.21387 2.20264 6.07218L5.08953 8.26943C5.81381 6.15972 7.81776 4.63331 10.1789 4.63331Z" fill="#EB4335" />
                                    </svg>
                                    Sign in with Google
                                </a>
                                <a href="<?php echo e(route('socialite.redirect', 'twitter')); ?>"
                                    class="inline-flex items-center justify-center gap-3 rounded-lg bg-gray-100 px-7 py-3 text-sm font-normal text-gray-700 transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                    <svg width="21" class="fill-current" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.6705 1.875H18.4272L12.4047 8.75833L19.4897 18.125H13.9422L9.59717 12.4442L4.62554 18.125H1.86721L8.30887 10.7625L1.51221 1.875H7.20054L11.128 7.0675L15.6705 1.875ZM14.703 16.475H16.2305L6.37054 3.43833H4.73137L14.703 16.475Z" />
                                    </svg>
                                    Sign in with X
                                </a>
                            </div>

                            <div class="relative py-3 sm:py-5">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="bg-white dark:bg-gray-900 p-2 text-gray-400 sm:px-5 sm:py-2">Or</span>
                                </div>
                            </div>

                            
                            <form method="POST" action="<?php echo e(route('signin.post')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="space-y-5">

                                    <?php if($errors->any()): ?>
                                        <div class="rounded-lg bg-red-50 p-3 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
                                            <?php echo e($errors->first()); ?>

                                        </div>
                                    <?php endif; ?>

                                    <div>
                                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Email<span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                                            placeholder="info@gmail.com"
                                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-white/30 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" />
                                    </div>

                                    <div>
                                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Password<span class="text-red-500">*</span>
                                        </label>
                                        <div x-data="{ showPassword: false }" class="relative">
                                            <input :type="showPassword ? 'text' : 'password'" name="password"
                                                placeholder="Enter your password"
                                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-white/30 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" />
                                            <span @click="showPassword = !showPassword"
                                                class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400">
                                                <svg x-show="!showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 13.862A3.862 3.862 0 1 1 10 6.138a3.862 3.862 0 0 1 0 7.724zm0-9.224C6.2 4.638 3 7.01 2 10c1 2.99 4.2 5.362 8 5.362S17 12.99 18 10c-1-2.99-4.2-5.362-8-5.362z" clip-rule="evenodd"/>
                                                </svg>
                                                <svg x-show="showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20">
                                                    <path d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.76-1.76A8.67 8.67 0 0 0 18 10c-1-2.99-4.2-5.362-8-5.362a8.6 8.6 0 0 0-3.9.92L3.28 2.22zM10 5.638a4.362 4.362 0 0 1 3.11 7.42l-1.1-1.1a2.862 2.862 0 0 0-3.93-3.93L6.98 6.93A4.35 4.35 0 0 1 10 5.638zM6.89 8.75l1.1 1.1a2.862 2.862 0 0 0 3.26 3.26l1.1 1.1A4.362 4.362 0 0 1 6.89 8.75z"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div x-data="{ checked: false }">
                                            <label for="remember_me"
                                                class="flex cursor-pointer items-center text-sm font-normal text-gray-700 dark:text-gray-400 select-none">
                                                <div class="relative">
                                                    <input type="checkbox" id="remember_me" name="remember" class="sr-only" @change="checked = !checked" />
                                                    <div :class="checked ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'"
                                                        class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                        <span :class="checked ? '' : 'opacity-0'">
                                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                                <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                                Keep me logged in
                                            </label>
                                        </div>
                                        <a href="<?php echo e(route('password.request')); ?>"
                                            class="text-brand-500 hover:text-brand-600 dark:text-brand-400 text-sm">
                                            Forgot password?
                                        </a>
                                    </div>

                                    <button type="submit"
                                        class="bg-brand-500 hover:bg-brand-600 flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition">
                                        Sign In
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Right Panel: Rotating Logos ────────────────────────────── -->
            <div class="bg-brand-950 relative hidden h-full w-full items-center justify-center lg:flex lg:w-1/2 overflow-hidden">

                
                <?php if (isset($component)) { $__componentOriginal167809b0e97e5fdccea89d87d579f7f1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal167809b0e97e5fdccea89d87d579f7f1 = $attributes; } ?>
<?php $component = App\View\Components\Common\CommonGridShape::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('common.common-grid-shape'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Common\CommonGridShape::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal167809b0e97e5fdccea89d87d579f7f1)): ?>
<?php $attributes = $__attributesOriginal167809b0e97e5fdccea89d87d579f7f1; ?>
<?php unset($__attributesOriginal167809b0e97e5fdccea89d87d579f7f1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal167809b0e97e5fdccea89d87d579f7f1)): ?>
<?php $component = $__componentOriginal167809b0e97e5fdccea89d87d579f7f1; ?>
<?php unset($__componentOriginal167809b0e97e5fdccea89d87d579f7f1); ?>
<?php endif; ?>

                
                <div class="relative z-10 flex flex-col items-center justify-center gap-10"
                    x-data="{
                        current: 0,
                        logos: [
                            { src: '/images/logos/dataaset.png',  alt: 'Dataset Logo' },
                            { src: '/images/logos/logo_1.png',    alt: 'Logo 1' },
                            { src: '/images/logos/LOGO2.png',     alt: 'Logo 2' },
                        ],
                        init() {
                            setInterval(() => {
                                this.current = (this.current + 1) % this.logos.length;
                            }, 2500);
                        }
                    }">

                    
                    <div class="relative flex h-48 w-48 items-center justify-center">
                        <template x-for="(logo, index) in logos" :key="index">
                            <div
                                x-show="current === index"
                                x-transition:enter="transition ease-out duration-700"
                                x-transition:enter-start="opacity-0 scale-75 rotate-12"
                                x-transition:enter-end="opacity-100 scale-100 rotate-0"
                                x-transition:leave="transition ease-in duration-500"
                                x-transition:leave-start="opacity-100 scale-100 rotate-0"
                                x-transition:leave-end="opacity-0 scale-75 -rotate-12"
                                class="absolute inset-0 flex items-center justify-center">
                                <img :src="logo.src" :alt="logo.alt"
                                    class="max-h-40 max-w-40 object-contain drop-shadow-[0_0_30px_rgba(41,112,255,0.5)]" />
                            </div>
                        </template>
                    </div>

                    
                    <div class="flex items-center gap-2">
                        <template x-for="(logo, index) in logos" :key="index">
                            <div
                                @click="current = index"
                                :class="current === index
                                    ? 'w-6 bg-brand-400'
                                    : 'w-2 bg-white/30 hover:bg-white/50'"
                                class="h-2 rounded-full transition-all duration-300 cursor-pointer">
                            </div>
                        </template>
                    </div>

                    
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-white tracking-wide">Welcome Admin</h2>
                        <p class="mt-2 text-sm text-gray-400">Manage your team, roles and permissions</p>
                    </div>
                </div>
            </div>

            <!-- Theme toggler -->
            <div class="fixed right-6 bottom-6 z-50">
                <button class="bg-brand-500 hover:bg-brand-600 inline-flex size-14 items-center justify-center rounded-full text-white transition-colors"
                    @click.prevent="$store.theme.toggle()">
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z" fill="" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.fullscreen-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\AdminView\resources\views/pages/auth/signin.blade.php ENDPATH**/ ?>