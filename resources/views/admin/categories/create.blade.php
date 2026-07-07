@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')

@section('page-title', 'Tambah Kategori')

@section('content')

<div class="bg-white rounded-2xl shadow-md">

    <div class="border-b p-6">
        <h2 class="text-2xl font-bold">
            Tambah Kategori
        </h2>
        <p class="text-gray-500 mt-1">
            Tambahkan kategori beserta seluruh terjemahannya.
        </p>
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
                            type="text"
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
                    <h3 class="text-xl font-bold">🌐 Terjemahan</h3>
                    <button
                        type="button"
                        id="translate-ai"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl flex items-center gap-2">
                        <i class="bi bi-stars"></i> Terjemahkan AI
                    </button>
                </div>

                @foreach($languages as $language)
                    <div class="border rounded-xl p-6 mb-6 bg-gray-50">
                        <h4 class="text-lg font-bold mb-5">
                            {{ $language->flag }} {{ $language->native_name }}
                        </h4>

                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block mb-2">Nama</label>
                                <input
                                    type="text"
                                    name="translations[{{ $language->id }}][name]"
                                    data-language="{{ $language->code }}"
                                    class="w-full border rounded-xl px-4 py-3">
                            </div>

                            <div>
                                <label class="block mb-2">Slug</label>
                                <input
                                    type="text"
                                    name="translations[{{ $language->id }}][slug]"
                                    data-slug="{{ $language->code }}"
                                    class="w-full border rounded-xl px-4 py-3">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="border-t p-6 flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}" class="px-5 py-3 border rounded-xl">Batal</a>
            <button type="submit" class="px-5 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl">Simpan</button>
        </div>
    </form>

</div>

@endsection

@push('scripts')
<script>
(() => {
    // =======================================================================
    // 1. FITUR: Otomatis isi Slug Indonesia saat mengetik Nama Indonesia
    // =======================================================================
    const indoName = document.querySelector('[data-language="id"]');
    const indoSlug = document.querySelector('[data-slug="id"]');

    if (indoName && indoSlug) {
        indoName.addEventListener('input', function() {
            indoSlug.value = this.value
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w-]/g, '');
        });
    }

    // =======================================================================
    // 2. FITUR: Tombol Terjemahan AI (Satu Kali Tembak Untuk Semua Bahasa)
    // =======================================================================
    const btnTranslate = document.getElementById('translate-ai');

    if (!btnTranslate) return;

    btnTranslate.addEventListener('click', async function () {
        const indonesia = document.querySelector('[data-language="id"]');

        if (!indonesia || indonesia.value.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Isi Nama Bahasa Indonesia terlebih dahulu'
            });
            return;
        }

        btnTranslate.disabled = true;
        btnTranslate.innerHTML = `
            <i class="bi bi-arrow-repeat animate-spin"></i> Menerjemahkan...
        `;

        const sourceText = indonesia.value.trim();

        try {
            // Cukup panggil fetch 1 kali karena server memproses semua bahasa sekaligus
            const response = await fetch("{{ route('admin.categories.translate') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    text: sourceText,
                    from: "id"
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

            // Membaca object 'translations' dari server dan menyebarkan datanya sesuai ID input
            if (result.translations) {
                Object.keys(result.translations).forEach(langId => {
                    // Mencari elemen berdasarkan atribut name input HTML Laravel Anda
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

})();
</script>
@endpush