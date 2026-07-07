@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')

<div class="bg-white rounded-2xl shadow-md">

    <!-- Judul Halaman -->
    <div class="border-b p-6">
        <h2 class="text-2xl font-bold">
            Edit Kategori
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Perbarui data kategori beserta seluruh terjemahannya.
        </p>
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

            <hr class="border-gray-200">

            <!-- ========================================================= -->
            <!-- BAGIAN 2: TERJEMAHAN MULTI-BAHASA -->
            <!-- ========================================================= -->
            <div class="space-y-6">
                <!-- Header Terjemahan & Tombol AI -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">🌐</span>
                        <h3 class="font-bold text-lg text-gray-800">
                            Terjemahan
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
                                <span class="uppercase">{{ $language->code }}</span> {{ $language->name }}
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
        <div class="border-t p-6 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
            <a
                href="{{ route('admin.categories.index') }}"
                class="px-6 py-3 border border-gray-300 bg-white text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition"
            >
                Batal
            </a>

            <button
                type="submit"
                onclick="this.form.submit(); this.disabled=true; this.innerText='Memproses...';"
                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-medium shadow-sm transition"
            >
                Update
            </button>
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
})();
</script>
@endpush