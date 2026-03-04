<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;

class AdminManagementController extends Controller
{
    public function index()
    {
        // Pending: users waiting for approval (any role)
        $pendingUsers = User::where('approval_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Admins table: only superadmin role, already approved
        // Exclude the currently logged-in superadmin (they manage others, not themselves here)
        $admins = User::where('role', 'superadmin')
            ->where('approval_status', 'approved')
            ->where('id', '!=', auth()->id())  // ← exclude self
            ->orderBy('approved_at', 'desc')
            ->paginate(15);

        return view('pages.admin-management.index', compact('pendingUsers', 'admins'));
    }

    public function approve(Request $request, User $user)
    {
        $role = in_array($request->role, ['user', 'superadmin']) ? $request->role : 'user';

        $user->update([
            'role'            => $role,
            'approval_status' => 'approved',
            'status'          => 'active',
            'approved_at'     => now(),
            'approved_by'     => auth()->id(),
        ]);

        AdminNotification::create([
            'triggered_by' => $user->id,
            'type'         => 'account_approved',
            'message'      => "{$user->name} has been approved as " . ($role === 'superadmin' ? 'Admin' : 'User') . ".",
        ]);

        AuditLog::record(
            $role === 'superadmin' ? 'admin.approved' : 'user.approved',
            $user,
            ['role' => $role]
        );

        return back()->with('success', "{$user->name} approved successfully.");
    }

    public function reject(Request $request, User $user)
    {
        AuditLog::record('user.rejected', $user);

        AdminNotification::create([
            'triggered_by' => $user->id,
            'type'         => 'account_rejected',
            'message'      => "{$user->name}'s account request was rejected.",
        ]);

        $user->delete();

        return back()->with('success', "User rejected and removed.");
    }

    public function toggleStatus(Request $request, User $user)
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        AdminNotification::create([
            'triggered_by' => auth()->id(),
            'type'         => $newStatus === 'active' ? 'account_activated' : 'account_deactivated',
            'message'      => auth()->user()->name . " {$newStatus} admin {$user->name}.",
        ]);

        AuditLog::record(
            $newStatus === 'active' ? 'admin.activated' : 'admin.deactivated',
            $user,
            ['status' => $newStatus]
        );

        return back()->with('success', "{$user->name} has been {$newStatus}.");
    }

    public function edit(User $user)
    {
        return view('pages.admin-management.edit', [
            'editAdmin' => $user,
            'title'     => 'Edit Admin',
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:100'],
            'lname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio'   => ['nullable', 'string', 'max:255'],
        ]);

        $before = $user->only(['name', 'email', 'phone', 'bio']);

        $user->update([
            'name'  => trim($validated['fname'] . ' ' . $validated['lname']),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'bio'   => $validated['bio'] ?? null,
        ]);

        $after = $user->fresh()->only(['name', 'email', 'phone', 'bio']);
        $diff  = [];
        foreach ($before as $key => $oldVal) {
            if ($oldVal !== $after[$key]) {
                $diff[$key] = ['from' => $oldVal, 'to' => $after[$key]];
            }
        }
        if (!empty($diff)) {
            AuditLog::record('admin.updated', $user, $diff);
        }

        return redirect()->route('admin-management.index')
            ->with('success', "{$user->name} updated successfully.");
    }

    public function destroy(User $user)
    {
        AuditLog::record('admin.deleted', $user);
        $name = $user->name;
        $user->delete();

        return back()->with('success', "{$name} has been deleted.");
    }
}