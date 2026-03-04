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
        $query = AuditLog::query()->latest('created_at');

        // Filter by action group
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by actor
        if ($request->filled('actor_id')) {
            $query->where('actor_id', $request->actor_id);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $logs   = $query->paginate(30)->withQueryString();
        $admins = User::where('role', 'superadmin')
                      ->where('approval_status', 'approved')
                      ->orderBy('name')
                      ->get(['id', 'name']);

        $actions = AuditLog::select('action')
                            ->distinct()
                            ->orderBy('action')
                            ->pluck('action');

        return view('pages.audit-logs.index', [
            'title'   => 'Audit Logs',
            'logs'    => $logs,
            'admins'  => $admins,
            'actions' => $actions,
        ]);
    }
}