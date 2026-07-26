@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')

@section('page-title', 'Tambah Kategori')

@section('content')

<div class="bg-white rounded-2xl shadow-md">

    <div class="border-b p-6  flex justify-between items-center">
        <div>
        <h2 class="text-2xl font-bold">
            Tambah Kategori
        </h2>
        <p class="text-gray-500 mt-1">
            Tambahkan kategori beserta seluruh terjemahannya.
        </p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        @if ($errors->any() || session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-xl mx-6 mt-6">
                <strong class="font-bold block mb-1">⚠️ Ups! Terjadi Kesalahan:</strong>
                
                @if ($errors->any())
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @if (session('error'))
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                @endif
            </div>
        @endif

        <div class="p-6 space-y-8">

            {{-- DATA UTAMA --}}
            <div>
                <h3 class="text-xl font-bold mb-5">📂 Data Kategori</h3>
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 font-medium">Icon</label>
                        <input
                            type="text"required
                            name="icon"
                            value="{{ old('icon') }}"
                            class="w-full border rounded-xl px-4 py-3"
                            placeholder="bi bi-house">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Status</label>
                        <select name="is_active" class="w-full border rounded-xl px-4 py-3">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- TRANSLATION --}}
            <hr>

            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">🌐 Terjemahan Category</h3>
                    <button
                        type="button"
                        id="translate-ai"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl flex items-center gap-2">
                        <i class="bi bi-stars"></i> Terjemahkan AI
                    </button>
                </div>

                @foreach($languages as $language)
                @if(strtolower($language->code) == 'dayak' || strtolower($language->code) == 'dayak-ngaju')
<div class="mb-4 rounded-xl border border-yellow-300 bg-yellow-50 p-4">

    <div class="flex items-start gap-3">

        <i class="bi bi-exclamation-triangle-fill text-yellow-500 text-xl"></i>

        <div>

            <h4 class="font-semibold text-yellow-800">
                Perhatian Terjemahan Bahasa Dayak Ngaju
            </h4>

            <p class="text-sm text-yellow-700 mt-1">
Terjemahan Bahasa Dayak Ngaju dihasilkan oleh AI sebagai bantuan awal.
 Karena dukungan AI terhadap Bahasa Dayak Ngaju masih terbatas, hasil terjemahan mungkin belum sepenuhnya akurat.
  Disarankan untuk memeriksa dan menyesuaikan kembali hasil terjemahan sebelum menyimpan data.

            </p>

        </div>

    </div>

</div>
@endif

                    <div class="border rounded-xl p-6 mb-6 bg-gray-50">
<h4 class="text-lg font-bold mb-5">

    @switch($language->code)

        @case('id')
            Indonesia
        @break

        @case('en')
            English
        @break

        @case('da')
            Dayak Ngaju
        @break

        @default
            {{ $language->flag }} {{ $language->native_name }}

    @endswitch

    @if($language->code == 'da')
    <div class="mb-4">
        <span class="block rounded-lg bg-amber-100 border border-amber-300 text-amber-800 text-sm px-4 py-3">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Catatan:</strong>
            Periksa kembali hasil terjemahan AI sebelum menyimpan. Dukungan AI untuk Bahasa Dayak Ngaju masih terbatas sehingga hasil terjemahan mungkin belum sepenuhnya sesuai.
        </span>
    </div>
@endif

</h4>
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block mb-2">Nama</label>
                                <input
                                    type="text"required
                                    name="translations[{{ $language->id }}][name]"
                                    data-language="{{ $language->code }}"
                                    class="w-full border rounded-xl px-4 py-3">
                            </div>

                            <div>
                                <label class="block mb-2">Slug</label>
                                <input
                                    type="text"required
                                    name="translations[{{ $language->id }}][slug]"
                                    data-slug="{{ $language->code }}"
                                    class="w-full border rounded-xl px-4 py-3">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
<div class="border-t bg-slate-50 rounded-b-2xl p-6">

    <div class="text-right mb-3">

    {{-- Pesan Validasi --}}
    <p
        id="form-warning"
            class="text-sm text-red-600 font-medium">

        ⚠ Lengkapi seluruh data kategori sebelum menyimpan.

    </p>
</div>



    {{-- Tombol --}}
    <div class="flex justify-end items-center gap-3">

            <a href="{{ route('admin.categories.index') }}" class="px-5 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition font-medium">Batal</a>
            <button type="submit" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition font-medium shadow-md shadow-blue-100">Simpan Konten</button>

    </div>

</div>
    </form>

</div>

@endsection
@push('scripts')
<script>
(() => {
    // 1. Ambil ID bahasa default (misal: ID untuk Bahasa Indonesia dari database)
    const defaultLangId = "{{ optional($languages->firstWhere('is_default', true))->id }}";

    // Cari input berdasarkan ID bahasa default-nya secara akurat
    const defaultNameInput = document.querySelector(`[name="translations[${defaultLangId}][name]"]`);
    const defaultSlugInput = document.querySelector(`[name="translations[${defaultLangId}][slug]"]`);

    // =======================================================================
    // Otomatis isi Slug utama saat mengetik Nama utama
    // =======================================================================
    if (defaultNameInput && defaultSlugInput) {
        defaultNameInput.addEventListener('input', function() {
            defaultSlugInput.value = this.value
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w-]/g, '');
        });
    }

    // =======================================================================
    // Tombol Terjemahan AI
    // =======================================================================
    const btnTranslate = document.getElementById('translate-ai');
    if (!btnTranslate) return;

    btnTranslate.addEventListener('click', async function () {
        if (!defaultNameInput || defaultNameInput.value.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Isi Nama Bahasa Utama terlebih dahulu'
            });
            return;
        }

        btnTranslate.disabled = true;
        btnTranslate.innerHTML = `
            <i class="bi bi-arrow-repeat animate-spin"></i> Menerjemahkan...
        `;

        const sourceText = defaultNameInput.value.trim();

        try {
            const response = await fetch("{{ route('admin.categories.translate') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    text: sourceText
                })
            });

            if (response.status === 429 || response.status === 500) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kuota AI Terbatas',
                    text: 'Token/kuota AI telah habis atau terlalu cepat diklik. Silakan coba beberapa saat lagi.',
                });
                restoreButton();
                return; 
            }

            if (!response.ok) {
                throw new Error("HTTP Error : " + response.status);
            }

            const result = await response.json();

            if (!result.success) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menerjemahkan',
                    text: 'Token telah habis, silakan tunggu beberapa saat lagi.',
                });
                restoreButton();
                return; 
            }

            // Membaca object 'translations' dari server berdasarkan ID bahasa
            if (result.translations) {
                Object.keys(result.translations).forEach(langId => {
                    const nameInput = document.querySelector(`[name="translations[${langId}][name]"]`);
                    const slugInput = document.querySelector(`[name="translations[${langId}][slug]"]`);

                    if (nameInput) {
                        nameInput.value = result.translations[langId].name;
                    }
                    if (slugInput) {
                        slugInput.value = result.translations[langId].slug;
                    }
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Terjemahan selesai',
                    timer: 1200,
                    showConfirmButton: false
                });
            }

        } catch (error) {
            console.error("Fetch Error :", error);
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Terputus',
                text: 'Terjadi masalah komunikasi dengan server AI. Silakan coba beberapa saat lagi.',
            });
        }

        restoreButton();
    });

    function restoreButton() {
        btnTranslate.disabled = false;
        btnTranslate.innerHTML = `
            <i class="bi bi-stars"></i> Terjemahkan AI
        `;
    }

    // =============================
// Validasi Form
// =============================

const form = document.querySelector("form");

const submitButton = document.getElementById("btn-submit");

const warning = document.getElementById("form-warning");

function checkForm() {

    const requiredInputs = form.querySelectorAll("[required]");

    let emptyFields = [];

    requiredInputs.forEach(input => {

        if (input.value.trim() === "") {

            const label =
                input.previousElementSibling?.innerText ??
                "Kolom";

            emptyFields.push(label);

        }

    });

    if (emptyFields.length === 0) {

        submitButton.disabled = false;

        submitButton.classList.remove(
            "bg-gray-400",
            "cursor-not-allowed"
        );

        submitButton.classList.add(
            "bg-yellow-500",
            "hover:bg-yellow-600"
        );

        warning.classList.remove("text-red-600");

        warning.classList.add("text-green-600");

        warning.innerHTML =
            "✅ Semua data telah lengkap. Silakan simpan kategori.";

    } else {

        submitButton.disabled = true;

        submitButton.classList.remove(
            "bg-yellow-500",
            "hover:bg-yellow-600"
        );

        submitButton.classList.add(
            "bg-gray-400",
            "cursor-not-allowed"
        );

        warning.classList.remove("text-green-600");

        warning.classList.add("text-red-600");

        warning.innerHTML =
            "⚠ Masih ada <b>" +
            emptyFields.length +
            "</b> kolom yang wajib diisi sebelum menyimpan.";

    }

}

form.addEventListener("input", checkForm);

checkForm();

// ==========================================
// Otomatis update slug saat nama diketik
// ==========================================

document.querySelectorAll('[data-language]').forEach(function(nameInput) {

    nameInput.addEventListener('input', function() {

        const lang = this.dataset.language;

        const slugInput = document.querySelector(`[data-slug="${lang}"]`);

        if (!slugInput) return;

        slugInput.value = this.value
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w-]/g, '');
    });

});

})();
</script>
@endpush