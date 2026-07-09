@extends('admin.layouts.app')

@section('title', 'Konten')

@section('page-title', 'Konten')

@section('content')

<div class="bg-white rounded-2xl shadow-md p-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold">
                Manajemen Konten Portofolio
            </h2>
            <p class="text-gray-500">
                Kelola konten Digital Compendium
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.contents.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl inline-flex items-center gap-2 shadow-sm transition font-medium">
                <i class="bi bi-plus-circle"></i> + Tambah Konten
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

    @if($contents->count())
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b">
                <tr>
                    <th class="text-left py-3 w-12">No</th>
                    <th class="text-left px-6 py-3">Icon</th>
                    <th class="text-left">Judul Konten</th>
                    <th class="text-left">Kategori</th>
                    <th class="text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contents as $content)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-4 font-medium">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-yellow-50 flex justify-center items-center text-yellow-500 text-xl border border-yellow-100 shadow-sm">
                                @if($content->icon)
                                    <i class="bi {{ $content->icon }}"></i>
                                @else
                                    <i class="bi bi-image text-gray-300"></i> {{-- Fallback jika icon kosong --}}
                                @endif
                            </div>
                            
                            <span class="font-medium text-gray-900">{{ $content->title }}</span>
                        </div>
                    </td>

                    {{-- 🌐 Mengambil judul sesuai bahasa aktif --}}
                    <td class="font-semibold text-gray-900">
                        {{ $content->translations->where('language.code', app()->getLocale())->first()->title ?? $content->translations->first()->title ?? 'Tanpa Judul' }}
                    </td>


                    {{-- 🌐 Mengambil nama kategori sesuai bahasa aktif --}}
                    <td class="text-gray-600 font-medium">
                        {{ $content->category->translations->where('language.code', app()->getLocale())->first()->name ?? $content->category->translations->first()->name ?? '-' }}
                    </td>
                    
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-2 text-sm font-medium">
                            @php
                                $currentTitle = $content->translations->where('language.code', app()->getLocale())->first()->title ?? $content->translations->first()->title ?? 'Konten';
                            @endphp

                            <a href="{{ route('admin.contents.edit', $content) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <span class="text-gray-300">|</span>

                            <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="inline content-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="konfirmasiHapusKonten(this, '{{ addslashes($currentTitle) }}')" class="text-red-600 hover:text-red-800 flex items-center gap-1">
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
        {{ $contents->links() }}
    </div>

    @else
    <div class="text-center py-16 text-gray-500 italic bg-gray-50 rounded-xl">
        Belum ada konten yang dibuat.
    </div>
    @endif

</div>

@endsection

<!-- Script SweetAlert2 Konfirmasi Hapus -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiHapusKonten(button, judulKonten) {
        Swal.fire({
            title: 'Hapus Konten?',
            text: "Konten '" + judulKonten + "' akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            buttonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-4 py-2 font-medium',
                cancelButton: 'rounded-xl px-4 py-2 font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('.content-delete-form').submit();
            }
        });
    }
</script>