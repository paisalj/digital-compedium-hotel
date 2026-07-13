<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{

public function index()
{
    // Mengambil semua data media dan mengirimnya ke view
    $media = Media::latest()->get(); 
    return view('admin.media.index', compact('media'));
}

public function store(Request $request)
{
    $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'alt_text' => 'nullable|string|max:255', // Validasi untuk nama gambar
    ]);

    if ($request->file('file')) {
        $file = $request->file('file');
        
        // Nama file asli untuk disimpan di server (tetap pakai waktu agar tidak bentrok)
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Jika user mengisi nama gambar, gunakan itu. Jika tidak, gunakan nama file asli.
        $namaGambar = $request->alt_text ? $request->alt_text : $file->getClientOriginalName();

        Media::create([
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $file->extension(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'alt_text' => $namaGambar, // Disimpan ke database
        ]);

        return back()->with('success', 'Gambar berhasil diunggah ke Media Library!');
    }
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
