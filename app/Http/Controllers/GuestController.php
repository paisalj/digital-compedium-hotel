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

        // 3. Kembalikan ke file view utama hotelmu
        // NOTE: Kemarin halaman hotelmu sudah muncul, pastikan nama view di bawah ini tetap sesuai ya!
        return view('guest.index', compact('settings')); 
    }    // 2. Halaman Kategori
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

        // 3. AMBIL DATA CATEGORIES DARI DATABASE beserta terjemahannya
        // Pastikan model Category kamu sudah memiliki relasi 'translations'
// Mengambil kategori yang is_active bernilai 1 (Aktif) dan diurutkan berdasarkan sort_order
$categories = Category::where('is_active', 1)
                      ->orderBy('sort_order', 'asc')
                      ->with('translations')
                      ->get();
        // 4. Kirim semua data ke view category
        return view('guest.category', compact('settings', 'categories', 'currentLang'));
    }

    // 3. Halaman Detail Konten
    public function content($slug)
    {
        $settings = $this->getSettings();
        
        // Cari konten berdasarkan slug
        $content = Content::with('category')->where('slug', $slug)->firstOrFail();
        
        // Ambil konten terkait (rekomendasi kamar/konten lain)
        $related_contents = Content::where('category_id', $content->category_id)
            ->where('id', '!=', $content->id)
            ->take(3)
            ->get();

        return view('guest.content', compact('settings', 'content', 'related_contents'));
    }
}