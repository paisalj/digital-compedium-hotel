@extends('admin.layouts.app')

@section('title', 'Edit Bahasa')

@section('page-title', 'Edit Bahasa')

@section('content')

<div class="bg-white rounded-2xl shadow-md">

    <div class="border-b p-6 flex justify-between items-center">

        <div>

            <h2 class="text-2xl font-bold text-gray-800">

                🌐 Edit Bahasa

            </h2>

            <p class="text-gray-500 mt-1">

                Perbarui informasi bahasa yang digunakan oleh sistem.

            </p>

        </div>

        <a
            href="{{ route('admin.languages.index') }}"
            class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>

    
<form
    method="POST"
    action="{{ route('admin.languages.update', $language) }}"
>

    @csrf
    @method('PUT')

    <div class="p-6 space-y-8">

        {{-- ========================= --}}
        {{-- INFORMASI BAHASA --}}
        {{-- ========================= --}}

        <div>

            <h3 class="text-xl font-bold mb-5">

                🌐 Informasi Bahasa

            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Bahasa --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">

                        Nama Bahasa

                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $language->name) }}"
                        class="w-full border rounded-xl px-4 py-3 shadow-sm
                        @error('name')
                        border-red-500
                        @else
                        border-gray-300
                        @enderror
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    @error('name')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Nama Native --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">

                        Nama Asli (Native)

                    </label>

                    <input
                        type="text"
                        name="native_name"
                        value="{{ old('native_name', $language->native_name) }}"
                        class="w-full border rounded-xl px-4 py-3 shadow-sm
                        @error('native_name')
                        border-red-500
                        @else
                        border-gray-300
                        @enderror
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    @error('native_name')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Code --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">

                        Kode Bahasa

                    </label>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code', $language->code) }}"
                        class="w-full border rounded-xl px-4 py-3 shadow-sm
                        @error('code')
                        border-red-500
                        @else
                        border-gray-300
                        @enderror
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    @error('code')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Emoji --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">

                        Emoji Bendera

                    </label>

                    <input
                        type="text"
                        name="flag"
                        value="{{ old('flag', $language->flag) }}"
                        placeholder="🇮🇩"
                        class="w-full border rounded-xl px-4 py-3 shadow-sm
                        @error('flag')
                        border-red-500
                        @else
                        border-gray-300
                        @enderror
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    @error('flag')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>

                {{-- Urutan --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">

                        Urutan Tampil

                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', $language->sort_order) }}"
                        class="w-full border rounded-xl px-4 py-3 shadow-sm
                        @error('sort_order')
                        border-red-500
                        @else
                        border-gray-300
                        @enderror
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    @error('sort_order')

                        <p class="mt-2 text-sm text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>
                
                {{-- Status --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">

                        Status Bahasa

                    </label>

                    <select
                        name="is_active"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                        <option
                            value="1"
                            {{ old('is_active', $language->is_active) ? 'selected' : '' }}>

                            Aktif

                        </option>

                        <option
                            value="0"
                            {{ !old('is_active', $language->is_active) ? 'selected' : '' }}>

                            Nonaktif

                        </option>

                    </select>

                    <p class="mt-2 text-sm text-gray-500">

                        Bahasa yang tidak aktif tidak akan ditampilkan kepada pengguna.

                    </p>

                </div>

            </div>

        </div>

        <hr class="border-gray-100">

        {{-- ========================= --}}
        {{-- PENGATURAN BAHASA --}}
        {{-- ========================= --}}

        <div>

            <h3 class="text-xl font-bold mb-5">

                ⚙️ Pengaturan Bahasa

            </h3>

            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">

                <div class="flex items-start gap-4">

                    <input
                        id="is_default"
                        type="checkbox"
                        name="is_default"
                        value="1"
                        class="mt-1 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        {{ old('is_default', $language->is_default) ? 'checked' : '' }}>

                    <div>

                        <label
                            for="is_default"
                            class="font-semibold text-gray-800">

                            Jadikan sebagai Bahasa Default

                        </label>

                        <p class="mt-2 text-sm leading-6 text-gray-500">

                            Jika diaktifkan, bahasa ini akan menjadi bahasa utama
                            sistem dan otomatis digunakan sebagai bahasa awal
                            pada halaman tamu maupun halaman admin.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>
        {{-- ===================================================== --}}
        {{-- INFORMASI TAMBAHAN --}}
        {{-- ===================================================== --}}

        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">

            <div class="flex items-start gap-3">

                <div class="text-blue-600 text-xl">

                    <i class="bi bi-info-circle-fill"></i>

                </div>

                <div>

                    <h4 class="font-semibold text-blue-800">

                        Informasi

                    </h4>

                    <p class="mt-1 text-sm text-blue-700 leading-6">

                        Perubahan data bahasa akan langsung digunakan oleh sistem.
                        Apabila bahasa ini dijadikan sebagai <strong>bahasa default</strong>,
                        maka halaman tamu maupun admin akan menggunakan bahasa ini sebagai
                        bahasa utama.

                    </p>

                </div>

            </div>

        </div>

    </div>

        {{-- ===================================================== --}}
    {{-- FOOTER FORM --}}
    {{-- ===================================================== --}}

    <div class="border-t border-gray-100 bg-gray-50 px-6 py-5 rounded-b-2xl">


        {{-- VALIDATION MESSAGE --}}
        @if ($errors->any())

            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4">

                <div class="flex items-start gap-3">

                    <div class="text-red-600 text-lg">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>


                    <div>

                        <h4 class="font-semibold text-red-700">

                            Terdapat kesalahan

                        </h4>


                        <ul class="mt-2 list-disc list-inside text-sm text-red-600">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>


                    </div>


                </div>


            </div>

        @endif



        {{-- BUTTON AREA --}}

        <div class="flex justify-end gap-3">


            {{-- BUTTON BATAL --}}

            <a href="{{ route('admin.languages.index') }}"
               
               class="
               inline-flex
               items-center
               gap-2
               px-5
               py-2.5
               rounded-xl
               bg-gray-200
               text-gray-700
               font-medium
               hover:bg-gray-300
               transition
               duration-200">

                <i class="bi bi-x-circle"></i>

                Batal

            </a>



            {{-- BUTTON UPDATE --}}

            <button type="submit"

                class="
                inline-flex
                items-center
                gap-2
                px-5
                py-2.5
                rounded-xl
                bg-blue-600
                text-white
                font-medium
                hover:bg-blue-700
                transition
                duration-200
                shadow-sm">


                <i class="bi bi-check-circle"></i>

                Update Bahasa


            </button>


        </div>


    </div>
    </form>

</div>

@endsection