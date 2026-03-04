<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class AuditLog extends Model
{
    // Audit logs are append-only. Never update them.
    public $timestamps = false;

    protected $fillable = [
        'actor_id',
        'actor_name',
        'action',
        'target_type',
        'target_id',
        'target_name',
        'target_email',
        'changes',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'changes'    => 'array',
        'created_at' => 'datetime',
    ];

    // ── Static helper ─────────────────────────────────────────────────────────

    /**
     * Record an audit event. Call this from controllers after every
     * significant action.
     *
     * Usage:
     *   AuditLog::record('user.approved', $user);
     *   AuditLog::record('profile.updated', $user, ['before' => [...], 'after' => [...]]);
     */
    public static function record(
        string $action,
        Model  $target,
        ?array $changes = null
    ): void {
        $actor = auth()->user();

        static::create([
            'actor_id'    => $actor?->id,
            'actor_name'  => $actor?->name ?? 'System',
            'action'      => $action,
            'target_type' => class_basename($target),
            'target_id'   => $target->getKey(),
            'target_name' => $target->name  ?? '—',
            'target_email'=> $target->email ?? null,
            'changes'     => $changes,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'created_at'  => now(),
        ]);
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // ── Scopes — for filtering in the audit log view ──────────────────────────

    public function scopeForAction(Builder $q, string $action): Builder
    {
        return $q->where('action', $action);
    }

    public function scopeForTarget(Builder $q, string $type, int $id): Builder
    {
        return $q->where('target_type', $type)->where('target_id', $id);
    }

    public function scopeForActor(Builder $q, int $actorId): Builder
    {
        return $q->where('actor_id', $actorId);
    }

    public function scopeThisWeek(Builder $q): Builder
    {
        return $q->where('created_at', '>=', now()->startOfWeek());
    }

    public function scopeThisMonth(Builder $q): Builder
    {
        return $q->where('created_at', '>=', now()->startOfMonth());
    }

    // ── Presentation helpers ──────────────────────────────────────────────────

    /**
     * Human-readable label for the action verb.
     */
    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'user.approved'         => 'Approved user',
            'user.rejected'         => 'Rejected user',
            'user.deleted'          => 'Deleted user',
            'user.activated'        => 'Activated user',
            'user.deactivated'      => 'Deactivated user',
            'user.created'          => 'Created user',
            'user.updated'          => 'Updated user',
            'admin.approved'        => 'Approved admin',
            'admin.deleted'         => 'Deleted admin',
            'admin.updated'         => 'Updated admin',
            'admin.activated'       => 'Activated admin',
            'admin.deactivated'     => 'Deactivated admin',
            'profile.updated'       => 'Updated profile',
            'profile.avatar_changed'=> 'Changed avatar',
            default                 => ucfirst(str_replace(['.', '_'], ' ', $this->action)),
        };
    }

    /**
     * Tailwind color classes for the action badge.
     */
    public function getActionColorAttribute(): string
    {
        return match(true) {
            str_contains($this->action, 'approved')  ||
            str_contains($this->action, 'activated') ||
            str_contains($this->action, 'created')   => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',

            str_contains($this->action, 'rejected')  ||
            str_contains($this->action, 'deleted')   => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',

            str_contains($this->action, 'deactivated') => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',

            str_contains($this->action, 'updated')   ||
            str_contains($this->action, 'changed')   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',

            default => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
        };
    }
}