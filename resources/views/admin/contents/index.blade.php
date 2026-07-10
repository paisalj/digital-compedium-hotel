@extends('admin.layouts.app')

@section('title', 'Konten')
@section('page-title', 'Konten')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Konten</h2>
            <p class="text-gray-500">Kelola konten</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
<button type="submit" form="form-urut-konten" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-medium inline-flex items-center gap-2 shadow-sm transition text-sm">
    <i class="bi bi-arrow-down-up"></i> Simpan Susunan Urutan
</button>
            <a href="{{ route('admin.contents.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl inline-flex items-center gap-2 shadow-sm transition font-medium text-sm">
                <i class="bi bi-plus-circle"></i> + Tambah Konten
            </a>
            <a href="{{ route('admin.contents.trash') }}" class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
                <i class="bi bi-trash3"></i> Recycle Bin
            </a>
        </div>
    </div>

    <div class="mb-6 bg-gray-50 p-3 rounded-xl border border-gray-100">
        <span class="text-xs font-semibold text-gray-400 block mb-2 uppercase tracking-wider pl-1">Filter Kategori:</span>
<div class="flex flex-nowrap overflow-x-auto gap-2 pb-2 shadow-inner" style="-webkit-overflow-scrolling: touch;">
    <a href="{{ route('admin.contents.index') }}" 
       class="shrink-0 px-4 py-2 text-xs font-medium rounded-xl transition {{ !$selectedCategory ? 'bg-gray-800 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
        Semua Konten
    </a>
    @foreach($categories as $cat)
        @php
            $catName = $cat->translations->where('language.code', app()->getLocale())->first()->name ?? $cat->translations->first()->name ?? 'Kategori ' . $cat->id;
        @endphp
        <a href="{{ route('admin.contents.index', ['category_id' => $cat->id]) }}" 
           class="shrink-0 px-4 py-2 text-xs font-medium rounded-xl transition {{ $selectedCategory == $cat->id ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
            {{ $catName }}
        </a>
    @endforeach
</div>
    </div>
<div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-3">
    <form action="{{ route('admin.contents.index') }}" method="GET" class="w-full sm:w-auto flex gap-2">
        @if($selectedCategory)
            <input type="hidden" name="category_id" value="{{ $selectedCategory }}">
        @endif
        
        <div class="relative w-full sm:w-72">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Cari judul konten..." 
                   class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50/50 transition"
            >
            <i class="bi bi-search absolute left-3.5 top-3 text-gray-400 text-sm"></i>
        </div>
        
        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition shadow-sm">
            Cari
        </button>

        @if(request('search'))
            <a href="{{ route('admin.contents.index', $selectedCategory ? ['category_id' => $selectedCategory] : []) }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-medium transition flex items-center justify-center">
                Reset
            </a>
        @endif
    </form>

    @if(request('search'))
        <div class="text-sm text-gray-500 w-full sm:w-auto text-left sm:text-right">
            Menampilkan hasil untuk: <span class="font-semibold text-gray-800">"{{ request('search') }}"</span>
        </div>
    @endif
</div>
    @if (session('success'))
        <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-xl flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-xl flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        </div>
    @endif

    @if($contents->count())
        <div class="overflow-x-auto border border-gray-100 rounded-xl shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/70 border-b border-gray-100">
                    <tr>
                        <th class="py-3.5 pl-4 font-semibold text-gray-600 text-sm w-12">No</th>
                        <th class="py-3.5 px-6 font-semibold text-gray-600 text-sm w-24">Icon</th>
                        <th class="py-3.5 font-semibold text-gray-600 text-sm">Judul Konten</th> 
                        <th class="py-3.5 font-semibold text-gray-600 text-sm">Kategori</th>
                        <th class="py-3.5 font-semibold text-gray-600 text-sm w-28 text-center">Urutan</th>   
                        <th class="py-3.5 font-semibold text-gray-600 text-sm w-28 text-center">Status</th>   
                        <th class="py-3.5 font-semibold text-gray-600 text-sm w-44 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($contents as $content)
                        <tr class="hover:bg-gray-50/80 transition">
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
                            <td class="py-4 text-sm text-gray-600 font-medium">
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-md border border-gray-200/50">
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
                            
                            <td class="py-4 text-center text-sm">
                                <div class="flex items-center justify-center gap-2 font-medium">
                                    @php
                                        $currentTitle = $content->translations->where('language.code', app()->getLocale())->first()->title ?? $content->translations->first()->title ?? 'Konten';
                                    @endphp

                                    <a href="{{ route('admin.contents.edit', $content) }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 px-2 py-1 rounded-lg transition flex items-center gap-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <span class="text-gray-200">|</span>

                                    <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="inline content-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="konfirmasiHapusKonten(this, '{{ addslashes($currentTitle) }}')" class="text-red-600 hover:text-red-800 hover:bg-red-50 px-2 py-1 rounded-lg transition flex items-center gap-1">
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