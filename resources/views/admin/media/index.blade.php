@extends('admin.layouts.app')

@section('title', 'Media')
@section('page-title', 'Media')

@section('content')
<div class="p-6">
    <div class="bg-white p-6 shadow-sm rounded-lg border border-gray-200">
        
<!-- Header Utama -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b pb-4 border-gray-400">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Media Library</h2>
        <p class="text-sm text-gray-600">Kelola semua aset gambar dan file Anda di sini.</p>
    </div>
    
    <!-- Wrapper Tombol agar Sejajar -->
    <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
        <!-- Tombol Tambah Media (Warna disamakan dengan Konten) -->
        <a href="{{ route('admin.media.create') }}" class="bg-indigo-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-indigo-700 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Tambah Media
        </a>

        <!-- Tombol Recycle Bin (Warna Merah disamakan dengan Konten) -->
        <a href="{{ route('admin.media.trash') }}" class="bg-red-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-red-700 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Recycle Bin
        </a>
    </div>
</div>
@if ($errors->any())
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif


        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Pencarian -->
<!-- Form Pencarian -->
<form action="{{ route('admin.media.index') }}" method="GET" class="flex gap-2 mb-8 items-center">
    <div class="relative w-full md:w-1/3">
        <!-- Input dengan ikon kaca pembesar kalau mau sama persis -->
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama..." 
               class="w-full border border-gray-300 p-2.5 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    
        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition shadow-sm">
            Cari
        </button>


    <!-- Tombol Reset -->
@if(request('search'))
        <a href="{{ route('admin.media.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-300 transition shadow-sm">
            Reset
        </a>
    @endif
    
    <!-- Teks Penanda Hasil -->
@if(request('search'))
        <div class="ml-auto">
            <p class="text-sm text-gray-600">
                Menampilkan hasil untuk: <strong>"{{ request('search') }}"</strong>
            </p>
        </div>
    @endif

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
                        
                        <!-- Navigasi Halaman -->
<div class="mt-8">
    {{ $media->links() }}
</div>
<!-- Informasi File -->
<!-- Informasi File -->
<div class="p-2 bg-gray-50 border-t border-gray-200">
    <!-- Tambahkan block agar truncate bekerja maksimal -->
    <p class="block text-xs text-gray-800 font-semibold truncate text-center" title="{{ $item->alt_text ?? $item->file_name }}">
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
            text: "Data yang dihapus di pindah ke Recycle Bin !",
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