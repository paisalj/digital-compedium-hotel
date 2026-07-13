@extends('admin.layouts.app')

@section('title', 'Recycle Bin Media')
@section('page-title', 'Recycle Bin')

@section('content')
<div class="p-6">
    <div class="bg-white p-6 shadow-sm rounded-lg border border-gray-200">
        
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center border-b pb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Recycle Bin Media</h2>
                <p class="text-sm text-gray-600">File yang dihapus akan terhapus permanen setelah 30 hari.</p>
            </div>
        <a href="{{ route('admin.media.index') }}" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Galeri Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($trashMedia as $item)
                <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm relative group bg-gray-50">
                    
                    <!-- Tampilan Gambar (Dibuat agak transparan/grayscale karena di trash) -->
                    <div class="w-full h-32 bg-gray-200 flex items-center justify-center grayscale">
                        <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->alt_text }}" class="w-full h-full object-cover opacity-70">
                    </div>
                    
                    <!-- Informasi File -->
                    <div class="p-2 border-t border-gray-200">
                        <p class="text-xs text-gray-600 font-semibold truncate text-center">{{ $item->alt_text ?? $item->file_name }}</p>
                    </div>

                    <!-- Tombol Aksi (Muncul saat hover) -->
                    <div class="absolute top-2 right-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <!-- Restore -->
<!-- Form Restore -->
<form action="{{ route('admin.media.restore', $item->id) }}" method="POST" id="restore-form-{{ $item->id }}">
    @csrf
    <button type="button" onclick="confirmRestore({{ $item->id }})" 
            class="bg-green-500 text-white p-1.5 rounded-full hover:bg-green-600 shadow-md" title="Pulihkan">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
    </button>
</form>
                        <!-- Force Delete -->
<!-- Form Hapus Permanen -->
<form action="{{ route('admin.media.forceDelete', $item->id) }}" method="POST" id="force-delete-form-{{ $item->id }}">
    @csrf
    @method('DELETE')
    <button type="button" onclick="confirmForceDelete({{ $item->id }})" 
            class="bg-red-500 text-white p-1.5 rounded-full hover:bg-red-600 shadow-md" title="Hapus Permanen">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>
</form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    <p>Tidak ada media di dalam Recycle Bin.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    // Fungsi untuk konfirmasi hapus permanen
    function confirmForceDelete(id) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: "File ini akan hilang selamanya!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('force-delete-form-' + id).submit();
            }
        })
    }

    // Fungsi baru untuk konfirmasi pulihkan
    function confirmRestore(id) {
        Swal.fire({
            title: 'Pulihkan Media?',
            text: "File akan dikembalikan ke daftar media utama.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981', // Hijau
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, pulihkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('restore-form-' + id).submit();
            }
        })
    }
</script>

@endsection