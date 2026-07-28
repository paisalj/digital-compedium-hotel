@extends('admin.layouts.app')

@section('title', 'Tambah Bahasa')

@section('page-title', 'Tambah Bahasa')

@section('content')

<div class="-m-6 p-6 bg-slate-100 min-h-screen">

    <div class="bg-white border border-slate-300 rounded-2xl shadow-md">

<div class="border-b border-slate-200 p-6 flex justify-between items-start">

    <div>

        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">

            🌐 Tambah Bahasa

        </h2>

        <p class="text-gray-500 mt-2">

            Tambahkan bahasa baru yang akan digunakan oleh sistem Digital Compendium.

        </p>

    </div>

    <a
        href="{{ route('admin.languages.index') }}"
        class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-xl shadow-sm transition inline-flex items-center gap-2">

        <i class="bi bi-arrow-left"></i>

        Kembali

    </a>

</div>

<form
        method="POST"
        action="{{ route('admin.languages.store') }}"
    >

        @csrf

        @if ($errors->any())

<div class="mx-6 mt-6 rounded-xl border border-red-200 bg-red-50 p-5">

    <div class="flex items-start gap-3">

        <i class="bi bi-exclamation-circle-fill text-red-600 text-xl"></i>

        <div>

            <h4 class="font-semibold text-red-700">

                Terjadi Kesalahan

            </h4>

            <ul class="mt-2 list-disc pl-5 text-sm text-red-600 space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    </div>

</div>

@endif

        <div class="p-6 space-y-8">
            <div>

    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">

        📝 Informasi Bahasa

    </h3>

    <p class="text-gray-500 mt-1">

        Isi informasi bahasa yang akan ditambahkan ke dalam sistem.

    </p>

</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Nama Bahasa --}}
            <div>

                <label class="block mb-2 font-medium">

                    Nama Bahasa

                </label>

<input
    type="text"
    name="name"
    value="{{ old('name') }}"
    placeholder="Indonesia"
    class="w-full rounded-xl px-4 py-3
    border
    @error('name')
        border-red-500
    @else
        border-gray-400
    @enderror
    text-gray-700
    bg-white
    focus:outline-none
    focus:ring-2
    focus:ring-blue-500
    transition
    shadow-sm">
    
    @error('name')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Native --}}
            <div>

                <label class="block mb-2 font-medium">

                    Nama Asli (Native)

                </label>
<input
    type="text"
    name="native_name"
    value="{{ old('native_name') }}"
    placeholder="indonesia"
    class="w-full rounded-xl px-4 py-3
    border
    @error('native_name')
        border-red-500
    @else
        border-gray-400
    @enderror
    text-gray-700
    bg-white
    focus:outline-none
    focus:ring-2
    focus:ring-blue-500
    transition
    shadow-sm">

                @error('native_name')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Code --}}
            <div>

                <label class="block mb-2 font-medium">

                    Code

                </label>
<input
    type="text"
    name="code"
    value="{{ old('code') }}"
    placeholder="id"
    class="w-full rounded-xl px-4 py-3
    border
    @error('code')
        border-red-500
    @else
        border-gray-400
    @enderror
    text-gray-700
    bg-white
    focus:outline-none
    focus:ring-2
    focus:ring-blue-500
    transition
    shadow-sm">

                @error('code')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Flag --}}
<div>

    <label class="block mb-2 font-medium text-gray-700">

        Emoji Bendera

    </label>

    <div class="flex items-center gap-3">

        <div class="w-full">

            <input
                id="flag-input"
                type="text"
                name="flag"
                value="{{ old('flag') }}"
                placeholder="🇮🇩"
                class="w-full border border-gray-400 rounded-xl px-4 py-3 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">

        </div>

        <div
            id="flag-preview"
            class="hidden w-14 h-14 rounded-xl bg-yellow-50 border border-yellow-200 flex items-center justify-center text-3xl">

        </div>

    </div>

</div>

{{-- Urutan --}}
            <div>

                <label class="block mb-2 font-medium">

                    Urutan

                </label>
<input
    type="text"
    name="sort_order"
    value="{{ old('sort_order') }}"
    placeholder="1"
    class="w-full rounded-xl px-4 py-3
    border
    @error('sort_order')
        border-red-500
    @else
        border-gray-400
    @enderror
    text-gray-700
    bg-white
    focus:outline-none
    focus:ring-2
    focus:ring-blue-500
    transition
    shadow-sm">

                @error('sort_order')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Status --}}
            <div>

                <label class="block mb-2 font-medium">

                    Status

                </label>

                <select
                    name="is_active"
                    class="w-full border rounded-xl px-4 py-3">

                    <option value="1" {{ old('is_active',1)==1 ? 'selected' : '' }}>

                        Aktif

                    </option>

                    <option value="0" {{ old('is_active')==='0' ? 'selected' : '' }}>

                        Nonaktif

                    </option>

                </select>

            </div>

            {{-- Default --}}
<div class="md:col-span-2">

    <div class="border border-gray-300 rounded-xl p-5 bg-gray-50">

        <label class="flex items-start gap-4 cursor-pointer">

            <input
                id="default-checkbox"
                type="checkbox"
                name="is_default"
                value="1"
                {{ old('is_default') ? 'checked' : '' }}
                class="mt-1 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">

            <div>

                <h4 class="font-semibold text-gray-800">

                    Jadikan sebagai Bahasa Default

                </h4>

                <p class="text-sm text-gray-500 mt-1">

                    Bahasa ini akan menjadi bahasa utama sistem dan digunakan sebagai pilihan awal pada halaman tamu maupun admin.

                </p>

            </div>

        </label>

    </div>

</div>

        </div>

<div class="border-t p-6 bg-gray-50 rounded-b-2xl">

    <div class="text-right mb-3">

        <p
            id="form-warning-language"
            class="text-sm text-red-600 font-medium">

            ⚠ Lengkapi seluruh data sebelum menyimpan.

        </p>

    </div>

    <div class="flex justify-end gap-3">

        <a
            href="{{ route('admin.languages.index') }}"
            class="px-5 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition">

            Batal

        </a>

        <button
            id="saveButton"
            type="submit"
            class="px-5 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl shadow-md transition">

            <i class="bi bi-check-circle mr-2"></i>

            Simpan Bahasa

        </button>

    </div>

</div>

    </form>

</div>
</div>
const saveButton=document.getElementById('saveButton');

const warning=document.getElementById('form-warning-language');

function checkLanguageForm(){

    let valid=true;

    document.querySelectorAll('input[type="text"]').forEach(function(input){

        if(input.value.trim()==""){

            valid=false;

        }

    });

    const status=document.querySelector('select[name="is_active"]');

    if(status.value===""){

        valid=false;

    }

    if(valid){

        warning.innerHTML="✅ Semua data telah lengkap dan siap disimpan.";

        warning.classList.remove("text-red-600");

        warning.classList.add("text-green-600");

        saveButton.disabled=false;

        saveButton.classList.remove("opacity-50","cursor-not-allowed");

    }else{

        warning.innerHTML="❌ Lengkapi seluruh data terlebih dahulu.";

        warning.classList.remove("text-green-600");

        warning.classList.add("text-red-600");

        saveButton.disabled=true;

        saveButton.classList.add("opacity-50","cursor-not-allowed");

    }

}

document.querySelectorAll('input,select').forEach(function(el){

    el.addEventListener('input',checkLanguageForm);

    el.addEventListener('change',checkLanguageForm);

});

checkLanguageForm();
@endsection