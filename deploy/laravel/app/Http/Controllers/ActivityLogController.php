<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // PART 1: Statistik Ringkas di Atas
        // ==========================================
        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate('created_at', now()->toDateString())->count();
        $activeUsers = ActivityLog::distinct('user_id')->count('user_id');

        // ==========================================
        // Inisialisasi Query & Relasi
        // ==========================================
        $query = ActivityLog::with('user')->latest();

        // ==========================================
        // PART 2: Search Activity Log ⭐
        // ==========================================
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // ==========================================
        // PART 3: Filter Dropdown
        // ==========================================
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Ambil daftar modul & aksi unik dari DB untuk opsi dropdown
$modules = ActivityLog::distinct()
    ->where('module', '!=', 'AiApiKey') // <-- Kecualikan AiApiKey
    ->pluck('module')
    ->filter();
            $actions = ActivityLog::distinct()->pluck('action')->filter();

        // Gunakan withQueryString() agar pagination tidak me-reset hasil search/filter
        $logs = $query->paginate(20)->withQueryString();

        return view('admin.activity-logs.index', compact(
            'logs', 'totalLogs', 'todayLogs', 'activeUsers', 'modules', 'actions'
        ));
    }
}