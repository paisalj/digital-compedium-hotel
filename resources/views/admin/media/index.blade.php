@extends('admin.layouts.app')

@section('title', 'Media')
@section('page-title', 'Media')

@section('content')
<div class="p-6">
    <div class="bg-white p-6 shadow-sm rounded-lg border border-gray-200">
        
        <!-- Header Utama -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b pb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Media Library</h2>
                <p class="text-sm text-gray-600">Kelola semua aset gambar dan file Anda di sini.</p>
            </div>
            

            <a href="{{ route('admin.media.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Media
            </a>
            <!-- Tombol Recycle Bin -->
            <a href="{{ route('admin.media.trash') }}" class="mt-4 md:mt-0 bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Recycle Bin
            </a>
        </div>

@if ($errors->any())
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

        <!-- Form Pencarian -->
        <form action="{{ route('admin.media.index') }}" method="GET" class="flex gap-2 mb-8">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama..." 
                   class="w-full md:w-1/3 border border-gray-300 p-2.5 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
                Cari
            </button>
        </form>
        
        <!-- Form Upload -->
        <!-- Galeri Gambar Grid -->
        <div>
            <h3 class="font-semibold mb-4 text-gray-700 border-b pb-2">Daftar Media Tersimpan</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @forelse($media as $item)
                    <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition group relative">
                        <!-- Tampilan Gambar -->
                        <div class="w-full h-32 bg-gray-100 flex items-center justify-center">
                            <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->alt_text ?? 'Media' }}" class="w-full h-full object-cover">
                        </div>
                        
<!-- Informasi File -->
<div class="p-2 bg-gray-50 border-t border-gray-200">
    <p class="text-xs text-gray-800 font-semibold truncate text-center" title="{{ $item->alt_text ?? $item->file_name }}">
        {{ $item->alt_text ?? $item->file_name }}
    </p>
</div>

<!-- Form Hapus yang Sudah Diperbaiki -->
<form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}" class="absolute top-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
    @csrf
    @method('DELETE')
    
    <button type="button" onclick="confirmDelete({{ $item->id }})" 
            class="bg-red-500 text-white p-1.5 rounded-full hover:bg-red-600 shadow-md transition" title="Hapus Gambar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>
</form>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <p>Belum ada media yang diunggah.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form berdasarkan ID unik
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

@endsection