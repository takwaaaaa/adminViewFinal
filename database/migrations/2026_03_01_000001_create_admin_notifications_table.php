<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();

            // Who triggered this notification (the user who signed up / was acted on)
            $table->foreignId('triggered_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // 'new_signup' | 'account_approved' | 'account_rejected' |
            // 'account_activated' | 'account_deactivated'
            $table->string('type', 50)->index();

            $table->string('message');
            $table->boolean('is_read')->default(false)->index();

            $table->timestamps();

            // Fetch unread notifications fast
            $table->index(['is_read', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};