<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /** Check if current user can perform an action (superadmin always can) */
    private function can(string $permission): bool
    {
        $user = auth()->user();
        return $user->isSuperAdmin() || $user->hasPermissionTo($permission);
    }

    public function index(): View
    {
        abort_unless($this->can('consult_user_list'), 403);

        $search   = request('search');
        $status   = request('status');
        $sort     = in_array(request('sort'), ['name', 'email', 'status', 'created_at']) ? request('sort') : 'created_at';
        $dir      = request('direction') === 'asc' ? 'asc' : 'desc';
        $perPage  = in_array((int) request('per_page'), [10, 25, 50, 100]) ? (int) request('per_page') : 10;

        $users = User::where('role', '!=', 'superadmin')
            ->where('approval_status', 'approved')
            ->with('roles')
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            }))
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy($sort, $dir)
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.users.index', [
            'title' => 'User Management',
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        abort_unless($this->can('create_user'), 403);

        $roles = Role::where('name', '!=', 'superadmin')->with('permissions')->get();

        return view('pages.users.create', [
            'title' => 'Add User',
            'roles' => $roles,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($this->can('create_user'), 403);

        $validated = $request->validate([
            'fname'    => ['required', 'string', 'max:100'],
            'lname'    => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'phone'    => ['nullable', 'string', 'max:30'],
            'bio'      => ['nullable', 'string', 'max:255'],
            'role'     => ['required', 'string', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name'            => trim($validated['fname'] . ' ' . $validated['lname']),
            'email'           => $validated['email'],
            'password'        => Hash::make($validated['password']),
            'phone'           => $validated['phone'] ?? null,
            'bio'             => $validated['bio'] ?? null,
            'role'            => $validated['role'],
            'status'          => 'active',
            'approval_status' => 'approved',
            'approved_at'     => now(),
            'approved_by'     => auth()->id(),
        ]);

        // Assign Spatie role — this is what makes permissions work
        $user->assignRole($validated['role']);

        AuditLog::record('user.created', $user, ['role' => $validated['role']]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        abort_unless($this->can('edit_user'), 403);

        $roles = Role::where('name', '!=', 'superadmin')->with('permissions')->get();

        return view('pages.users.edit', [
            'title'    => 'Edit User',
            'editUser' => $user,
            'roles'    => $roles,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($this->can('edit_user'), 403);

        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:100'],
            'lname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio'   => ['nullable', 'string', 'max:255'],
            'role'  => ['required', 'string', 'exists:roles,name'],
        ]);

        $before = $user->only(['name', 'email', 'phone', 'bio', 'role']);

        $user->update([
            'name'  => trim($validated['fname'] . ' ' . $validated['lname']),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'bio'   => $validated['bio'] ?? null,
            'role'  => $validated['role'],
        ]);

        // Sync Spatie role
        $user->syncRoles([$validated['role']]);

        $after = $user->fresh()->only(['name', 'email', 'phone', 'bio', 'role']);
        $diff  = [];
        foreach ($before as $key => $oldVal) {
            if ($oldVal !== $after[$key]) {
                $diff[$key] = ['from' => $oldVal, 'to' => $after[$key]];
            }
        }
        if (!empty($diff)) {
            AuditLog::record('user.updated', $user, $diff);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        $permission = $user->status === 'active' ? 'deactivate_user' : 'activate_user';
        abort_unless($this->can($permission), 403);

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        AdminNotification::create([
            'triggered_by' => auth()->id(),
            'type'         => 'account_' . $newStatus,
            'message'      => "{$user->name}'s account was {$newStatus}d by " . auth()->user()->name . '.',
        ]);

        AuditLog::record('user.' . $newStatus, $user, ['status' => $newStatus]);

        return back()->with('success', "User {$newStatus}d successfully.");
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless($this->can('delete_user'), 403);

        AuditLog::record('user.deleted', $user);
        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')->with('success', "User \"{$name}\" deleted.");
    }
}