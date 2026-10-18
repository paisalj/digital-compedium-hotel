@extends('admin.layouts.app')

@section('title', 'Konten')
@section('page-title', 'Konten')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-6 w-full overflow-hidden">
    <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold text-gray-800">
            Manajemen Konten
        </h2>

        <p class="text-gray-500">
            Kelola konten
        </p>
    </div>

    <div class="flex flex-wrap justify-start lg:justify-end gap-2 shrink-0">

        <button
            type="submit"
            form="form-urut-konten"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl text-sm font-medium whitespace-nowrap">

            <i class="bi bi-arrow-down-up"></i>
            Simpan Susunan Urutan

        </button>

        <a
            href="{{ route('admin.contents.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-medium whitespace-nowrap">

            <i class="bi bi-plus-circle"></i>
            Tambah Konten

        </a>

        <a
            href="{{ route('admin.contents.trash') }}"
            class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl text-sm font-medium whitespace-nowrap">

            <i class="bi bi-trash3"></i>
            Recycle Bin

        </a>

    </div>

</div>


<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

    {{-- Total Konten --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-file-earmark-text text-blue-600"></i>
            <p class="text-sm text-blue-600 font-medium">Total Konten</p>
        </div>

        <h2 class="text-3xl font-bold text-blue-700">
            {{ $totalContents }}
        </h2>
    </div>

    {{-- Aktif --}}
    <div class="bg-green-50 border border-green-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-check-circle-fill text-green-600"></i>
            <p class="text-sm text-green-600 font-medium">Konten Aktif</p>
        </div>

        <h2 class="text-3xl font-bold text-green-700">
            {{ $activeContents }}
        </h2>
    </div>

    {{-- Nonaktif --}}
    <div class="bg-red-50 border border-red-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-x-circle-fill text-red-600"></i>
            <p class="text-sm text-red-600 font-medium">Nonaktif</p>
        </div>

        <h2 class="text-3xl font-bold text-red-700">
            {{ $inactiveContents }}
        </h2>
    </div>

    {{-- Recycle Bin --}}
    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-trash3-fill text-yellow-600"></i>
            <p class="text-sm text-yellow-600 font-medium">Recycle Bin</p>
        </div>

        <h2 class="text-3xl font-bold text-yellow-700">
            {{ $trashContents }}
        </h2>
    </div>

</div>

<div class="mb-6 bg-gray-50 p-3 rounded-xl border border-gray-100">

    <span class="text-xs font-semibold text-gray-400 block mb-2 uppercase tracking-wider">
        Filter Kategori
    </span>

    <div class="flex flex-wrap gap-2">

        <a href="{{ route('admin.contents.index') }}"
           class="px-4 py-2 rounded-xl text-xs font-medium
           {{ !$selectedCategory
                ? 'bg-gray-800 text-white'
                : 'bg-white border border-gray-200 hover:bg-gray-100' }}">
            Semua Konten
        </a>

        @foreach($categories as $cat)

            @php
                $catName = $cat->translations
                    ->where('language.code', app()->getLocale())
                    ->first()->name
                    ?? $cat->translations->first()->name
                    ?? 'Kategori '.$cat->id;
            @endphp

            <a href="{{ route('admin.contents.index',['category_id'=>$cat->id]) }}"
               class="px-4 py-2 rounded-xl text-xs font-medium
               {{ $selectedCategory==$cat->id
                    ? 'bg-blue-600 text-white'
                    : 'bg-white border border-gray-200 hover:bg-gray-100' }}">
                {{ $catName }}
            </a>

        @endforeach

    </div>

</div>

{{-- =========================
     SEARCH + FILTER
========================= --}}
<form
    action="{{ route('admin.contents.index') }}"
    method="GET"
    class="flex flex-col md:flex-row gap-3 mb-6">

    {{-- Pertahankan filter kategori --}}
    @if($selectedCategory)
        <input
            type="hidden"
            name="category_id"
            value="{{ $selectedCategory }}">
    @endif

    {{-- Search --}}
    <div class="flex-1">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="🔍 Cari judul konten..."
            class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">
    </div>

    {{-- Status --}}
    <select
        name="status"
        class="border rounded-xl px-4 py-3 min-w-[170px]">

        <option value="">Semua Status</option>

        <option value="1"
            @selected(request('status') == '1')>
            Aktif
        </option>

        <option value="0"
            @selected(request('status') == '0')>
            Nonaktif
        </option>

    </select>

    {{-- Cari --}}
    <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl">

        Cari

    </button>

    {{-- Reset --}}
    @if(request()->filled('search') || request()->filled('status'))
        <a
            href="{{ route('admin.contents.index', $selectedCategory ? ['category_id'=>$selectedCategory] : []) }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 rounded-xl flex items-center justify-center">

            Reset

        </a>
    @endif

</form>

@if(
    request()->filled('search') ||
    request()->filled('status') ||
    $selectedCategory
)

@php
    $selectedCategoryData = $categories->firstWhere('id', $selectedCategory);

    $selectedCategoryName = $selectedCategoryData
        ? (
            $selectedCategoryData->translations
                ->where('language.code', app()->getLocale())
                ->first()->name
            ?? $selectedCategoryData->translations->first()->name
            ?? '-'
        )
        : null;
@endphp

<div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 px-5 py-4">

    <div class="flex items-start gap-3">

        <div class="mt-0.5">
            <i class="bi bi-info-circle-fill text-blue-600 text-xl"></i>
        </div>

        <div class="flex-1">

            <h3 class="font-semibold text-blue-800 mb-2">
                Ringkasan Filter
            </h3>

            <div class="flex flex-wrap gap-2">

                <span class="px-3 py-1 rounded-full bg-white border text-sm">
                    📄
                    Total :
                    <strong>{{ $contents->total() }}</strong>
                </span>

                @if($selectedCategory)

                    <span class="px-3 py-1 rounded-full bg-white border text-sm">
                        📂
                        {{ $selectedCategoryName }}
                    </span>

                @endif

                @if(request()->filled('status'))

                    <span
                        class="px-3 py-1 rounded-full border text-sm
                        {{ request('status')=='1'
                            ? 'bg-green-100 text-green-700 border-green-200'
                            : 'bg-red-100 text-red-700 border-red-200' }}">

                        {{ request('status')=='1'
                            ? '✅ Aktif'
                            : '❌ Nonaktif' }}

                    </span>

                @endif

                @if(request()->filled('search'))

                    <span class="px-3 py-1 rounded-full bg-white border text-sm">

                        🔍 "{{ request('search') }}"

                    </span>

                @endif

            </div>

        </div>

    </div>

</div>

@endif
    @if($contents->count())
<div class="w-full overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">
<table class="min-w-full border-separate border-spacing-0">
    
           <thead class="bg-slate-300 border-b border-slate-400">                       
             <tr>
                        <th class="px-4 py-4 text-sm font-semibold text-gray-700">No</th>
                        <th class="py-3.5 px-6 font-semibold text-gray-600 text-sm w-24">Icon</th>
                        <th class="text-left py-3.5 font-semibold text-gray-600 text-sm">Judul Konten</th> 
                        <th class="py-3.5 font-semibold text-gray-600 text-sm">Kategori</th>
                        <th class="py-3.5 font-semibold text-gray-600 text-sm w-28 text-center">Urutan</th>   
                        <th class="py-3.5 font-semibold text-gray-600 text-sm w-28 text-center">Status</th>  
                        <th class="py-3.5 font-semibold text-gray-600 text-sm w-44 text-center">
    Terakhir Diubah
</th> 
                        <th class="py-3.5 font-semibold text-gray-600 text-sm w-44 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($contents as $content)
<tr class="border-b odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 transition">
                            <td class="py-4 pl-4 text-sm font-medium text-gray-500">
                                {{ ($contents->currentPage() - 1) * $contents->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-10 h-10 rounded-xl bg-yellow-50 flex justify-center items-center text-yellow-500 text-xl border border-yellow-100 shadow-sm">
                                    @if($content->icon)
                                        <i class="bi {{ $content->icon }}"></i>
                                    @else
                                        <i class="bi bi-image text-gray-300"></i>
                                    @endif
                                </div>
                            </td>

{{-- 🌐 Mengambil judul sesuai bahasa aktif + Indikator Kelengkapan Bahasa --}}
<td class="py-4 text-sm">
    <span class="font-semibold text-gray-800 block mb-1">
        {{ $content->translations->where('language.code', app()->getLocale())->first()->title ?? $content->translations->first()->title ?? 'Tanpa Judul' }}
    </span>
    
    <div class="flex flex-wrap gap-1">
        @foreach($languages as $lang)
            @php
                // Periksa apakah konten ini memiliki terjemahan untuk ID bahasa yang sedang di-loop
                $hasTranslation = $content->translations->contains('language_id', $lang->id);
            @endphp
            
            @if($hasTranslation)
                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-emerald-50 text-emerald-600 rounded-md border border-emerald-200 uppercase tracking-wider shadow-sm" 
                      title="Terjemahan bahasa {{ $lang->name }} sudah diisi">
                    {{ $lang->code }}
                </span>
            @else
                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-amber-50 text-amber-600 rounded-md border border-amber-200/70 uppercase tracking-wider shadow-sm" 
                      title="Terjemahan bahasa {{ $lang->name }} belum diisi">
                    {{ $lang->code }}
                </span>
            @endif
        @endforeach
    </div>
</td>
                            {{-- 🌐 Mengambil nama kategori sesuai bahasa aktif --}}
<td class="py-4">
    <span
        class="inline-flex items-center max-w-[180px] px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold truncate"
        title="{{ $content->category->translations->where('language.code', app()->getLocale())->first()->name ?? $content->category->translations->first()->name ?? '-' }}">

        {{ $content->category->translations->where('language.code', app()->getLocale())->first()->name ?? $content->category->translations->first()->name ?? '-' }}

    </span>
</td>
                            <td class="py-4 text-center">
                                <input 
                                    type="number" 
                                    form="form-urut-konten"
                                    name="sort_order[{{ $content->id }}]" 
                                    value="{{ $content->sort_order }}" 
                                    min="0"
                                    class="w-16 border border-gray-200 rounded-lg px-1 py-1 text-center font-medium text-sm bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                >
                            </td>

                            <td class="py-4 whitespace-nowrap text-center">
                                @if($content->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                    </span>
                                @endif
                            </td>                    
                            
<td class="py-4 text-left whitespace-nowrap">

    <div class="flex items-center justify-center gap-2">

        <i class="bi bi-clock-history text-gray-400"></i>

        <div class="text-left">

            <div class="text-sm font-medium text-gray-700">
                {{ $content->updated_at->format('d M Y') }}
            </div>

            <div class="text-xs text-gray-400">
                {{ $content->updated_at->diffForHumans() }}
            </div>

        </div>

    </div>

</td>
                            
<td class="text-center">

    @php
        $currentName = $content->translations
            ->where('language.code', app()->getLocale())
            ->first()->name
            ?? $content->translations->first()->name
            ?? 'Konten';
    @endphp

    <div class="flex items-center justify-center gap-2">

        {{-- Tombol Edit --}}
        <a
            href="{{ route('admin.contents.edit', $content) }}"
            title="Edit Konten"
            class="w-10 h-10 rounded-lg bg-blue-100 hover:bg-blue-200
                   text-blue-600 hover:text-blue-700
                   flex items-center justify-center
                   transition duration-200">

            <i class="bi bi-pencil-square"></i>

        </a>

        {{-- Tombol Hapus --}}
        <form
            action="{{ route('admin.contents.destroy', $content) }}"
            method="POST"
            class="inline content-delete-form">

            @csrf
            @method('DELETE')

            <button
                type="button"
                title="Pindahkan ke Recycle Bin"
                onclick="konfirmasiHapusKonten(this, '{{ addslashes($currentName) }}')"
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
            {{ $contents->links() }}
        </div>

    @else
        <div class="text-center py-16 text-gray-400 italic bg-gray-50 border border-dashed rounded-2xl">
            <i class="bi bi-folder-x text-3xl block mb-2 text-gray-300"></i>
            Tidak ada konten yang ditemukan untuk kategori ini.
        </div>
    @endif

    <form id="form-urut-konten" action="{{ route('admin.contents.update-order') }}" method="POST" class="hidden">
        @csrf
        @method('PUT')
    </form>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiHapusKonten(button, judulKonten) {
        Swal.fire({
            title: 'Hapus Konten?',
            text: "Konten '" + judulKonten + "' pindah ke Recycle Bin !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
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