<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Media;
use Alert; // Jika memakai Realrashid/Sweetalert, atau nanti kita pakai bawaan Laravel biasa

class SettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan website
     */
  public function index()
    {
        // Kode Anda yang sudah ada untuk mengambil data settings
        $settings = Setting::orderBy('sort_order')->get();
        
        // 👈 2. TAMBAHKAN BARIS INI untuk mengambil semua data gambar dari database
        $media = Media::latest()->get(); 

        // 👈 3. PASTIKAN 'media' IKUT DIMASUKKAN KE DALAM COMPACT
        return view('admin.settings.index', compact('settings', 'media'));
    }

    /**
     * Memproses update data pengaturan secara massal (Bulk Update)
     */
    public function update(Request $request)
    {
        // Validasi input data berupa array data settings
        $request->validate([
            'settings' => 'required|array',
        ]);

        // Lakukan perulangan untuk mengupdate baris key value database satu per satu
        foreach ($request->settings as $key => $value) {
            Setting::where('key', $key)->update([
                'value' => $value
            ]);
        }

        // Redirect kembali dengan pesan sukses
return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}