<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Create default permissions ─────────────────────────────────────
        $permissions = ['view', 'create', 'edit', 'delete'];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // ── 2. Create superadmin role with all permissions ────────────────────
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $superadminRole->syncPermissions($permissions);

        // ── 3. FIRST SUPERADMIN  ───────────────────────────────
        $user1 = User::where('email', 'elouaertakwa20@gmail.com')->first();

        if ($user1) {
            $user1->update([
                'role' => 'superadmin',
                'approval_status' => 'approved',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            $user1->syncRoles(['superadmin']);
        }

        // ── 4. SECOND SUPERADMIN  ───────────────────────
        $user2 = User::firstOrCreate(
            ['email' => 'asmagh2004@gmail.com'],
            [
                'name' => 'Asma Admin',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'approval_status' => 'approved',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $user2->syncRoles(['superadmin']);

        $this->command->info("✓ Superadmins ready: {$user2->email}");
    }
}
