<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\Media;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. DATA CARD STATISTIK
        $totalCategories = Category::count();
        $activeCategories = Category::where('is_active', true)->count(); 
        $inactiveCategories = $totalCategories - $activeCategories;

        $totalContents = Content::count();
        $activeContents = Content::where('is_active', true)->count();
        $inactiveContents = $totalContents - $activeContents;

        $totalMedia = Media::count();
        $totalLanguages = Language::count();

        $totalCompendiumData = $totalCategories + $totalContents;
        $totalAllActive = $activeCategories + $activeContents;
        $totalAllInactive = $inactiveCategories + $inactiveContents;


        // =========================================================
        // SETTING WAKTU INDONESIA & PEMBERSIHAN OTOMATIS (> 1 BULAN)
        // =========================================================
        // Pastikan zona waktu mengikuti Indonesia (misal WIB / Asia/Jakarta)
        $now = Carbon::now('Asia/Jakarta');
        $oneMonthAgo = (clone $now)->subDays(30);

        // OTOMATIS HAPUS: Hapus data di database jika umurnya sudah > 30 hari
        if (Schema::hasTable('guest_views')) {
            DB::table('guest_views')
                ->where('created_at', '<', $oneMonthAgo)
                ->delete();
        }


        // =========================================================
        // 2. KATEGORI PALING SERING DILIHAT (MURNI 1 BULAN TERAKHIR)
        // =========================================================
        $topLog = DB::table('guest_views')
            ->select('category_name', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $oneMonthAgo)
            ->groupBy('category_name')
            ->orderBy('total', 'desc')
            ->first();

        if ($topLog && $topLog->total > 0) {
            $topCategory = (object) [
                'name'  => $topLog->category_name,
                'views' => $topLog->total
            ];
        } else {
            $topCategory = (object) [
                'name'  => 'Belum Ada Kunjungan Tamu',
                'views' => 0
            ];
        }


        // =========================================================
        // 3. DATA GRAFIK 1 BULAN TERAKHIR (DINAMIS 30 HARI KEBELAKANG)
        // =========================================================
        $chartDates = [];
        $chartViews = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = (clone $now)->subDays($i);
            $chartDates[] = $date->translatedFormat('d M');

            $viewsCount = 0;
            try {
                if (Schema::hasTable('guest_views')) {
                    $viewsCount = DB::table('guest_views')
                        ->whereDate('created_at', $date->toDateString())
                        ->count();
                }
            } catch (\Exception $e) {
                $viewsCount = 0;
            }

            $chartViews[] = $viewsCount; 
        }

// =========================================================
        // 4. STATISTIK PENGGUNAAN BAHASA (1 BULAN TERAKHIR)
        // =========================================================
        if (Schema::hasTable('guest_language_logs')) {
            DB::table('guest_language_logs')
                ->where('created_at', '<', $oneMonthAgo)
                ->delete();
        }

        $totalLangCount = 0;
        $languageUsage = [
            'Indo'    => 0,
            'English' => 0,
            'Dayak'   => 0,
        ];

        try {
            if (Schema::hasTable('guest_language_logs')) {
                $totalLangCount = DB::table('guest_language_logs')
                    ->where('created_at', '>=', $oneMonthAgo)
                    ->count();

                $languageStatsRaw = DB::table('guest_language_logs')
                    ->select('language_name', DB::raw('COUNT(*) as total'))
                    ->where('created_at', '>=', $oneMonthAgo)
                    ->groupBy('language_name')
                    ->get();

                if ($totalLangCount > 0) {
                    foreach ($languageStatsRaw as $stat) {
                        $percentage = round(($stat->total / $totalLangCount) * 100);
                        $languageUsage[$stat->language_name] = $percentage;
                    }
                }
            }
        } catch (\Exception $e) {
            // Fallback aman jika tabel belum siap
        }
        
        
// 🔥 Hitung total kunjungan dari tabel guest_views secara otomatis
    $popularCategories = \Illuminate\Support\Facades\DB::table('guest_views')
        ->select('category_name as name', \Illuminate\Support\Facades\DB::raw('count(*) as total_views'))
        ->groupBy('category_id', 'category_name')
        ->orderBy('total_views', 'desc')
        ->take(6)
        ->get();

// 🔥 Ambil data dari tabel baru guest_device_logs
    $totalDeviceVisits = \Illuminate\Support\Facades\DB::table('guest_device_logs')->count();
    
    $devices = ['Mobile' => 0, 'Tablet' => 0, 'Desktop' => 0];
    
    $rawDevices = \Illuminate\Support\Facades\DB::table('guest_device_logs')
        ->select('device', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
        ->groupBy('device')
        ->get();

    foreach ($rawDevices as $d) {
        if (isset($devices[$d->device])) {
            $devices[$d->device] = $d->total;
        }
    }

    $devicePercentages = [];
    foreach ($devices as $name => $count) {
        $devicePercentages[$name] = $totalDeviceVisits > 0 ? round(($count / $totalDeviceVisits) * 100) : 0;
    }
$topFavoriteContents = Content::with(['translations', 'category.translations'])
        ->withCount('favorites') // Sekarang Laravel akan mencari relasi favorites() di Model Content
        ->orderBy('favorites_count', 'desc')
        ->take(6)
        ->get();


        return view('admin.dashboard.index', compact(
            'totalCategories',
            'activeCategories',
            'inactiveCategories',
            'totalContents',
            'activeContents',
            'inactiveContents',
            'totalMedia',
            'totalLanguages',
            'totalCompendiumData',
            'totalAllActive',
            'totalAllInactive',
            'topCategory',
            'chartDates',
            'chartViews',
            'popularCategories',
            'languageUsage',
            'devices',
            'devicePercentages',
            'totalDeviceVisits',
            'topFavoriteContents'
        ));
    }
}