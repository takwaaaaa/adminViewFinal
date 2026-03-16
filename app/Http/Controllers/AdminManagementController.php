<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminManagementController extends Controller
{
    public function index()
    {
        // Only approved admins — no pending section anymore
        $admins = User::where('role', 'superadmin')
            ->where('approval_status', 'approved')
            ->where('id', '!=', auth()->id())
            ->orderBy('approved_at', 'desc')
            ->paginate(15);

        return view('pages.admin-management.index', compact('admins'));
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