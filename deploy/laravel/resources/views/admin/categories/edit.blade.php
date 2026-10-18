@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')

<div class="bg-white rounded-2xl shadow-md">

    <!-- Judul Halaman -->
    <div class="border-b p-6 flex justify-between items-center">
        <div>
        <h2 class="text-2xl font-bold">
            Edit Kategori
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Perbarui data kategori beserta seluruh terjemahannya.
        </p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

    </div>

    @if (session('error'))
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form
        action="{{ route('admin.categories.update', $category) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <div class="p-6 space-y-8">

            <!-- ========================================================= -->
            <!-- BAGIAN 1: DATA KATEGORI (ICON & STATUS) -->
            <!-- ========================================================= -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📁</span>
                    <h3 class="font-bold text-lg text-gray-800">
                        Data Kategori
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Input Icon -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Icon
                        </label>
                        <input
                            type="text"
                            name="icon"
                            value="{{ old('icon', $category->icon) }}"
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                            placeholder="cth: bi bi-house"
                        >
                    </div>

                    <!-- Input Status -->
                    <div>
                        <label class="block mb-2 font-medium text-gray-700">
                            Status
                        </label>
                        <select
                            name="is_active"
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        >
                            <option value="1" {{ $category->is_active ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="0" {{ !$category->is_active ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <!-- ========================================================= -->
            <!-- BAGIAN 2: TERJEMAHAN MULTI-BAHASA -->
            <!-- ========================================================= -->
            <div class="space-y-6">
                <!-- Header Terjemahan & Tombol AI -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">🌐</span>
                        <h3 class="font-bold text-lg text-gray-800">
                            Terjemahan Category
                        </h3>
                    </div>

                    <!-- Tombol Terjemahkan AI -->
                    <button 
                        type="button" 
                        id="btn-translate-ai"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl font-medium flex items-center gap-2 shadow-sm transition"
                    >
                        <span>✨</span>
                        <span>Terjemahkan AI</span>
                    </button>
                </div>

                <!-- Looping Kotak Input Bahasa -->
                <div class="space-y-6">
                    @foreach ($languages as $language)
                        @php
                            $translation = $category->translations->firstWhere('language_id', $language->id);
                            $valName = old("translations.{$language->id}.name", $translation?->name ?? '');
                            $valSlug = old("translations.{$language->id}.slug", $translation?->slug ?? '');
                        @endphp

                        <!-- Kotak Pembungkus Bahasa memakai 'border' murni agar hitam tegas sesuai halaman Create -->
                        <div class="border rounded-2xl p-6 bg-white space-y-4">
                            
<div class="font-bold text-gray-900 text-base">

    @if($language->code == 'id')
        Indonesia
    @elseif($language->code == 'en')
        English
    @elseif(in_array($language->code, ['da','dk']))
        Dayak Ngaju
    @else
        {{ $language->name }}
    @endif
@if(in_array($language->code, ['da','dk']))

<div class="mt-3 mb-5 rounded-xl border border-amber-300 bg-amber-50 p-4">

    <div class="flex items-start gap-3">

        <i class="bi bi-exclamation-triangle-fill text-amber-600 text-lg mt-0.5"></i>

        <div>

            <p class="font-semibold text-amber-700">

                Perhatian Bahasa Dayak Ngaju

            </p>

            <p class="text-sm text-amber-700 mt-1">

                Hasil terjemahan AI Bahasa Dayak Ngaju masih bersifat bantuan awal.
                Mohon periksa dan sesuaikan kembali apabila terdapat kata atau kalimat yang kurang tepat sebelum memperbarui data.

            </p>

        </div>

    </div>

</div>

@endif
</div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Input Nama -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                                    <input
                                        type="text"
                                        name="translations[{{ $language->id }}][name]"
                                        value="{{ $valName }}"
                                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 translation-name"
                                        data-language="{{ $language->code }}"
                                    >
                                </div>
                                <!-- Input Slug (Menggunakan 'border' murni agar hitam tegas) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                                    <input
                                        type="text"
                                        name="translations[{{ $language->id }}][slug]"
                                        value="{{ $valSlug }}"
                                        class="w-full border rounded-xl px-4 py-3 bg-gray-50 text-gray-700 focus:outline-none"
                                        readonly
                                        data-slug="{{ $language->code }}"
                                    >
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Tombol Aksi Bawah -->
<div class="border-t p-6 bg-gray-50 rounded-b-2xl">

    <div class="text-right mb-3">

        <p
            id="form-warning-edit"
            class="text-sm text-red-600 font-medium">

            ⚠ Lengkapi seluruh data kategori sebelum memperbarui.

        </p>

    </div>


    <div class="flex justify-end items-center gap-3">

            <a href="{{ route('admin.categories.index') }}" class="px-5 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition font-medium">Batal</a>
            <button type="submit" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition font-medium shadow-md shadow-blue-100">Update </button>

    </div>

</div>
    </form>
</div>

@endsection

@push('scripts')
<script>
(() => {
    // 1. FITUR: Otomatis isi Slug saat mengetik Nama
    document.querySelectorAll('.translation-name').forEach(function (input) {
        input.addEventListener('input', function () {
            const lang = this.getAttribute('data-language'); 
            const slugInput = document.querySelector(`[data-slug="${lang}"]`);

            if (slugInput) {
                slugInput.value = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w-]/g, '');
            }
        });
    });

    // 2. FITUR: Tombol Terjemahan AI
    const btnTranslate = document.getElementById('btn-translate-ai');
    if (btnTranslate) {
        btnTranslate.addEventListener('click', async function () {
            console.log("Tombol diklik, memulai proses...");
            const indonesia = document.querySelector('[data-language="id"]');

            if (!indonesia || indonesia.value.trim() === '') {
                Swal.fire({ icon: 'warning', title: 'Isi Nama Bahasa Indonesia terlebih dahulu' });
                return;
            }

            btnTranslate.disabled = true;
            btnTranslate.innerHTML = `<i class="bi bi-arrow-repeat animate-spin"></i> Menerjemahkan...`;

            try {
                const response = await fetch("{{ route('admin.categories.translate') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ text: indonesia.value.trim() })
                });

                if (response.status === 429 || response.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kuota AI Terbatas',
                        text: 'Token/kuota AI telah habis atau terlalu cepat diklik. Sistem akan mereset otomatis dalam waktu 10-15 menit, mohon jangan klik tombol terjemahan dulu ya.',
                    });
                } else {
                    const result = await response.json();

                    if (result.success) {
                        for (const [langId, data] of Object.entries(result.translations)) {
                            const nameInput = document.querySelector(`input[name="translations[${langId}][name]"]`);
                            const slugInput = document.querySelector(`input[name="translations[${langId}][slug]"]`);

                            if (nameInput) nameInput.value = data.name || '';
                            if (slugInput) slugInput.value = data.slug || '';
                        }
                        Swal.fire({ icon: 'success', title: 'Terjemahan berhasil!', timer: 1500, showConfirmButton: false });
                    } else {
                        Swal.fire({ 
                            icon: 'error', 
                            title: 'Gagal Menerjemahkan', 
                            text: result.message || 'Token telah habis, akan di reset dalam waktu 10-15 menit jangan di klik terjemahan nya.' 
                        });
                    }
                }
            } catch (error) {
                console.error("Error:", error);
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Koneksi Terputus', 
                    text: 'Terjadi masalah komunikasi dengan server AI. Silakan coba beberapa saat lagi.' 
                });
            }

            btnTranslate.disabled = false;
            btnTranslate.innerHTML = `<span>✨</span> <span>Terjemahkan AI</span>`;
        });
    }

    // ========================================
// Validasi Form Edit
// ========================================

const updateButton = document.getElementById('btn-update');
const warning = document.getElementById('form-warning-edit');

function checkFormEdit() {

    let complete = true;

    document.querySelectorAll('.translation-name').forEach(input => {

        if (input.value.trim() === '') {
            complete = false;
        }

    });

    if (complete) {

        updateButton.disabled = false;

        updateButton.classList.remove(
            'bg-gray-400',
            'cursor-not-allowed'
        );

        updateButton.classList.add(
            'bg-yellow-500',
            'hover:bg-yellow-600'
        );

        warning.innerHTML =
            '✅ Semua data telah lengkap dan siap diperbarui.';

        warning.classList.remove('text-red-600');
        warning.classList.add('text-green-600');

    } else {

        updateButton.disabled = true;

        updateButton.classList.remove(
            'bg-yellow-500',
            'hover:bg-yellow-600'
        );

        updateButton.classList.add(
            'bg-gray-400',
            'cursor-not-allowed'
        );

        warning.innerHTML =
            '⚠ Lengkapi seluruh data kategori sebelum memperbarui.';

        warning.classList.remove('text-green-600');
        warning.classList.add('text-red-600');

    }

}

document
    .querySelectorAll('.translation-name')
    .forEach(input => {

        input.addEventListener('input', checkFormEdit);

    });

checkFormEdit();
})();
</script>
@endpush