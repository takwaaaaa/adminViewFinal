<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        abort_unless($user->isSuperAdmin() || $user->hasPermissionTo('consult_logs'), 403);

        $query = AuditLog::with('actor')
            ->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('actor_id')) {
            $query->where('actor_id', $request->actor_id);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $logs    = $query->paginate(25)->withQueryString();
        $actions = AuditLog::distinct()->orderBy('action')->pluck('action');
        $admins  = User::where('role', 'superadmin')->orderBy('name')->get();

        return view('pages.audit-logs.index', [
            'title'   => 'Audit Logs',
            'logs'    => $logs,
            'actions' => $actions,
            'admins'  => $admins,
        ]);
    }
}