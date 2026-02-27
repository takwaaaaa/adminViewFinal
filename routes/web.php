<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProfileController;

// ─── Guest routes ──────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {

    Route::get('/signin', fn() => view('pages.auth.signin', ['title' => 'Sign In']))
        ->name('login');
    Route::post('/signin', [AuthenticatedSessionController::class, 'store'])
        ->name('signin.post');

    Route::get('/signup', fn() => view('pages.auth.signup', ['title' => 'Sign Up']))
        ->name('register');
    Route::post('/signup', [RegisteredUserController::class, 'store'])
        ->name('signup.post');

    // ── Forgot / Reset password ──────────────────────────────────────────────
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    // ── Social OAuth ─────────────────────────────────────────────────────────
    Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
        ->name('socialite.redirect')
        ->where('provider', 'google|twitter');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
        ->name('socialite.callback')
        ->where('provider', 'google|twitter');
});

// ─── Logout ────────────────────────────────────────────────────────────────────

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ─── Protected routes ──────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', fn() => view('pages.dashboard.ecommerce', ['title' => 'E-commerce Dashboard']))
        ->name('dashboard');

    // ── Profile ──────────────────────────────────────────────────────────────
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Main Menu ────────────────────────────────────────────────────────────
    Route::get('/calendar',     fn() => view('pages.calender',    ['title' => 'Calendar']))->name('calendar');
    Route::get('/task',         fn() => view('pages.coming-soon', ['title' => 'Task']))->name('task');
    Route::get('/ai-assistant', fn() => view('pages.coming-soon', ['title' => 'AI Assistant']))->name('ai-assistant');
    Route::get('/analytics',    fn() => view('pages.coming-soon', ['title' => 'Analytics']))->name('analytics');
    Route::get('/marketing',    fn() => view('pages.coming-soon', ['title' => 'Marketing']))->name('marketing');
    Route::get('/crm',          fn() => view('pages.coming-soon', ['title' => 'CRM']))->name('crm');

    // ── E-Commerce ───────────────────────────────────────────────────────────
    Route::get('/products',        fn() => view('pages.coming-soon', ['title' => 'Products']))->name('products');
    Route::get('/product-details', fn() => view('pages.coming-soon', ['title' => 'Product Details']))->name('product-details');
    Route::get('/orders',          fn() => view('pages.coming-soon', ['title' => 'Orders']))->name('orders');
    Route::get('/order-details',   fn() => view('pages.coming-soon', ['title' => 'Order Details']))->name('order-details');
    Route::get('/customers',       fn() => view('pages.coming-soon', ['title' => 'Customers']))->name('customers');

    // ── Support ──────────────────────────────────────────────────────────────
    Route::get('/chat',            fn() => view('pages.coming-soon', ['title' => 'Chat']))->name('chat');
    Route::get('/support',         fn() => view('pages.coming-soon', ['title' => 'Support Ticket']))->name('support');
    Route::get('/support/details', fn() => view('pages.coming-soon', ['title' => 'Ticket Details']))->name('support.details');
    Route::get('/email',           fn() => view('pages.coming-soon', ['title' => 'Email Inbox']))->name('email');
    Route::get('/email/compose',   fn() => view('pages.coming-soon', ['title' => 'Compose Email']))->name('email.compose');

    // ── Forms ────────────────────────────────────────────────────────────────
    Route::get('/form-elements', fn() => view('pages.form.form-elements', ['title' => 'Form Elements']))->name('form-elements');
    Route::get('/form-layout',   fn() => view('pages.coming-soon', ['title' => 'Form Layout']))->name('form-layout');

    // ── Tables ───────────────────────────────────────────────────────────────
    Route::get('/basic-tables', fn() => view('pages.tables.basic-tables', ['title' => 'Basic Tables']))->name('basic-tables');
    Route::get('/data-tables',  fn() => view('pages.coming-soon', ['title' => 'Data Tables']))->name('data-tables');

    // ── Pages ────────────────────────────────────────────────────────────────
    Route::get('/blank',     fn() => view('pages.blank',            ['title' => 'Blank']))->name('blank');
    Route::get('/error-404', fn() => view('pages.errors.error-404', ['title' => '404 Error']))->name('error-404');

    // ── Charts ───────────────────────────────────────────────────────────────
    Route::get('/line-chart', fn() => view('pages.chart.line-chart', ['title' => 'Line Chart']))->name('line-chart');
    Route::get('/bar-chart',  fn() => view('pages.chart.bar-chart',  ['title' => 'Bar Chart']))->name('bar-chart');

    // ── UI Elements ──────────────────────────────────────────────────────────
    Route::get('/alerts',  fn() => view('pages.ui-elements.alerts',  ['title' => 'Alerts']))->name('alerts');
    Route::get('/avatars', fn() => view('pages.ui-elements.avatars', ['title' => 'Avatars']))->name('avatars');
    Route::get('/badge',   fn() => view('pages.ui-elements.badges',  ['title' => 'Badges']))->name('badges');
    Route::get('/buttons', fn() => view('pages.ui-elements.buttons', ['title' => 'Buttons']))->name('buttons');
    Route::get('/image',   fn() => view('pages.ui-elements.images',  ['title' => 'Images']))->name('images');
    Route::get('/videos',  fn() => view('pages.ui-elements.videos',  ['title' => 'Videos']))->name('videos');
});