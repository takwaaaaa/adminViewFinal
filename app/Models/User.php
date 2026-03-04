<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'avatar', 'phone', 'bio',
        'role', 'status', 'approval_status',
        'approved_at', 'approved_by',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at'       => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0] ?? '';
    }

    public function getLastNameAttribute(): string
    {
        return explode(' ', $this->name, 2)[1] ?? '';
    }

    /**
     * Returns avatar as a data URI (bypasses Windows symlink issues entirely).
     * Falls back to inline SVG initials if no upload exists.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            $diskPath = storage_path('app/public/' . $this->avatar);

            if (file_exists($diskPath)) {
                // Read the file directly and return as data URI
                // This bypasses the broken Windows storage symlink completely
                $mime     = mime_content_type($diskPath);
                $data     = base64_encode(file_get_contents($diskPath));
                return "data:{$mime};base64,{$data}";
            }
        }

        // Inline SVG initials fallback — no external requests
        $name     = $this->name ?: 'User';
        $words    = preg_split('/\s+/', trim($name));
        $initials = strtoupper(
            count($words) >= 2
                ? $words[0][0] . $words[1][0]
                : substr($words[0], 0, 2)
        );

        $bg   = '#E0E7FF';
        $text = '#4338CA';

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128">'
             . '<rect width="128" height="128" rx="64" fill="' . $bg . '"/>'
             . '<text x="64" y="64" dominant-baseline="central" text-anchor="middle" '
             . 'font-family="ui-sans-serif,system-ui,sans-serif" font-size="52" '
             . 'font-weight="700" fill="' . $text . '">' . $initials . '</text>'
             . '</svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    // ── Role / status helpers ─────────────────────────────────────────────────

    public function isSuperAdmin(): bool { return $this->role === 'superadmin'; }
    public function isActive(): bool     { return $this->status === 'active'; }
    public function isApproved(): bool   { return $this->approval_status === 'approved'; }
    public function isPending(): bool    { return $this->approval_status === 'pending'; }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function adminNotifications(): HasMany
    {
        return $this->hasMany(AdminNotification::class, 'triggered_by');
    }
}