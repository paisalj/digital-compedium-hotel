@extends('admin.layouts.app')

@section('title', 'Tambah Media')
@section('page-title', 'Tambah Media')

@section('content')
<div class="p-6">
    <!-- Card Utama -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-200">
        
        <!-- Header -->
        <div class="p-6 border-b border-black flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Tambah Media</h2>
                <p class="text-sm text-gray-600">Unggah file gambar baru ke dalam sistem.</p>
            </div>
        <a href="{{ route('admin.media.index') }}" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        </div>

        <!-- Form Grid -->
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Kolom Kiri: Detail -->
<div class="space-y-6">
    <div>
        <label class="block mb-2 font-semibold text-gray-700 text-sm">
            Nama Gambar <span class="text-red-500">*</span>
        </label>
        <input type="text" name="alt_text" placeholder="Contoh: Foto Ayam Goreng Spesial..." required
               class="w-full border border-gray-300 p-3 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
</div>
                <!-- Kolom Kanan: Upload -->
                <div class="space-y-6">
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700 text-sm">Pilih File</label>
                        <input type="file" name="file" required 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg cursor-pointer p-2">
                    </div>

                    <!-- Tombol di Kanan -->
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg font-medium text-sm hover:bg-blue-700 transition shadow-sm">
                            Upload Media
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection