<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            // ── Identity ──────────────────────────────────────────────────
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // ── Profile ───────────────────────────────────────────────────
            // avatar: relative path inside storage/app/public/avatars/
            // null = no upload yet, falls back to UI Avatars initials
            $table->string('avatar')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('bio', 255)->nullable();

            // ── Role ──────────────────────────────────────────────────────
            // 'superadmin' | 'user'
            $table->string('role', 20)->default('user')->index();

            // ── Account status ────────────────────────────────────────────
            // 'active' | 'inactive'
            $table->string('status', 20)->default('inactive')->index();

            // ── Approval workflow ─────────────────────────────────────────
            // 'pending' | 'approved' | 'rejected'
            $table->string('approval_status', 20)->default('pending')->index();
            $table->timestamp('approved_at')->nullable();

            // Who approved this user (self-referencing FK, nullable so first
            // superadmin can be seeded without a circular dependency)
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();

            // ── Composite indexes for common queries ──────────────────────
            // "show me all pending users" — used on admin dashboard
            $table->index(['approval_status', 'created_at']);

            // "show me all active users with role X" — used in management lists
            $table->index(['role', 'status', 'approval_status']);
        });

        // ── Auth support tables (Laravel defaults) ────────────────────────

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};