<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Single source of truth for all permissions in the system
    // Format: 'Group' => [ 'Human Label' => 'permission_slug' ]
    const ALL_PERMISSIONS = [
        'Dashboard' => [
            'Consult Dashboard' => 'consult_dashboard',
        ],
        'Profile' => [
            'Update Profile'    => 'update_profile',
        ],
        'User Management' => [
            'Consult User List' => 'consult_user_list',
            'Create User'       => 'create_user',
            'Edit User'         => 'edit_user',
            'Delete User'       => 'delete_user',
            'Activate User'     => 'activate_user',
            'Deactivate User'   => 'deactivate_user',
        ],
        'Role Management' => [
            'Consult Roles List' => 'consult_roles_list',
            'Create Role'        => 'create_role',
            'Edit Role'          => 'edit_role',
            'Delete Role'        => 'delete_role',
        ],
        'Audit Logs' => [
            'Consult Audit Logs' => 'consult_logs',
        ],
    ];

    private function can(string $permission): bool
    {
        $user = auth()->user();
        return $user->isSuperAdmin() || $user->hasPermissionTo($permission);
    }

    public function index()
    {
        abort_unless($this->can('consult_roles_list'), 403);

        $roles = Role::where('name', '!=', 'superadmin')
            ->withCount('users')
            ->with('permissions')
            ->paginate(20);

        return view('pages.roles.index', [
            'title' => 'Role Management',
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        abort_unless($this->can('create_role'), 403);

        return view('pages.roles.create', [
            'title' => 'Create Role',
        ]);
    }

    public function store(Request $request)
    {
        abort_unless($this->can('create_role'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name'],
        ]);

        // Ensure all permissions exist in DB
        foreach (self::ALL_PERMISSIONS as $slugs) {
            foreach ($slugs as $slug) {
                Permission::firstOrCreate(['name' => $slug, 'guard_name' => 'web']);
            }
        }

        Role::create(['name' => strtolower($validated['name']), 'guard_name' => 'web']);

        return redirect()->route('roles.index')->with('success', 'Role created. You can now assign permissions.');
    }

    public function permissions(Role $role)
    {
        abort_unless($this->can('edit_role'), 403);
        abort_if($role->name === 'superadmin', 403);

        // Ensure all permissions exist
        foreach (self::ALL_PERMISSIONS as $slugs) {
            foreach ($slugs as $slug) {
                Permission::firstOrCreate(['name' => $slug, 'guard_name' => 'web']);
            }
        }

        return view('pages.roles.permissions', [
            'title'          => 'Permissions for ' . ucfirst($role->name),
            'role'           => $role->load('permissions'),
            'allPermissions' => self::ALL_PERMISSIONS,
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        abort_unless($this->can('edit_role'), 403);
        abort_if($role->name === 'superadmin', 403);

        $selected = $request->input('permissions', []);
        $role->syncPermissions($selected);

        // Update permissions cache for users who have this role
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', "Permissions for \"{$role->name}\" updated.");
    }

    public function destroy(Role $role)
    {
        abort_unless($this->can('delete_role'), 403);
        abort_if($role->name === 'superadmin', 403, 'Cannot delete the superadmin role.');

        if ($role->users()->count() > 0) {
            return back()->with('error', "Cannot delete \"{$role->name}\" — it has assigned users.");
        }

        $role->delete();

        return back()->with('success', "Role \"{$role->name}\" deleted.");
    }
}