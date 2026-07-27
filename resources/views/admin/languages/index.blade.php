@extends('admin.layouts.app')

@section('title', 'Bahasa')

@section('page-title', 'Bahasa')

@section('content')

<div class="-m-6 p-6 bg-slate-100 min-h-screen">

    <div class="bg-slate-100 border border-slate-300 rounded-2xl shadow-md p-6">

        <div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>

<h2 class="text-2xl font-bold">
    🌐 Bahasa
</h2>

<p class="text-gray-500">
    Kelola seluruh bahasa yang digunakan sistem.
</p>

        </div>

        <div>

            <a
                href="{{ route('admin.languages.create') }}"
              class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm"
                <i class="bi bi-plus-lg"></i>

                Tambah Bahasa

            </a>

        </div>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-gray-500 text-sm">

                Total Bahasa

            </div>

            <div class="text-3xl font-bold mt-2">

                {{ $languages->total() }}

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-gray-500 text-sm">

                Bahasa Aktif

            </div>

            <div class="text-3xl font-bold text-green-600 mt-2">

                {{ $languages->where('is_active',true)->count() }}

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-gray-500 text-sm">

                Bahasa Nonaktif

            </div>

            <div class="text-3xl font-bold text-red-600 mt-2">

                {{ $languages->where('is_active',false)->count() }}

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow p-5">

            <div class="text-gray-500 text-sm">

                Bahasa Default

            </div>

            <div class="text-xl font-bold text-blue-600 mt-2">

                {{ optional($languages->firstWhere('is_default',true))->name ?? '-' }}

            </div>

        </div>

    </div>

    {{-- Toolbar --}}
    <div class="bg-white rounded-2xl shadow p-5">

        <form
            method="GET"
            action="{{ route('admin.languages.index') }}"
            class="grid lg:grid-cols-4 md:grid-cols-2 gap-4">

            <div>

                <label class="block text-sm font-medium mb-2">

                    Cari Bahasa

                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama / Native / Code..."
                    class="w-full rounded-xl border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">

            </div>

            <div>

                <label class="block text-sm font-medium mb-2">

                    Status

                </label>

                <select
                    name="status"
                    class="w-full rounded-xl border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">

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

            <div>

                <label class="block text-sm font-medium mb-2">

                    Tampilkan

                </label>

                <select
                    name="per_page"
                    class="w-full rounded-xl border-gray-300 focus:border-yellow-500 focus:ring-yellow-500">

                    @foreach([10,25,50,100] as $page)

                        <option
                            value="{{ $page }}"
                            @selected(request('per_page',10)==$page)>

                            {{ $page }} Data

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="flex items-end gap-2">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

                    <i class="bi bi-search"></i>

                    Cari

                </button>

                <a
                    href="{{ route('admin.languages.index') }}"
                    class="border px-5 py-3 rounded-xl hover:bg-gray-100">

                    Reset

                </a>

            </div>

        </form>

    </div>

    {{-- List --}}
    <div class="space-y-5">

        @forelse($languages as $language)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div class="flex items-start gap-5">

                    <div class="text-5xl">

                        {{ $language->flag }}

                    </div>

                    <div>

                        <h3 class="text-2xl font-bold">

                            {{ $language->name }}

                        </h3>

                        <p class="text-gray-500 mt-1">

                            {{ $language->native_name }}

                        </p>

                        <div class="grid grid-cols-2 gap-x-10 gap-y-2 mt-4 text-sm">

                            <div>

                                <span class="font-semibold">

                                    Code :

                                </span>

                                {{ strtoupper($language->code) }}

                            </div>

                            <div>

                                <span class="font-semibold">

                                    Urutan :

                                </span>

                                {{ $language->sort_order }}

                            </div>

                        </div>

                        <div class="flex flex-wrap gap-2 mt-5">

                            @if($language->is_default)

                                <span
                                    class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">

                                    Default

                                </span>

                            @endif

                            @if($language->is_active)

                                <span
                                    class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">

                                    Aktif

                                </span>

                            @else

                                <span
                                    class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">

                                    Nonaktif

                                </span>

                            @endif

                        </div>

                    </div>

                </div>

                <div class="flex flex-wrap gap-3">

                    <a
                        href="{{ route('admin.languages.edit',$language) }}"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition">

                        <i class="bi bi-pencil-square"></i>

                        Edit

                    </a>

                    <form
                        action="{{ route('admin.languages.destroy',$language) }}"
                        method="POST"
                        class="delete-form">

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white transition">

                            <i class="bi bi-trash"></i>

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

    @empty

        <div class="bg-white rounded-2xl shadow p-16 text-center">

            <i class="bi bi-translate text-7xl text-gray-300"></i>

            <h3 class="text-2xl font-bold mt-6">

                Belum Ada Bahasa

            </h3>

            <p class="text-gray-500 mt-2">

                Silakan tambahkan bahasa pertama untuk sistem.

            </p>

            <a
                href="{{ route('admin.languages.create') }}"
                class="inline-flex items-center gap-2 mt-8 bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl">

                <i class="bi bi-plus-circle"></i>

                Tambah Bahasa

            </a>

        </div>
        </div>
        </div>

    @endforelse

    </div>
        {{-- Pagination --}}
    @if($languages->hasPages())

        <div class="bg-white rounded-2xl shadow p-5">

            {{ $languages->withQueryString()->links() }}

        </div>

    @endif

</div>

@push('scripts')

<script>

document.querySelectorAll('.delete-form').forEach(form => {

    form.addEventListener('submit', function(e){

        e.preventDefault();

        Swal.fire({

            title: 'Hapus Bahasa?',

            text: 'Data yang dihapus tidak dapat dikembalikan.',

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