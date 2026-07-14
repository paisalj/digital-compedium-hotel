@extends('admin.layouts.app')

@section('title', 'Edit Konten')

@section('page-title', 'Edit Konten')

@section('content')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>

<style>
    /* 1. INI KUNCI UNTUK MEMBUAT DROPDOWN PENDEK (4-5 BARIS) & BISA DI-SCROLL */
    .choices__list--dropdown .choices__list,
    .choices__list[aria-expanded] {
        max-height: 200px !important; /* Batas tinggi maksimal sekitar 4-5 baris */
        overflow-y: auto !important;  /* Memunculkan scroll bar di samping kanan */
        scrollbar-width: thin;
    }

    /* 2. MEMASTIKAN KOTAK DROPDOWN RAPI & TIDAK KETUTUP CARD LAIN */
    .choices__list--dropdown {
        z-index: 9999 !important;
        background-color: white !important;
        border: 1px solid #9ca3af !important; /* Border gray-400 agar lebih tegas */
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }

    /* 3. MENGEMBARKAN GAYA DROPDOWN CHOICES DENGAN INPUT TAILWIND (BORDER LEBIH BOLD & PUTIH BERSIH) */
    .choices__inner {
        min-height: 48px !important;
        padding: 8px 16px !important;
        background-color: #ffffff !important; /* Paksa background putih bersih */
        border: 1px solid #9ca3af !important; /* Warna border Gray-400 (lebih bold & jelas) */
        border-radius: 0.75rem !important;    /* Sama dengan rounded-xl */
        display: flex !important;
        align-items: center !important;
        font-size: 1rem !important;
        color: #374151 !important;            /* Warna teks text-gray-700 */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important; /* shadow-sm */
    }

    /* 4. EFEK FOKUS (RING BIRU) SAAT KOTAK KATEGORI DIKLIK - BIAR SAMA KAYA INPUTAN TAILWIND */
    .choices.is-focused .choices__inner {
        border-color: #3b82f6 !important; /* Blue-500 */
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important; /* Efek ring-2 ring-blue-500 */
    }

    .choices {
        margin-bottom: 0 !important;
        width: 100% !important;
    }

    .choices__input {
        background-color: transparent !important;
        margin-bottom: 0 !important;
        color: #374151 !important;
    }
</style>
@endpush

<div class="bg-white rounded-2xl shadow-md">

<div class="border-b p-6 flex justify-between items-center">
    {{-- Sisi Kiri: Judul dan Deskripsi Tetap Menyatu Kebawah --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Edit Konten
        </h2>
        <p class="text-gray-500 mt-1">
            Ubah konten beserta seluruh terjemahannya.
        </p>
    </div>

        <a href="{{ route('admin.contents.index') }}" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
</div>
    {{-- PERBAIKAN: Mengubah rute form ke rute update menggunakan ID dari variabel $content --}}
    <form action="{{ route('admin.contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- WAJIB: Ditambahkan agar Laravel mengenali pengiriman form ini sebagai metode spoofing PUT --}}

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

{{-- DATA UTAMA KONTEN --}}
<div>
    <h3 class="text-xl font-bold mb-5">📂 Data Utama Konten</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-start">
        
        {{-- Pilihan Kategori (Sudah Sempurna) --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">Kategori Konten</label>
            <div class="flex items-center gap-3">
                <div class="w-full">
                    <select name="category_id" id="category-select" class="w-full border rounded-xl px-4 py-3 text-gray-700 bg-white shadow-sm" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            @php
                                $catName = $category->translations->where('language.code', app()->getLocale())->first()->name ?? $category->translations->first()->name;
                            @endphp
                            <option value="{{ $category->id }}" data-icon="{{ $category->icon }}" {{ $content->category_id == $category->id ? 'selected' : '' }}>
                                {{ $catName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Container Ikon Emas Kategori --}}
                <div id="icon-preview" class="hidden text-3xl text-yellow-500 min-w-[50px] flex justify-center items-center">
                    <i id="icon-display" class="bi"></i>
                </div>
            </div>
        </div>

        {{-- Input Ikon Konten --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">Ikon Konten</label>
            <div class="flex items-center gap-3">
                <div class="w-full">
                    <input
                        type="text"
                        name="icon"
                        id="content-icon-input" 
                        value="{{ old('icon', $content->icon) }}"
                        class="w-full border border-gray-400 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition shadow-sm"
                        placeholder="Contoh: bi-wifi">
                </div>
                
                {{-- Wadah untuk memunculkan ikon emas lama dari database secara otomatis --}}
                <div id="content-icon-preview" class="hidden text-3xl text-yellow-500 min-w-[50px] flex justify-center items-center">
                    <i id="content-icon-display" class="bi"></i>
                </div>
            </div>
        </div>

        {{-- Status Konten --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">Status Konten</label>
            <select name="is_active" class="w-full border border-gray-400 rounded-xl px-4 py-3 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition shadow-sm">
                <option value="1" @selected($content->is_active == 1)>Aktif</option>
                <option value="0" @selected($content->is_active == 0)>Tidak Aktif</option>
            </select>
        </div>

    </div>
</div>
            {{-- TRANSLATION SECTIONS --}}
            <hr class="border-gray-100">

            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">🌐 Terjemahan Konten</h3>

                    <button
                        type="button"
                        id="translate-ai"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl flex items-center gap-2 transition font-medium shadow-sm">
                        <i class="bi bi-stars"></i> Terjemahkan AI
                    </button>

                </div>
                    <small class="text-gray-400 mt-1 block">Apa bila token habis bisa edit manual.</small>

                @foreach($languages as $language)
                    @php
                        // PERBAIKAN: Mengambil data terjemahan lama yang spesifik sesuai dengan ID bahasa perulangan
                        $transData = $content->translations->where('language_id', $language->id)->first();
                    @endphp
                    <div class="border rounded-xl p-6 mb-6 bg-gray-50">
                        <h4 class="text-lg font-bold mb-5 flex items-center gap-2">
                            <span>{{ $language->flag ?? '🌐' }}</span> 
                            <span>{{ $language->native_name }} ({{ strtoupper($language->code) }})</span>
                        </h4>

                        <div class="grid md:grid-cols-2 gap-5 mb-4">
                            <div>
                                <label class="block mb-2 font-medium">Judul</label>
                                <input
                                    type="text"
                                    name="translations[{{ $language->id }}][title]"
                                    data-language="{{ $language->code }}"
                                    {{-- PERBAIKAN: Memasukkan nilai judul lama ke inputan --}}
                                    value="{{ old('translations.'.$language->id.'.title', $transData->title ?? '') }}"
                                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white shadow-sm"
                                    placeholder="Masukkan judul konten..."
                                    required>
                            </div>

                            <div>
                                <label class="block mb-2 font-medium">Slug (Otomatis)</label>
                                <input
                                    type="text"
                                    name="translations[{{ $language->id }}][slug]"
                                    data-slug="{{ $language->code }}"
                                    {{-- PERBAIKAN: Memasukkan nilai slug lama ke inputan --}}
                                    value="{{ old('translations.'.$language->id.'.slug', $transData->slug ?? '') }}"
                                    class="w-full border rounded-xl px-4 py-3 bg-gray-200 text-gray-500 cursor-not-allowed shadow-sm"
                                    placeholder="slug-otomatis-terisi"
                                    readonly>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="block mb-2 font-medium">Deskripsi</label>
                            <div class="editor-container bg-white rounded-xl overflow-hidden border shadow-sm">
                                <textarea 
                                    class="tinymce-editor" 
                                    id="body_{{ $language->id }}"
                                    name="translations[{{ $language->id }}][body]" 
                                    rows="10">{{ old('translations.'.$language->id.'.body', $transData->body ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="border-t p-6 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
            <a href="{{ route('admin.contents.index') }}" class="px-5 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition font-medium">Batal</a>
            <button type="submit" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition font-medium shadow-md shadow-blue-100">Update Konten</button>
        </div>
    </form>

</div>


<!-- Modal Media Library -->
<div id="mediaModal" class="hidden fixed inset-0 z-[99999] flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[85vh] flex flex-col shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="p-5 border-b flex justify-between items-center bg-gray-50">
            <h3 class="text-xl font-bold text-gray-800">Media Library</h3>
            <button type="button" onclick="closeMediaModal()" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        </div>

<!-- Search Bar saja (tanpa tombol upload) -->
<div class="p-4 border-b">
    <input type="text" id="mediaSearch" placeholder="Cari nama gambar..." 
           onkeyup="filterMedia()" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
</div>

<!-- Grid Gambar dengan Nama File -->
<div id="mediaGrid" class="p-5 overflow-y-auto flex-1 grid grid-cols-4 gap-4">
<!-- UBAH BAGIAN INI DI CREATE.BLADE.PHP -->
@foreach($media as $item)
    <div class="media-item group cursor-pointer border rounded-lg p-2 hover:border-blue-500 transition-all bg-white hover:shadow-md" 
         data-name="{{ strtolower($item->alt_text) }}"
         onclick="selectImage('{{ asset('storage/'.$item->file_path) }}', this)"> <!-- Tambahkan parameter 'this' -->
        
        <div class="w-full h-24 overflow-hidden rounded">
            <img src="{{ asset('storage/'.$item->file_path) }}" class="w-full h-full object-cover">
        </div>
        
        <p class="text-[11px] text-gray-700 mt-2 truncate text-center font-medium bg-gray-50 py-1 rounded">
            {{ $item->alt_text }}
        </p>
    </div>
@endforeach
        </div>

        <!-- Footer (Pagination & Action) -->
        <div class="p-4 border-t flex justify-between items-center bg-gray-50">
            <div class="text-xs text-gray-500">Menampilkan {{ $media->count() }} media</div>
            <div class="flex gap-2">
                <button type="button" onclick="closeMediaModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Cancel</button>
                <button type="button" onclick="confirmSelection()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Pilihan</button>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')
{{-- MEMUAT LIBRARY JAVASCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ===================================================================
// VARIABLE & FUNGSI GLOBAL MEDIA LIBRARY (Scope Luar)
// ===================================================================
let tinymceCallback = null;
let selectedImageUrl = null;

function openMediaModal(callback) {
    tinymceCallback = callback;
    // Buka modal library kita di atas modal TinyMCE
    document.getElementById('mediaModal').classList.remove('hidden');
}

function closeMediaModal() {
    // Sembunyikan modal library saja
    document.getElementById('mediaModal').classList.add('hidden');
}

function selectImage(url, element) {
    selectedImageUrl = url;
    // Beri efek border biru pada gambar yang dipilih
    document.querySelectorAll('.media-item').forEach(el => {
        el.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
    });
    if (element) {
        element.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
    }
}

function confirmSelection() {
    if (selectedImageUrl && tinymceCallback) {
        // Kirim URL gambar ke kolom "Source" modal TinyMCE
        tinymceCallback(selectedImageUrl, { alt: 'Gambar konten' });
        
        // Reset & Tutup modal library
        tinymceCallback = null;
        selectedImageUrl = null;
        closeMediaModal();
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Gambar',
            text: 'Silakan klik salah satu gambar terlebih dahulu!'
        });
    }
}

function filterMedia() {
    let filter = document.getElementById('mediaSearch').value.toLowerCase();
    let items = document.getElementsByClassName('media-item');
    for (let i = 0; i < items.length; i++) {
        let name = items[i].getAttribute('data-name');
        items[i].style.display = name.includes(filter) ? "" : "none";
    }
}

// ===================================================================
// INISIALISASI SAAT DOM READY (Scope Dalam)
// ===================================================================
document.addEventListener('DOMContentLoaded', function() {
    // === 1. VARIABEL UNTUK KATEGORI (BAWAAN) ===
    const categorySelect = document.getElementById('category-select');
    const iconPreview = document.getElementById('icon-preview');
    const iconDisplay = document.getElementById('icon-display');

    // === 2. VARIABEL BARU UNTUK IKON KONTEN (TAMBAHAN) ===
    const contentIconInput = document.getElementById('content-icon-input');
    const contentIconPreview = document.getElementById('content-icon-preview');
    const contentIconDisplay = document.getElementById('content-icon-display');

    // === 3. FUNGSI PREVIEW IKON KATEGORI (BAWAAN) ===
    function updateIconPreview() {
        if (!categorySelect) return;
        const selectedValue = categorySelect.value;
        const selectedOption = categorySelect.querySelector(`option[value="${selectedValue}"]`);
        const iconClass = selectedOption ? selectedOption.getAttribute('data-icon') : null;

        if (iconClass && iconPreview && iconDisplay) {
            iconPreview.classList.remove('hidden');
            iconDisplay.className = 'bi ' + iconClass; 
        } else if (iconPreview) {
            iconPreview.classList.add('hidden');
        }
    }

    // === 4. FUNGSI BARU PREVIEW IKON KONTEN (TAMBAHAN) ===
    function updateContentIconPreview() {
        if (!contentIconInput) return;
        const iconValue = contentIconInput.value.trim();

        if (iconValue) {
            contentIconPreview.classList.remove('hidden');
            contentIconDisplay.className = 'bi ' + iconValue.replace('bi ', ''); 
        } else {
            contentIconPreview.classList.add('hidden');
        }
    }

    if (categorySelect) {
        const choicesInstance = new Choices(categorySelect, {
            searchEnabled: true,
            searchPlaceholderValue: 'Cari kategori...',
            itemSelectText: '',
            shouldSort: false,
        });

        categorySelect.addEventListener('change', updateIconPreview);
        // Jalankan otomatis saat edit di-load agar data lama terdeteksi
        updateIconPreview();
    }

    // Dengarkan perubahan input pada ikon konten jika element ada
    if (contentIconInput) {
        contentIconInput.addEventListener('input', updateContentIconPreview);
        updateContentIconPreview(); // Jalankan otomatis saat data lama termuat
    }

    // Perbaikan selektor form agar memaksa penyimpanan TinyMCE saat update data
    const form = document.querySelector('form[action="{{ route("admin.contents.update", $content->id) }}"]');
    if (form) {
        form.addEventListener('submit', function() {
            tinymce.triggerSave();
        });
    }

    // Inisialisasi TinyMCE Editor (Sudah Diperbaiki)
    tinymce.init({
        selector: '.tinymce-editor',
        height: 350,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic forecolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'table image media | removeformat | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 16px; color: #374151; }',
        automatic_uploads: true,
        file_picker_types: 'image',
        // SINKRONISASI MODAL MEDIA LIBRARY
        file_picker_callback: (cb, value, meta) => {
            if (meta.filetype === 'image') {
                openMediaModal(cb); 
            }
        }
    });

    // Otomatis isi Slug Indonesia saat mengetik Judul Indonesia
    const indoTitle = document.querySelector('[data-language="id"]');
    const indoSlug = document.querySelector('[data-slug="id"]');

    if (indoTitle && indoSlug) {
        indoTitle.addEventListener('input', function() {
            indoSlug.value = this.value
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w-]/g, '');
        });
    }

    // Fitur Terjemahan AI otomatis untuk Judul & Deskripsi (TinyMCE)
    const btnTranslate = document.getElementById('translate-ai');
    if (btnTranslate) {
        btnTranslate.addEventListener('click', async function () {
            const indoTitleInput = document.querySelector('[data-language="id"]');
            
            let indoLangId = '1';
            if (indoTitleInput) {
                const nameAttr = indoTitleInput.getAttribute('name');
                const match = nameAttr.match(/translations\[(\d+)\]/);
                if (match) indoLangId = match[1];
            }
            
            let indoBodyContent = '';
            const activeIndoEditor = tinymce.get('body_' + indoLangId);
            if (activeIndoEditor) {
                indoBodyContent = activeIndoEditor.getContent();
            }

            if (!indoTitleInput || indoTitleInput.value.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Isi Judul Konten Bahasa Indonesia terlebih dahulu'
                });
                return;
            }

            btnTranslate.disabled = true;
            btnTranslate.innerHTML = `<i class="bi bi-arrow-repeat animate-spin"></i> Menerjemahkan...`;

            const sourceTitle = indoTitleInput.value.trim();

            try {
                const response = await fetch("{{ route('admin.contents.translate') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ 
                        title: sourceTitle, 
                        body: indoBodyContent, 
                        from: "id" 
                    })
                });

                if (response.status === 429 || response.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kuota AI Terbatas',
                        text: 'Token AI habis atau server sibuk. Silakan coba beberapa saat lagi.',
                    });
                    restoreButton();
                    return; 
                }

                if (!response.ok) throw new Error("HTTP Error : " + response.status);
                const result = await response.json();

                if (!result.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menerjemahkan',
                        text: 'Token ditolak oleh server AI.',
                    });
                    restoreButton();
                    return; 
                }

                if (result.translations) {
                    Object.keys(result.translations).forEach(langId => {
                        const titleInput = document.querySelector(`[name="translations[${langId}][title]"]`);
                        const slugInput = document.querySelector(`[name="translations[${langId}][slug]"]`);

                        if (titleInput) {
                            const translatedTitle = result.translations[langId].title || result.translations[langId].name;
                            if (translatedTitle) {
                                titleInput.value = translatedTitle; 
                                if (slugInput) {
                                    slugInput.value = translatedTitle
                                        .toLowerCase()
                                        .trim()
                                        .replace(/\s+/g, '-')
                                        .replace(/[^\w-]/g, '');
                                }
                            }
                        }

                        const translatedBody = result.translations[langId].body || '';
                        const editorInstance = tinymce.get('body_' + langId);
                        
                        if (editorInstance) {
                            editorInstance.setContent(translatedBody);
                        } else {
                            const bodyTextarea = document.getElementById('body_' + langId);
                            if (bodyTextarea) bodyTextarea.value = translatedBody;
                        }
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Diterjemahkan!',
                        text: 'Judul dan seluruh isi tabel/deskripsi telah diterjemahkan otomatis oleh AI.',
                        timer: 2500,
                        showConfirmButton: true
                    });
                }

            } catch (error) {
                console.error("Fetch Error :", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi Terputus',
                    text: 'Terjadi masalah komunikasi dengan server AI.',
                });
            }

            restoreButton();
        });

        function restoreButton() {
            btnTranslate.disabled = false;
            btnTranslate.innerHTML = `<i class="bi bi-stars"></i> Terjemahkan AI`;
        }
    }
});
</script>
@endpush