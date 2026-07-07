@extends('admin.layouts.app')

@section('title', 'Kategori')

@section('page-title', 'Kategori')

@section('content')

<!-- 🟢 FORM MANDIRI (DITARUH DI LUAR AGAR TIDAK TERJADI NESTING/TABRAKAN FORM) -->
<form id="form-urutan-kategori" action="{{ route('admin.categories.updateOrder') }}" method="POST" class="hidden">
    @csrf
</form>

<div class="bg-white rounded-2xl shadow-md p-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">

        <div>
            <h2 class="text-2xl font-bold">
                Daftar Kategori
            </h2>
            <p class="text-gray-500">
                Kelola kategori Digital Compendium
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Tombol ini otomatis menembak ke form di atas berkat atribut form="form-urutan-kategori" -->
            <button type="submit" form="form-urutan-kategori" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-medium inline-flex items-center gap-2 shadow-sm transition">
                <i class="bi bi-arrow-down-up"></i> Simpan Susunan Urutan
            </button>

            <a href="{{ route('admin.categories.create') }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-xl inline-flex items-center gap-2 transition">
                <i class="bi bi-plus-circle"></i> Tambah Kategori
            </a>
            
            <a href="{{ route('admin.categories.trash') }}"
               class="bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-xl inline-flex items-center gap-2 transition">
                <i class="bi bi-trash"></i> Recycle Bin
            </a>
        </div>

    </div>

    <!-- Alert Notifikasi Sukses / Gagal -->
    @if (session('success'))
    <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-xl">
        {{ session('error') }}
    </div>
    @endif

    @if($categories->count())

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b">
                <tr>
                    <th class="text-left py-3 w-12">No</th>
                    <th class="text-left">Icon</th>
                    <th class="text-left">Nama</th>
                    <th class="text-left">Slug</th>
                    <th class="text-center w-28">Urutan</th>
                    <th class="text-left">Status</th>
                    <th class="text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
<tr class="border-b hover:bg-gray-50 transition">
    <td class="py-4 font-medium">
        {{ $loop->iteration }}
    </td>
    <td>
        <i class="{{ $category->icon }} text-xl text-yellow-500"></i>
    </td>
    
    {{-- 🌐 PERBAIKAN NAMA: Mengambil terjemahan sesuai bahasa aktif --}}
    <td class="font-semibold text-gray-900">
        {{ $category->translations->where('language.code', app()->getLocale())->first()->name ?? $category->translations->first()->name ?? 'Tanpa Nama' }}
    </td>

    {{-- 🌐 PERBAIKAN SLUG: Mengambil slug sesuai bahasa aktif --}}
    <td class="font-mono text-sm text-gray-500">
        {{ $category->translations->where('language.code', app()->getLocale())->first()->slug ?? $category->translations->first()->slug ?? '-' }}
    </td>
    
    <td class="py-4 text-center">
        <!-- 🟢 DI SINI KUNCINYA: Input ini dihubungkan ke form luar menggunakan atribut form="..." -->
        <input 
            type="number" 
            form="form-urutan-kategori"
            name="orders[{{ $category->id }}]" 
            value="{{ $category->sort_order }}" 
            min="0"
            class="w-20 border rounded-lg px-2 py-1 text-center font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </td>

    <td>
        @if($category->is_active)
        <span class="text-green-600 font-semibold">
            Aktif
        </span>
        @else
        <span class="text-red-600 font-semibold">
            Nonaktif
        </span>
        @endif
    </td>
    <td class="text-center">
        <div class="flex items-center justify-center gap-2 text-sm font-medium">
            {{-- Menggunakan nama dinamis untuk parameter konfirmasi hapus --}}
            @php
                $currentName = $category->translations->where('language.code', app()->getLocale())->first()->name ?? $category->translations->first()->name ?? 'Kategori';
            @endphp

            <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <span class="text-gray-300">|</span>

            <!-- Form Hapus tetap aman di sini karena tidak dibungkus form lain lagi -->
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline category-delete-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="konfirmasiHapusKategori(this, '{{ addslashes($currentName) }}')" class="text-red-600 hover:text-red-800 flex items-center gap-1">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </td>
</tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>

    @else
    <div class="text-center py-16 text-gray-500 italic bg-gray-50 rounded-xl">
        Belum ada kategori.
    </div>
    @endif

</div>

@endsection

<!-- Script SweetAlert2 Konfirmasi Hapus -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiHapusKategori(button, namaKategori) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Kategori '" + namaKategori + "' akan dipindahkan ke Recycle Bin!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Pindahkan!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-4 py-2 font-medium',
                cancelButton: 'rounded-xl px-4 py-2 font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('.category-delete-form').submit();
            }
        });
    }
</script>