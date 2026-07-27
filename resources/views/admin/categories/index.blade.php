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
            <button type="submit" form="form-urutan-kategori" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-medium inline-flex items-center gap-2 shadow-sm transition text-sm">
                <i class="bi bi-arrow-down-up"></i> Simpan Susunan Urutan
            </button>

            <a href="{{ route('admin.categories.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl inline-flex items-center gap-2 shadow-sm transition font-medium text-sm">
               <i class="bi bi-plus-circle"></i> + Tambah Kategori
            </a>

            <a href="{{ route('admin.categories.trash') }}" class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
                <i class="bi bi-trash3"></i> Recycle Bin
            </a>

        </div>

    </div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

    {{-- Total Kategori --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-folder2-open text-blue-600 text-lg"></i>
            <p class="text-sm text-blue-600 font-medium">Total Kategori</p>
        </div>

        <h2 class="text-3xl font-bold text-blue-700">
            {{ $statistics['total'] }}
        </h2>
    </div>

    {{-- Aktif --}}
    <div class="bg-green-50 border border-green-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
            <p class="text-sm text-green-600 font-medium">Kategori Aktif</p>
        </div>

        <h2 class="text-3xl font-bold text-green-700">
            {{ $statistics['active'] }}
        </h2>
    </div>

    {{-- Nonaktif --}}
    <div class="bg-red-50 border border-red-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-x-circle-fill text-red-600 text-lg"></i>
            <p class="text-sm text-red-600 font-medium">Nonaktif</p>
        </div>

        <h2 class="text-3xl font-bold text-red-700">
            {{ $statistics['inactive'] }}
        </h2>
    </div>

    {{-- Total Konten --}}
    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-file-earmark-text-fill text-yellow-600 text-lg"></i>
            <p class="text-sm text-yellow-600 font-medium">Total Konten</p>
        </div>

        <h2 class="text-3xl font-bold text-yellow-700">
            {{ $statistics['contents'] }}
        </h2>
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

    <form method="GET" class="flex flex-col md:flex-row gap-3 mb-6">

    <div class="flex-1">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="🔍 Cari nama kategori..."
            class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">
    </div>

    <select
        name="status"
        class="border rounded-xl px-4 py-3">

        <option value="">Semua Status</option>

        <option value="1"
            @selected(request('status')==='1')>
            Aktif
        </option>

        <option value="0"
            @selected(request('status')==='0')>
            Nonaktif
        </option>

    </select>

    <button
        class="bg-blue-600 text-white px-6 rounded-xl hover:bg-blue-700">

        Cari

    </button>

    @if(request()->filled('search') || request()->filled('status'))
        <a
            href="{{ route('admin.categories.index') }}"
            class="bg-gray-200 px-5 rounded-xl flex items-center">

            Reset

        </a>
    @endif

</form>
<div class="w-full overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">
<table class="min-w-full border-separate border-spacing-0">
            <thead class="bg-slate-300 border-b border-slate-400">
                <tr>
                    <th class="px-3 py-3 text-sm font-semibold text-gray-500">No</th>
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
<tr class="border-b odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 transition">
             <td class="py-4 px-4 text-sm font-semibold text-gray-500">
        {{ $loop->iteration }}
    </td>
<td>

<div class="w-11 h-11 rounded-xl bg-yellow-100 flex items-center justify-center">

    <i class="{{ $category->icon }} text-yellow-600 text-lg"></i>

</div>

</td>

    {{-- 🌐 PERBAIKAN NAMA: Mengambil terjemahan sesuai bahasa aktif --}}
<td>

    <div class="font-semibold text-gray-900">
        {{ $category->translations->where('language.code', app()->getLocale())->first()->name ?? $category->translations->first()->name ?? 'Tanpa Nama' }}
    </div>

    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
        <i class="bi bi-file-earmark-text mr-1"></i>
        {{ $category->contents_count }} Konten
    </span>

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

<span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

    <i class="bi bi-check-circle-fill"></i>

    Aktif

</span>

@else

<span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

    <i class="bi bi-x-circle-fill"></i>

    Nonaktif

</span>

@endif
    </td>
<td class="text-center">

    @php
        $currentName = $category->translations
            ->where('language.code', app()->getLocale())
            ->first()->name
            ?? $category->translations->first()->name
            ?? 'Kategori';
    @endphp

    <div class="flex items-center justify-center gap-2">

        {{-- Tombol Edit --}}
        <a
            href="{{ route('admin.categories.edit', $category) }}"
            title="Edit Kategori"
            class="w-10 h-10 rounded-lg bg-blue-100 hover:bg-blue-200
                   text-blue-600 hover:text-blue-700
                   flex items-center justify-center
                   transition duration-200">

            <i class="bi bi-pencil-square"></i>

        </a>

        {{-- Tombol Hapus --}}
        <form
            action="{{ route('admin.categories.destroy', $category) }}"
            method="POST"
            class="inline category-delete-form">

            @csrf
            @method('DELETE')

            <button
                type="button"
                title="Pindahkan ke Recycle Bin"
                onclick="konfirmasiHapusKategori(this, '{{ addslashes($currentName) }}')"
                class="w-10 h-10 rounded-lg bg-red-100 hover:bg-red-200
                       text-red-600 hover:text-red-700
                       flex items-center justify-center
                       transition duration-200">

                <i class="bi bi-trash"></i>

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