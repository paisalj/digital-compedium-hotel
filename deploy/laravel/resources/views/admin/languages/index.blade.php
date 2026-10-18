@extends('admin.layouts.app')

@section('title', 'Bahasa')

@section('page-title', 'Bahasa')

@section('content')

<div class="bg-white rounded-2xl shadow-md p-6 w-full overflow-hidden">

    <div class="bg-slate-100 border border-slate-300 rounded-2xl shadow-md p-6">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-6 mb-8">

            <div>

                <h2 class="text-2xl font-bold">
                    🌐 Bahasa
                </h2>

                <p class="text-gray-500 mt-1">
                    Kelola seluruh bahasa yang digunakan sistem Digital Compendium.
                </p>

            </div>



        <a
            href="{{ route('admin.languages.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl text-sm font-medium whitespace-nowrap">

            <i class="bi bi-plus-circle"></i>
            Tambah Konten

        </a>

        </div>

        {{-- CARD STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

            {{-- Total --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">

                <p class="text-sm text-blue-600 font-medium">
                    🌐 Total Bahasa
                </p>

                <h2 class="text-3xl font-bold text-blue-700 mt-2">
                    {{ $languages->total() }}
                </h2>

            </div>

            {{-- Aktif --}}
            <div class="bg-green-50 border border-green-200 rounded-xl p-5">

                <p class="text-sm text-green-600 font-medium">
                    ✅ Bahasa Aktif
                </p>

                <h2 class="text-3xl font-bold text-green-700 mt-2">
                    {{ $languages->where('is_active', true)->count() }}
                </h2>

            </div>

            {{-- Nonaktif --}}
            <div class="bg-red-50 border border-red-200 rounded-xl p-5">

                <p class="text-sm text-red-600 font-medium">
                    ⛔ Bahasa Nonaktif
                </p>

                <h2 class="text-3xl font-bold text-red-700 mt-2">
                    {{ $languages->where('is_active', false)->count() }}
                </h2>

            </div>

            {{-- Default --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">

                <p class="text-sm text-yellow-600 font-medium">
                    ⭐ Bahasa Default
                </p>

                <h2 class="text-xl font-bold text-yellow-700 mt-2">

                    {{ optional($languages->firstWhere('is_default', true))->name ?? '-' }}

                </h2>

            </div>

        </div>

        {{-- TOOLBAR --}}
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-8">

            <form
                method="GET"
                action="{{ route('admin.languages.index') }}"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

                {{-- Search --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">

                        Cari Bahasa

                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nama / Native / Code..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                {{-- Status --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">

                        Status

                    </label>

                    <select
                        name="status"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="active"
                            @selected(request('status')=='active')>

                            Aktif

                        </option>

                        <option
                            value="inactive"
                            @selected(request('status')=='inactive')>

                            Nonaktif

                        </option>

                    </select>

                </div>

                {{-- Per Page --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">

                        Tampilkan

                    </label>

                    <select
                        name="per_page"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">

                        @foreach([10,25,50,100] as $page)

                            <option
                                value="{{ $page }}"
                                @selected(request('per_page',10)==$page)>

                                {{ $page }} Data

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Tombol --}}
                <div class="flex items-end gap-3">

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition">

                        <i class="bi bi-search"></i>

                        Cari

                    </button>

                    <a
                        href="{{ route('admin.languages.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition">

                        Reset

                    </a>

                </div>

            </form>

            {{-- Ringkasan --}}
            <div class="flex justify-between items-center mt-5">

                <p class="text-sm text-gray-500">

                    Menampilkan

                    <span class="font-semibold">

                        {{ $languages->count() }}

                    </span>

                    dari

                    <span class="font-semibold">

                        {{ $languages->total() }}

                    </span>

                    bahasa.

                </p>

                @if(request('search'))

                    <p class="text-sm text-blue-600">

                        Hasil pencarian :

                        <strong>

                            "{{ request('search') }}"

                        </strong>

                    </p>

                @endif

            </div>

        </div>
{{-- LIST DATA --}}
@if($languages->count())

<div class="w-full overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">

<table class="w-full border-collapse">

    <thead class="bg-slate-300 border-b border-slate-400">

        <tr>

            <th class="text-center py-4 w-16 font-semibold uppercase text-sm">
                No
            </th>

            <th class="text-center py-4 w-24 font-semibold uppercase text-sm">
                Flag
            </th>

            <th class="text-left py-4 font-semibold uppercase text-sm">
                Nama Bahasa
            </th>

            <th class="text-left py-4 font-semibold uppercase text-sm">
                Native
            </th>

            <th class="text-center py-4 font-semibold uppercase text-sm">
                Code
            </th>

            <th class="text-center py-4 font-semibold uppercase text-sm">
                Urutan
            </th>

            <th class="text-center py-4 font-semibold uppercase text-sm">
                Status
            </th>

            <th class="text-center py-4 font-semibold uppercase text-sm">
                Default
            </th>

            <th class="text-center py-4 font-semibold uppercase text-sm">
                Aksi
            </th>

        </tr>

    </thead>

    <tbody class="divide-y divide-gray-100">

@foreach($languages as $language)

<tr class="odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 transition">

    <td class="text-center py-4 font-semibold">

        {{ $languages->firstItem() + $loop->index }}

    </td>

    <td class="text-center py-4">

        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center mx-auto text-2xl">

            {{ $language->flag }}

        </div>

    </td>

    <td class="py-4">

        <div class="font-semibold text-gray-800">

            {{ $language->name }}

        </div>

    </td>

    <td class="py-4 text-gray-600">

        {{ $language->native_name }}

    </td>

    <td class="text-center py-4">

        <span class="px-3 py-1 rounded-lg bg-gray-100 text-gray-700 font-semibold">

            {{ strtoupper($language->code) }}

        </span>

    </td>

    <td class="text-center py-4">

        {{ $language->sort_order }}

    </td>

    <td class="text-center py-4">

        @if($language->is_active)

            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">

                🟢 Aktif

            </span>

        @else

            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">

                🔴 Nonaktif

            </span>

        @endif

    </td>

    <td class="text-center py-4">

        @if($language->is_default)

            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">

                ⭐ Default

            </span>

        @else

            <span class="text-gray-400">

                —

            </span>

        @endif

    </td>

    <td class="py-4">

        <div class="flex justify-center gap-2">

            <a
                href="{{ route('admin.languages.edit',$language) }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">

                <i class="bi bi-pencil-square"></i>

            </a>

            <form
                action="{{ route('admin.languages.destroy',$language) }}"
                method="POST"
                class="delete-form">

                @csrf

                @method('DELETE')

                <button
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">

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

@else

<div class="bg-slate-50 border border-dashed border-slate-300 rounded-2xl py-20 text-center">

    <div class="text-6xl mb-5">

        🌐

    </div>

    <h3 class="text-2xl font-bold text-gray-700">

        Belum Ada Bahasa

    </h3>

    <p class="text-gray-500 mt-2">

        Silakan tambahkan bahasa pertama.

    </p>

    <a
        href="{{ route('admin.languages.create') }}"
        class="inline-flex items-center gap-2 mt-8 bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl">

        <i class="bi bi-plus-circle"></i>

        Tambah Bahasa

    </a>

</div>

@endif


{{-- Pagination --}}
@if($languages->hasPages())

<div class="mt-6">

    {{ $languages->withQueryString()->links() }}

</div>

@endif

    </div>

</div>

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.querySelectorAll('.delete-form').forEach(form => {

    form.addEventListener('submit', function(e){

        e.preventDefault();

        Swal.fire({

            title: 'Hapus Bahasa?',

            html: `
                <p class="text-gray-600">
                    Bahasa yang dihapus tidak dapat dikembalikan lagi.
                </p>
            `,

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc2626',

            cancelButtonColor: '#6b7280',

            confirmButtonText: 'Ya, Hapus',

            cancelButtonText: 'Batal',

            reverseButtons: true

        }).then((result)=>{

            if(result.isConfirmed){

                form.submit();

            }

        });

    });

});

</script>
@endpush

@endsection