<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Mengambil data log terbaru, dengan relasi ke user
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.activity-logs.index', compact('logs'));
    }
}