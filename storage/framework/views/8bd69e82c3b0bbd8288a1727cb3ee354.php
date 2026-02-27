

<?php $__env->startSection('content'); ?>
    <div class="relative z-1 bg-white dark:bg-gray-900 p-6 sm:p-0">
        <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row">
            <!-- Form -->
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto w-full max-w-md pt-10">
                    <a href="/signin"
                        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="stroke-current mr-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Back to sign in
                    </a>
                </div>
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                    <div class="mb-5 sm:mb-8">
                        <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white">
                            Forgot Password?
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Enter the email address linked to your account and we'll send you a password reset link.
                        </p>
                    </div>

                    
                    <?php if(session('status')): ?>
                        <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-700 dark:bg-green-900/20 dark:text-green-400">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('password.email')); ?>">
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
                                    placeholder="Enter your email"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 shadow-sm focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-white/30
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" />
                            </div>

                            <button type="submit"
                                class="flex w-full items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-brand-600">
                                Send Reset Link
                            </button>

                            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                                Remember your password?
                                <a href="/signin" class="text-brand-500 hover:text-brand-600">Sign in</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right panel -->
            <div class="bg-brand-950 relative hidden h-full w-full items-center lg:grid lg:w-1/2">
                <div class="z-1 flex items-center justify-center">
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.fullscreen-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\AdminView\resources\views/pages/auth/forgot-password.blade.php ENDPATH**/ ?>