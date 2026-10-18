<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{

public function index(Request $request)
{
    // 1. Siapkan query dasar
    $query = Media::latest();

    // 2. Cek apakah ada input 'search'
    if ($request->has('search') && $request->search != '') {
        $searchKeyword = $request->search;
        $query->where(function($q) use ($searchKeyword) {
            $q->where('alt_text', 'like', '%' . $searchKeyword . '%')
              ->orWhere('file_name', 'like', '%' . $searchKeyword . '%');
        });
    }

    // 3. Gunakan paginate (misal 12 gambar per halaman) dan withQueryString
    // dengan withQueryString, kata kunci pencarian akan tetap terbawa saat pindah halaman
    $media = $query->paginate(10)->withQueryString(); 
    
    return view('admin.media.index', compact('media'));
}

public function store(Request $request)
{
    // 1. Validasi: alt_text sekarang 'required' (wajib)
    $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'alt_text' => 'required|string|max:255', 
    ]);

    if ($request->file('file')) {
        $file = $request->file('file');
        
        // 2. Simpan file ke server
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // 3. Simpan data ke database (langsung gunakan alt_text dari input form)
        Media::create([
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $file->extension(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'alt_text' => $request->alt_text, // Mengambil langsung dari form
        ]);

        // 4. Kembali ke halaman utama dengan pesan sukses
        return redirect()->route('admin.media.index')->with('success', 'Gambar berhasil diunggah ke Media Library!');
    }
}
public function create()
{
    return view('admin.media.create');
}

public function destroy($id)
{
    $media = \App\Models\Media::findOrFail($id);
    $media->delete(); // Ini otomatis akan mengisi kolom deleted_at (Soft Delete)

    return redirect()->route('admin.media.index')->with('success', 'Media dipindahkan ke Recycle Bin.');
}

// Menampilkan halaman sampah
public function trash() {
    $trashMedia = \App\Models\Media::onlyTrashed()->get();
    return view('admin.media.trash', compact('trashMedia'));
}

// Memulihkan file
public function restore($id) {
    $media = \App\Models\Media::onlyTrashed()->findOrFail($id);
    $media->restore();
    return redirect()->route('admin.media.trash')->with('success', 'Media berhasil dipulihkan.');
}

// Menghapus permanen
public function forceDelete($id) {
    $media = \App\Models\Media::onlyTrashed()->findOrFail($id);
    // Hapus file fisik dari storage
    \Storage::delete($media->file_path);
    // Hapus record dari database
    $media->forceDelete();
    return redirect()->route('admin.media.trash')->with('success', 'Media dihapus permanen.');
}

}
