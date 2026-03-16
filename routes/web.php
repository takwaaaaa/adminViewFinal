<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\NotificationController;

// ─── Guest ────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/signin',  fn() => view('pages.auth.signin',  ['title' => 'Sign In']))->name('login');
    Route::post('/signin', [AuthenticatedSessionController::class, 'store'])->name('signin.post');

    Route::get('/signup',  fn() => view('pages.auth.signup',  ['title' => 'Sign Up']))->name('register');
    Route::post('/signup', [RegisteredUserController::class, 'store'])->name('signup.post');

    Route::get('/forgot-password',        [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password',       [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password',        [NewPasswordController::class, 'store'])->name('password.store');

    Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
        ->name('socialite.redirect')->where('provider', 'google|twitter');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
        ->name('socialite.callback')->where('provider', 'google|twitter');
});

// ─── Logout ───────────────────────────────────────────────────────────────────
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

// ─── Protected (approved + active users) ─────────────────────────────────────
// ALL permission checks are done inside controllers, not via middleware.
// Superadmin always passes. Non-superadmin needs the matching Spatie permission.
Route::middleware(['auth', 'approved'])->group(function () {

    Route::get('/', fn() => view('pages.dashboard.ecommerce', ['title' => 'Dashboard']))->name('dashboard');

    // Profile
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile',   [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])
        ->name('notifications.mark-all-read');

    // ── User Management ───────────────────────────────────────────────────────
    Route::resource('users', UserManagementController::class)->except(['show']);
    Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
        ->name('users.toggle-status');

    // ── Role Management ───────────────────────────────────────────────────────
    Route::get('/roles',                      [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create',               [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles',                     [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{role}',            [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/{role}/permissions',   [RoleController::class, 'permissions'])->name('roles.permissions');
    Route::patch('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    // ── Audit Logs ────────────────────────────────────────────────────────────
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');

    // ── Admin Management (superadmin only — no Spatie equivalent) ─────────────
    Route::middleware('superadmin')->group(function () {
        Route::get('/admin-management',                        [AdminManagementController::class, 'index'])->name('admin-management.index');
        Route::patch('/admin-management/{user}/toggle-status', [AdminManagementController::class, 'toggleStatus'])->name('admin-management.toggle-status');
        Route::get('/admin-management/{user}/edit',            [AdminManagementController::class, 'edit'])->name('admin-management.edit');
        Route::patch('/admin-management/{user}',               [AdminManagementController::class, 'update'])->name('admin-management.update');
        Route::delete('/admin-management/{user}',              [AdminManagementController::class, 'destroy'])->name('admin-management.destroy');
    });

    // ── Other pages ───────────────────────────────────────────────────────────
    Route::get('/calendar',      fn() => view('pages.calender',           ['title' => 'Calendar']))->name('calendar');
    Route::get('/form-elements', fn() => view('pages.form.form-elements', ['title' => 'Form Elements']))->name('form-elements');
    Route::get('/basic-tables',  fn() => view('pages.tables.basic-tables',['title' => 'Basic Tables']))->name('basic-tables');
    Route::get('/blank',         fn() => view('pages.blank',              ['title' => 'Blank']))->name('blank');
    Route::get('/error-404',     fn() => view('pages.errors.error-404',   ['title' => '404 Error']))->name('error-404');
    Route::get('/line-chart',    fn() => view('pages.chart.line-chart',   ['title' => 'Line Chart']))->name('line-chart');
    Route::get('/bar-chart',     fn() => view('pages.chart.bar-chart',    ['title' => 'Bar Chart']))->name('bar-chart');
});