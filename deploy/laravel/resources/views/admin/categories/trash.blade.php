@extends('admin.layouts.app')

@section('title', 'Recycle Bin Kategori')

@section('page-title', 'Recycle Bin')

@section('content')

<div class="-m-6 p-6 bg-slate-100 min-h-screen">

<div class="bg-slate-100 border border-slate-300 rounded-2xl shadow-md p-6">
    
<div class="flex justify-between  items-start mb-6">

        <div>

            <h2 class="text-2xl font-bold">

                🗑️ Recycle Bin Kategori

            </h2>

            <p class="text-gray-500">

                Daftar kategori yang telah dihapus.

            </p>
            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">

    <div class="text-2xl">
        ⚠️
    </div>

    <div>

        <h4 class="font-semibold text-yellow-800">
            Informasi Recycle Bin
        </h4>

        <p class="text-sm text-yellow-700 mt-1">
            Semua kategori di Recycle Bin akan
            <strong>dihapus permanen secara otomatis setelah 30 hari</strong>
            apabila tidak dipulihkan (Restore).
        </p>

    </div>

</div>

                    </div>

        <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mt-6 mb-6">

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
        <p class="text-sm text-blue-600 font-medium">
            🗑 Total Dihapus
        </p>

        <h2 class="text-3xl font-bold text-blue-700 mt-2">
            {{ $totalDeleted }}
        </h2>
    </div>

    <div class="bg-green-50 border border-green-200 rounded-xl p-5">
        <p class="text-sm text-green-600 font-medium">
            📅 Hari Ini
        </p>

        <h2 class="text-3xl font-bold text-green-700 mt-2">
            {{ $deletedToday }}
        </h2>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">
        <p class="text-sm text-yellow-600 font-medium">
            📆 Minggu Ini
        </p>

        <h2 class="text-3xl font-bold text-yellow-700 mt-2">
            {{ $deletedThisWeek }}
        </h2>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-xl p-5">
        <p class="text-sm text-red-600 font-medium">
            ♻ Menunggu Restore
        </p>

        <h2 class="text-3xl font-bold text-red-700 mt-2">
            {{ $waitingRestore }}
        </h2>
    </div>

</div>

<div class="flex justify-between items-center mb-4">

    <p class="text-sm text-gray-500">

        Menampilkan
        <span class="font-semibold">
            {{ $categories->total() }}
        </span>
        kategori di Recycle Bin.

    </p>

    @if(request('search'))

        <p class="text-sm text-blue-600">

            Hasil pencarian:
            <strong>"{{ request('search') }}"</strong>

        </p>

    @endif

</div>
    @if($categories->count())

        <div class="overflow-x-auto">
<form method="GET"
      action="{{ route('admin.categories.trash') }}"
      class="flex flex-col lg:flex-row gap-4 mb-6">

    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="🔍 Cari nama kategori..."
        class="flex-1 border rounded-xl px-4 py-3">

    <select
        name="filter"
        class="border rounded-xl px-4 py-3">

        <option value="">Semua Waktu</option>

        <option value="today"
            {{ request('filter')=='today' ? 'selected' : '' }}>
            Hari Ini
        </option>

        <option value="week"
            {{ request('filter')=='week' ? 'selected' : '' }}>
            Minggu Ini
        </option>

        <option value="month"
            {{ request('filter')=='month' ? 'selected' : '' }}>
            Bulan Ini
        </option>

    </select>

    <button
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl">

        Cari

    </button>
    @if(request()->filled('search') || request('filter'))

    <a href="{{ route('admin.categories.trash') }}"
       class="bg-gray-500 hover:bg-gray-600 text-white px-6 rounded-xl flex items-center justify-center">

        <i class="bi bi-arrow-clockwise mr-2"></i>
        Reset

    </a>

@endif

</form>
<div class="w-full overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">

<table class="w-full border-collapse">
<thead class="bg-slate-300 border-b border-slate-400">
                        <tr>
    <th class="text-center py-4 font-semibold text-gray-700 uppercase tracking-wide text-sm">
        No
    </th>

<th class="text-center py-4 font-semibold text-gray-700 uppercase tracking-wide text-sm">Icon</th>
<th class="text-left py-4 font-semibold text-gray-700 uppercase tracking-wide text-sm">Nama</th>
                        <th class="text-left py-4 font-semibold text-gray-700 uppercase tracking-wide text-sm">Slug</th>

                      <th class="text-left py-4 font-semibold text-gray-700 uppercase tracking-wide text-sm">Dihapus</th>
                       <th class="text-left py-4 font-semibold text-gray-700 uppercase tracking-wide text-sm">
                            Sisa Auto Delete
                        </th>

                      <th class="text-center py-4 font-semibold text-gray-700 uppercase tracking-wide text-sm">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @foreach($categories as $category)

<tr class="border-b odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 transition">

<td class="py-4 pl-4 font-medium">
    {{ $categories->firstItem() + $loop->index }}
</td>


                            <td class="text-center py-4">

    @if($category->icon)

        <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center mx-auto">

            <i class="{{ $category->icon }} text-xl text-blue-600"></i>

        </div>

    @else

        <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center mx-auto">

            <i class="bi bi-folder text-gray-400"></i>

        </div>

    @endif

</td>

                        <td class="py-4">

                            {{ $category->name }}

                        </td>

                        <td>

                            {{ $category->slug }}

                        </td>

<td>

    @php

        $days = $category->deleted_at->diffInDays();

    @endphp

    @if($days == 0)

        <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

            🟢 Baru Dihapus

        </span>

    @elseif($days <= 7)

        <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

            🟡 Minggu Ini

        </span>

    @elseif($days <= 30)

        <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">

            🟠 Bulan Ini

        </span>

    @else

        <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

            🔴 Lama

        </span>

    @endif

    <div class="text-xs text-gray-500 mt-1">

        {{ $category->deleted_at->diffForHumans() }}

    </div>

</td>
<td class="text-center">

    @if($category->remaining_days > 20)

        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
            🟢 {{ $category->remaining_days }} Hari Lagi
        </span>

    @elseif($category->remaining_days > 7)

        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
            🟡 {{ $category->remaining_days }} Hari Lagi
        </span>

    @else

        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
            🔴 {{ $category->remaining_days }} Hari Lagi
        </span>

    @endif

</td>
                        <td class="text-center">

                            <div class="flex justify-center gap-2">

<form
    action="{{ route('admin.categories.restore',$category->id) }}"
    method="POST"
    class="restore-form">
                                    @csrf

                                    @method('PATCH')

                                    <button
                                        class="px-4 py-2 bg-green-500 text-white rounded-lg">

                                        Restore

                                    </button>

                                </form>

                                <form
                                    action="{{ route('admin.categories.forceDelete',$category->id) }}"
                                    method="POST"
                                    class="force-delete-form">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg">

                                        Hapus

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

        <div class="text-center py-20">

            <i class="bi bi-trash text-6xl text-gray-300"></i>

            <h3 class="text-2xl font-bold mt-5">

                Recycle Bin Kosong

            </h3>

            <p class="text-gray-500 mt-2">

                Belum ada kategori yang dihapus.

            </p>

        </div>

    @endif

    </div>
</div>
@push('scripts')

<script>

document.querySelectorAll('.force-delete-form').forEach(form=>{

    form.addEventListener('submit',function(e){

        e.preventDefault();

        Swal.fire({

            title:'Hapus Permanen?',

            text:'Data tidak bisa dikembalikan lagi.',

            icon:'warning',

            showCancelButton:true,

            confirmButtonColor:'#dc2626',

            cancelButtonText:'Batal',

            confirmButtonText:'Ya, Hapus'

        }).then((result)=>{

            if(result.isConfirmed){

                form.submit();

            }

        });

    });

});

// ===============================
// Konfirmasi Restore
// ===============================

document.querySelectorAll('.restore-form').forEach(form => {

    form.addEventListener('submit', function (e) {

        e.preventDefault();

        Swal.fire({

            title: 'Restore Kategori?',

            html: `
                <p class="text-gray-600">
                    Kategori akan dikembalikan ke daftar kategori aktif.
                </p>
            `,

            icon: 'question',

            showCancelButton: true,

            confirmButtonColor: '#22c55e',

            cancelButtonColor: '#6b7280',

            confirmButtonText: 'Ya, Restore',

            cancelButtonText: 'Batal',

            reverseButtons: true

        }).then((result) => {

            if (result.isConfirmed) {

                form.submit();

            }

        });

    });

});
</script>

@endpush

@endsection