<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // Who performed the action.
            // SET NULL on delete so logs survive if the superadmin account
            // is deleted — we still want the historical record.
            $table->foreignId('actor_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Snapshot of the actor's name at time of action.
            // Stored separately so it's readable even after deletion.
            $table->string('actor_name', 150);

            // What happened — use consistent snake_case verbs:
            // 'user.approved' | 'user.rejected' | 'user.deleted'
            // 'user.activated' | 'user.deactivated'
            // 'admin.approved' | 'admin.deleted' | 'admin.updated'
            // 'profile.updated' | 'profile.avatar_changed'
            $table->string('action', 60)->index();

            // What type of record was acted on: 'User', 'Admin', etc.
            $table->string('target_type', 50)->index();

            // The ID of the record acted on.
            // NOT a FK — target may be deleted, log must stay.
            $table->unsignedBigInteger('target_id')->index();

            // Snapshot of target's name/email at time of action.
            $table->string('target_name', 150);
            $table->string('target_email', 255)->nullable();

            // Before/after values for update actions.
            // null for create/delete actions where full diff isn't needed.
            // Example: {"before": {"name": "Old"}, "after": {"name": "New"}}
            $table->json('changes')->nullable();

            // Request metadata
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();

            // Audit logs are append-only — no updated_at needed.
            $table->timestamp('created_at')->useCurrent()->index();

            // ── Indexes for the most common superadmin queries ─────────────

            // "Show all actions by this admin"
            $table->index(['actor_id', 'created_at']);

            // "Show all actions on this user"
            $table->index(['target_type', 'target_id', 'created_at']);

            // "Show all 'user.approved' actions this week"
            $table->index(['action', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};