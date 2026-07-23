<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Category; // Pastikan model Category sudah ada
use App\Models\Content;  // Pastikan model Content sudah ada
use Illuminate\Http\Request;

class GuestController extends Controller
{
    // Helper untuk mengambil setting dalam format key-value
    private function getSettings()
    {
        return Setting::pluck('value', 'key')->all();
    }

    // Helper privat untuk mencatat log bahasa tamu secara aman
    private function recordLanguageLog($currentLang)
    {
        try {
            $langMapping = [
                'id'    => 'Indo',
                'en'    => 'English',
                'da'    => 'Dayak',
                'dayak' => 'Dayak'
            ];
            
            $languageName = $langMapping[$currentLang] ?? 'Indo';

            \Illuminate\Support\Facades\DB::table('guest_language_logs')->insert([
                'language_name' => $languageName, 
                'ip_address'    => request()->ip() ?? '127.0.0.1',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal log bahasa: ' . $e->getMessage());
        }
    }


    // 1. Halaman Utama

public function index(Request $request)
    {
        // 1. Tangkap kode bahasa dari URL dan ubah menjadi huruf kecil semua
        $currentLang = strtolower($request->query('lang', session('lang', 'id')));
        
        // 🔥 JEMBATAN LOGIKA BAHASA DAYAK:
        // Analisis Yoga terbukti sukses! Di database kodenya adalah 'da'
        if ($currentLang === 'dayak') {
            $currentLang = 'da'; 
        }
        
        session(['lang' => $currentLang]);

        // 2. Ambil semua setting beserta relasi tabel terjemahannya
        $rawSettings = Setting::with(['translations.language'])->get();
        
        $settings = [];
        foreach ($rawSettings as $setting) {
            $value = $setting->value; // Nilai default (Bahasa Indonesia)
            
            if ($currentLang !== 'id') {
                // Cari terjemahan dengan mencocokkan kode bahasa (diubah ke huruf kecil semua)
                $translation = $setting->translations->first(function ($t) use ($currentLang) {
                    return strtolower(optional($t->language)->code) === $currentLang;
                });
                
                if ($translation && !empty($translation->value)) {
                    $value = $translation->value;
                }
            }
            
            $settings[$setting->key] = $value;
        }
        $this->recordLanguageLog($currentLang);

        // 3. Kembalikan ke file view utama hotelmu
        // NOTE: Kemarin halaman hotelmu sudah muncul, pastikan nama view di bawah ini tetap sesuai ya!
        return view('guest.index', compact('settings')); 
    }   
    
    // 2. Halaman Kategori
public function category(Request $request)
{
    // 1. Ambil bahasa aktif saat ini dari session (default 'id')
    $currentLang = session('lang', 'id');

    // 2. Ambil data settings untuk background & logo
    $rawSettings = Setting::with(['translations.language'])->get();
    $settings = [];
    foreach ($rawSettings as $setting) {
        $value = $setting->value;
        if ($currentLang !== 'id') {
            $translation = $setting->translations->first(function ($t) use ($currentLang) {
                return strtolower(optional($t->language)->code) === $currentLang;
            });
            if ($translation && !empty($translation->value)) {
                $value = $translation->value;
            }
        }
        $settings[$setting->key] = $value;
    }

    // 3. AMBIL DATA CATEGORIES (Logika Admin Mode)
    $query = Category::query(); // Memulai Query Builder

    // Jika yang buka BUKAN admin (tidak login), baru kita pasang filter is_active = 1
    if (!auth()->check()) {
        $query->where('is_active', 1);
    }

    $categories = $query->orderBy('sort_order', 'asc')
                        ->with('translations')
                        ->get();
$this->recordLanguageLog($currentLang);
    // 4. Kirim semua data ke view category
    return view('guest.category', compact('settings', 'categories', 'currentLang'));
}
    // 3. Halaman Detail Konten
public function content($slug)
{
    // 1. Ambil bahasa aktif saat ini
    $currentLang = request('lang', session('lang', 'id'));

    // 2. Cari Kategori berdasarkan slug dengan Filter Admin Mode
    $query = \App\Models\Category::with(['translations', 'contents'])
        ->where('slug', $slug);

    // Satpam: Jika bukan admin, hanya ambil kategori yang aktif
    if (!auth()->check()) {
        $query->where('is_active', 1);
    }

    // Eksekusi query
    $category = $query->firstOrFail(); 



// =========================================================
    // CATAT KUNJUNGAN TAMU (TABEL KHUSUS guest_views)
    // =========================================================
    try {
        $category->increment('views');

        \Illuminate\Support\Facades\DB::table('guest_views')->insert([
            'category_id'   => $category->id,
            'category_name' => $category->name,
            'ip_address'    => request()->ip() ?? '127.0.0.1',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Gagal log tamu: ' . $e->getMessage());
    }

    

// =========================================================
    // TAMBAHAN AMAN: CATAT LOG BAHASA (guest_language_logs)
    // =========================================================
    $this->recordLanguageLog($currentLang);

    // 3. Proses penentuan nama kategori berdasarkan bahasa
    $categoryName = $category->name;
    $langMap = [
        'id'    => 1,
        'en'    => 2,
        'dayak' => 3
    ];
    $targetLangId = $langMap[$currentLang] ?? 1;

    if ($category->translations) {
        $translation = $category->translations->first(function ($t) use ($targetLangId) {
            return (int)$t->language_id === (int)$targetLangId;
        });

        if ($translation) {
            $categoryName = $translation->name;
        }
    }

    // 4. Ambil konten dengan urutan (orderBy) DAN Filter Status
    $contentsQuery = $category->contents()->orderBy('sort_order', 'asc');

    // Satpam: Jika bukan admin, hanya ambil konten yang aktif saja
    if (!auth()->check()) {
        $contentsQuery->where('is_active', 1);
    }

    $contents = $contentsQuery->get(); 

    // 5. Ambil data settings untuk background & logo
    $rawSettings = \App\Models\Setting::with(['translations.language'])->get();
    $settings = [];
    foreach ($rawSettings as $setting) {
        $value = $setting->value;
        if ($currentLang !== 'id') {
            $settingTrans = $setting->translations->first(function ($t) use ($currentLang) {
                return strtolower(optional($t->language)->code) === $currentLang;
            });
            if ($settingTrans && !empty($settingTrans->value)) {
                $value = $settingTrans->value;
            }
        }
        $settings[$setting->key] = $value;
    }

// Catat perangkat tamu ke tabel khusus guest_device_logs
        try {
            $category->increment('views'); // Tetap catat views kategori

            $userAgent = request()->header('User-Agent');
            $device = 'Desktop';
            if (preg_match('/ipad|tablet|(android(?!.*mobile))/i', $userAgent)) {
                $device = 'Tablet';
            } elseif (preg_match('/mobile|android|iphone|ipod|blackberry|iemobile|opera mini/i', $userAgent)) {
                $device = 'Mobile';
            }

            \Illuminate\Support\Facades\DB::table('guest_device_logs')->insert([
                'device'     => $device,
                'ip_address' => request()->ip() ?? '127.0.0.1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal log perangkat: ' . $e->getMessage());
        }

    // 6. Lempar data ke view
    return view('guest.content', compact('category', 'categoryName', 'contents', 'currentLang', 'settings'));
}

public function toggleFavorite(Request $request)
{
    $ip = $request->ip();
    $contentId = $request->content_id;

    // Ambil category_id langsung dari database berdasarkan content_id
    $content = \App\Models\Content::find($contentId);
    $categoryId = $content ? $content->category_id : null;

    // Cek apakah sudah pernah difavoritkan sebelumnya oleh IP ini
    $query = \Illuminate\Support\Facades\DB::table('guest_favorites')
        ->where('ip_address', $ip)
        ->where('content_id', $contentId);

    $existing = $query->first();

    if ($existing) {
        // Jika sudah ada, hapus (batalkan favorit)
        \Illuminate\Support\Facades\DB::table('guest_favorites')->where('id', $existing->id)->delete();
        return response()->json(['status' => 'removed', 'message' => 'Dihapus dari favorit']);
    } else {
        // Jika belum ada, masukkan ke database dengan aman
        \Illuminate\Support\Facades\DB::table('guest_favorites')->insert([
            'ip_address'  => $ip,
            'category_id' => $categoryId,
            'content_id'  => $contentId,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
        return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke favorit']);
    }
}
}