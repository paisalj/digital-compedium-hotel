@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="p-6 bg-slate-50 min-h-screen">
    
    <div class="max-w-5xl mx-auto">
        
        {{-- 📦 CARD BESAR UTAMA --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">

            {{-- Header Halaman --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 border-b border-slate-100 pb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Pengaturan Website</h1>
                    <p class="text-sm text-slate-500 mt-1">Lakukan pembaruan data dan konfigurasi sistem hotel secara mandiri</p>
                </div>
            </div>

            {{-- Form per Kategori --}}
            @foreach($settings->groupBy('group') as $group => $items)
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="settings-group-form">
                    @csrf
                    @method('PUT')
                    
                    <input type="hidden" name="setting_group" value="{{ $group }}">

                    {{-- 📦 KOTAK KELOMPOK ACCORDION --}}
                    <div class="rounded-xl border border-slate-200 overflow-hidden mb-5 last:mb-2 transition-all duration-200 shadow-sm">
                        
                        {{-- Header Kelompok (Button Toggle) --}}
                        <button type="button" 
                                onclick="toggleGroup('{{ $group }}')" 
                                class="w-full bg-slate-50/80 hover:bg-slate-100/50 border-b border-slate-200 px-6 py-4 flex items-center justify-between gap-3 text-left focus:outline-none transition-colors">
                            
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-md bg-white border border-slate-200 flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                    @if($group === 'hotel' || $group === 'general')
                                        <i class="bi bi-building"></i>
                                    @elseif($group === 'contact')
                                        <i class="bi bi-telephone-outbound"></i>
                                    @elseif($group === 'social')
                                        <i class="bi bi-share"></i>
                                    @elseif($group === 'website')
                                        <i class="bi bi-globe"></i>
                                    @else
                                        <i class="bi bi-sliders"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800 capitalize leading-tight">
                                        {{ str_replace('_', ' ', $group) }} Settings
                                    </h4>
                                    <p class="text-[11px] text-slate-400 mt-0.5">atur di sini</p>
                                </div>
                            </div>

                            <i id="arrow-{{ $group }}" class="bi bi-chevron-down text-slate-400 transition-transform duration-300"></i>
                        </button>

                        {{-- Daftar Inputan didalam Accordion --}}
                        <div id="group-{{ $group }}" class="divide-y divide-slate-100 bg-white transition-all hidden">
                            @foreach($items as $setting)
                                <div class="p-6 flex flex-col md:flex-row gap-6 hover:bg-slate-50/30 transition-colors">
                                    
                                    {{-- Sisi Kiri: Label, Deskripsi & Tombol Terjemahan AI --}}
                                    <div class="w-full md:w-1/3 shrink-0">
                                        <label class="text-sm font-semibold text-slate-700 block">
                                            {{ $setting->label }}
                                        </label>
                                        @if($setting->description)
                                            <span class="text-xs text-slate-400 mt-1.5 block leading-relaxed pr-4">
                                                {{ $setting->description }}
                                            </span>
                                        @endif

                                        {{-- Tombol Terjemahkan Otomatis khusus Tipe Teks --}}
                                        @if(in_array($setting->type, ['text', 'textarea', 'richtext', 'editor']))
                                            <button type="button" 
                                                    onclick="translateSetting('{{ $setting->id }}', '{{ $setting->type }}')"
                                                    class="mt-4 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-[11px] font-bold transition flex items-center gap-1.5 border border-blue-200">
                                                <i class="bi bi-translate"></i> Translate dengan AI
                                            </button>
                                        @endif
                                    </div>

                                    {{-- Sisi Kanan: Input Form --}}
                                    <div class="w-full md:w-2/3 max-w-2xl">
                                        
                                        {{-- 1. JIKA TIPE TEKS (Mendukung Multibahasa / Terjemahan) --}}
                                        @if(in_array($setting->type, ['text', 'textarea', 'richtext', 'editor']))
                                            
                                            {{-- Navigasi Tab Bahasa --}}
                                            <div class="flex border-b border-slate-200 mb-4" id="tabs-{{ $setting->id }}">
                                                @foreach($languages as $language)
                                                    <button type="button"
                                                            onclick="switchLangTab('{{ $setting->id }}', '{{ $language->id }}')"
                                                            id="tab-btn-{{ $setting->id }}-{{ $language->id }}"
                                                            class="lang-tab-btn-{{ $setting->id }} px-4 py-2 text-xs font-semibold border-b-2 transition-all duration-200 {{ $language->is_default ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-400 hover:text-slate-800' }}">
                                                        {{ $language->name }}
                                                        @if($language->is_default)
                                                            <span class="text-[9px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded ml-1 font-bold">Default</span>
                                                        @endif
                                                    </button>
                                                @endforeach
                                            </div>

                                            {{-- Isi Input Tab per Bahasa --}}
                                            @foreach($languages as $language)
                                                <div id="tab-content-{{ $setting->id }}-{{ $language->id }}" 
                                                     class="lang-tab-content-{{ $setting->id }} {{ $language->is_default ? '' : 'hidden' }}">
                                                     
                                                    @if($language->is_default)
                                                        {{-- Bahasa Utama (Simpan ke setting default) --}}
                                                        @if($setting->type === 'text')
                                                            <div class="relative rounded-lg shadow-sm">
                                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </div>
                                                                <input 
                                                                    type="text" 
                                                                    id="input-default-{{ $setting->id }}"
                                                                    name="settings[{{ $setting->id }}]" 
                                                                    value="{{ old('settings.'.$setting->id, $setting->value) }}" 
                                                                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition text-slate-800 text-sm"
                                                                >
                                                            </div>
                                                        @elseif($setting->type === 'textarea')
                                                            <textarea 
                                                                id="input-default-{{ $setting->id }}"
                                                                name="settings[{{ $setting->id }}]" 
                                                                rows="4" 
                                                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition text-slate-800 shadow-sm"
                                                            >{{ old('settings.'.$setting->id, $setting->value) }}</textarea>
                                                        @elseif($setting->type === 'richtext' || $setting->type === 'editor')
                                                            <textarea 
                                                                id="input-default-{{ $setting->id }}"
                                                                name="settings[{{ $setting->id }}]" 
                                                                class="editor-tinymce w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition text-slate-800 shadow-sm"
                                                            >{{ old('settings.'.$setting->id, $setting->value) }}</textarea>
                                                        @endif
                                                    @else
                                                        {{-- Bahasa Terjemahan (Simpan ke SettingTranslation) --}}
                                                        @php
                                                            $translation = $setting->translations->where('language_id', $language->id)->first();
                                                            $translationValue = $translation ? $translation->value : '';
                                                        @endphp

                                                        @if($setting->type === 'text')
                                                            <div class="relative rounded-lg shadow-sm">
                                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                                    <i class="bi bi-translate"></i>
                                                                </div>
                                                                <input 
                                                                    type="text" 
                                                                    id="input-trans-{{ $setting->id }}-{{ $language->id }}"
                                                                    name="translations[{{ $language->id }}][{{ $setting->id }}]" 
                                                                    value="{{ old('translations.'.$language->id.'.'.$setting->id, $translationValue) }}" 
                                                                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition text-slate-800 text-sm"
                                                                    placeholder="Terjemahan ke {{ $language->name }}..."
                                                                >
                                                            </div>
                                                        @elseif($setting->type === 'textarea')
                                                            <textarea 
                                                                id="input-trans-{{ $setting->id }}-{{ $language->id }}"
                                                                name="translations[{{ $language->id }}][{{ $setting->id }}]" 
                                                                rows="4" 
                                                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition text-slate-800 shadow-sm"
                                                                placeholder="Terjemahan ke {{ $language->name }}..."
                                                            >{{ old('translations.'.$language->id.'.'.$setting->id, $translationValue) }}</textarea>
                                                        @elseif($setting->type === 'richtext' || $setting->type === 'editor')
                                                            <textarea 
                                                                id="input-trans-{{ $setting->id }}-{{ $language->id }}"
                                                                name="translations[{{ $language->id }}][{{ $setting->id }}]" 
                                                                class="editor-tinymce w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition text-slate-800 shadow-sm"
                                                                placeholder="Terjemahan ke {{ $language->name }}..."
                                                            >{{ old('translations.'.$language->id.'.'.$setting->id, $translationValue) }}</textarea>
                                                        @endif
                                                    @endif

                                                </div>
                                            @endforeach

                                        {{-- 2. JIKA TIPE GAMBAR/IMAGE (Global - Tidak butuh tab bahasa) --}}
                                        @elseif($setting->type === 'image')
                                            <div class="flex items-center gap-4">
                                                <div class="w-20 h-20 border border-slate-200 rounded-lg flex items-center justify-center bg-slate-50 overflow-hidden shadow-inner shrink-0">
                                                    <img id="preview-{{ $setting->id }}" 
                                                         src="{{ $setting->value ? asset('storage/' . $setting->value) : asset('images/no-image.png') }}" 
                                                         class="w-full h-full object-cover"
                                                         onerror="this.src='https://placehold.co/100?text=No+Image'">
                                                </div>
                                                
                                                <div class="flex flex-col gap-2">
                                                    <input type="hidden" 
                                                           id="input-{{ $setting->id }}" 
                                                           name="settings[{{ $setting->id }}]" 
                                                           value="{{ old('settings.'.$setting->id, $setting->value) }}">
                                                           
                                                    <div class="flex gap-2">
                                                        <button type="button" 
                                                                onclick="openMediaForSetting('{{ $setting->id }}')" 
                                                                class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg shadow-sm border border-slate-200 transition active:scale-95 flex items-center w-max gap-2">
                                                            <i class="bi bi-images"></i> Pilih dari Media
                                                        </button>
                                                        <button type="button" 
                                                                onclick="resetSettingImage('{{ $setting->id }}')" 
                                                                class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg border border-red-200 transition">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        {{-- 3. JIKA TIPE TELEPON --}}
                                        @elseif($setting->type === 'phone')
                                            <div class="flex items-center w-full bg-white border border-slate-200 rounded-lg focus-within:ring-4 focus-within:ring-blue-500/10 focus-within:border-blue-500 transition overflow-hidden shadow-sm">
                                                <div class="flex items-center gap-2 bg-slate-50 px-3 py-2.5 border-r border-slate-200 text-slate-400 select-none shrink-0">
                                                    @if(str_contains($setting->key, 'whatsapp'))
                                                        <i class="bi bi-whatsapp text-emerald-500 text-base"></i>
                                                    @else
                                                        <i class="bi bi-telephone text-slate-400 text-sm"></i>
                                                    @endif
                                                    <span class="text-xs font-bold text-slate-600 border-l pl-2 border-slate-200">+62</span>
                                                </div>
                                                <input 
                                                    type="text" 
                                                    name="settings[{{ $setting->id }}]" 
                                                    value="{{ old('settings.'.$setting->id, $setting->value) }}" 
                                                    placeholder="8123456789"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                    class="w-full px-3 py-2.5 bg-transparent focus:outline-none text-slate-800 text-sm"
                                                >
                                            </div>
                                            <small class="text-[11px] text-slate-400 mt-1 block">Tanpa angka 0 di depan. Contoh: 812345678</small>

                                        {{-- 4. TIPE STANDAR LAINNYA --}}
                                        @else
                                            <div class="relative rounded-lg shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    @if($setting->type === 'email')
                                                        <i class="bi bi-envelope"></i>
                                                    @elseif($setting->type === 'url')
                                                        <i class="bi bi-link-45deg"></i>
                                                    @else
                                                        <i class="bi bi-pencil-square"></i>
                                                    @endif
                                                </div>
                                                <input 
                                                    type="{{ $setting->type }}" 
                                                    name="settings[{{ $setting->id }}]" 
                                                    value="{{ old('settings.'.$setting->id, $setting->value) }}" 
                                                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition text-slate-800 text-sm"
                                                >
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            {{-- Tombol aksi simpan per kategori --}}
                            <div class="p-5 bg-slate-50 flex justify-end gap-3 border-t border-slate-100">
                                <button type="button" 
                                        onclick="toggleGroup('{{ $group }}')"
                                        class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-semibold text-xs rounded-lg transition active:scale-95">
                                    Tutup Kategori
                                </button>
                                <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg shadow-sm transition active:scale-95 flex items-center gap-1.5">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Simpan Pengaturan {{ ucwords(str_replace('_', ' ', $group)) }}
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            @endforeach

        </div>
        
    </div>
</div>

<!-- Modal Media Library -->
<div id="mediaModal" class="hidden fixed inset-0 z-[99999] flex items-center justify-center bg-black bg-opacity-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[85vh] flex flex-col shadow-2xl overflow-hidden">
        
        <div class="p-5 border-b flex justify-between items-center bg-gray-50">
            <h3 class="text-xl font-bold text-gray-800">Media Library</h3>
            <button type="button" onclick="closeMediaModal()" class="text-gray-400 hover:text-red-500 text-2xl transition">&times;</button>
        </div>

        <div class="p-4 border-b bg-white">
            <input type="text" id="mediaSearch" placeholder="Cari nama gambar..." 
                   onkeyup="filterMedia()" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition">
        </div>

        <div id="mediaGrid" class="p-5 overflow-y-auto flex-1 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 bg-slate-50">
            @foreach($media as $item)
                {{-- Diperbarui: selectImage membawa parameter URL & relative path database --}}
                <div class="media-item group cursor-pointer border-2 border-transparent rounded-xl p-2 hover:border-slate-300 transition-all bg-white hover:shadow-md flex flex-col justify-between" 
                     data-name="{{ strtolower($item->alt_text) }}"
                     onclick="selectImage('{{ asset('storage/'.$item->file_path) }}', '{{ $item->file_path }}', this)">
                    
                    <div class="w-full h-28 overflow-hidden rounded-lg bg-slate-100 flex items-center justify-center">
                        <img src="{{ asset('storage/'.$item->file_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    
                    <p class="text-[11px] text-gray-700 mt-2 truncate text-center font-medium bg-gray-50 py-1 px-1 rounded-md">
                        {{ $item->alt_text }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="p-4 border-t flex justify-between items-center bg-gray-50">
            <div class="text-xs text-gray-500 font-medium">Menampilkan {{ $media->count() }} media</div>
            <div class="flex gap-2">
                <button type="button" onclick="closeMediaModal()" class="px-4 py-2 border bg-white rounded-lg text-sm text-gray-700 hover:bg-gray-100 transition">Cancel</button>
                <button type="button" onclick="confirmSelection()" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 shadow-sm transition">Simpan Pilihan</button>
            </div>
        </div>
        
    </div>
</div>
@endsection

{{-- ⚡ JAVASCRIPT LOGIC --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('scripts')
{{-- Import TinyMCE Script --}}
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
let tinymceCallback = null;
let currentSettingKey = null; 
let selectedImageUrl = null;

// 1. Inisialisasi TinyMCE untuk text editor multibahasa
document.addEventListener("DOMContentLoaded", function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: 'textarea.editor-tinymce',
            height: 280,
            menubar: false,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace wordcount insertdatetime media table code help',
            toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image link | code',
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'image') {
                    openMediaModal(callback);
                }
            }
        });
    }
});

// 2. Fungsi Mengganti Tab Bahasa per Item Setting
function switchLangTab(settingId, langId) {
    // Sembunyikan semua konten tab di setting ini
    document.querySelectorAll('.lang-tab-content-' + settingId).forEach(el => {
        el.classList.add('hidden');
    });
    // Setel ulang gaya semua tombol tab di setting ini
    document.querySelectorAll('.lang-tab-btn-' + settingId).forEach(btn => {
        btn.classList.remove('border-blue-600', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-slate-400');
    });
    
    // Tampilkan konten tab yang dipilih
    document.getElementById('tab-content-' + settingId + '-' + langId).classList.remove('hidden');
    // Beri gaya aktif pada tombol tab yang dipilih
    const activeBtn = document.getElementById('tab-btn-' + settingId + '-' + langId);
    if (activeBtn) {
        activeBtn.classList.remove('border-transparent', 'text-slate-400');
        activeBtn.classList.add('border-blue-600', 'text-blue-600');
    }
}

// 3. Fungsi Penerjemahan dengan AI (Langsung Terkoneksi ke Backend Translate)
function translateSetting(settingId, type) {
    let sourceText = '';
    
    // Ambil isi dari default input sesuai tipenya
    if (type === 'richtext' || type === 'editor') {
        const editor = tinymce.get('input-default-' + settingId);
        if (editor) {
            sourceText = editor.getContent();
        } else {
            sourceText = document.getElementById('input-default-' + settingId).value;
        }
    } else {
        sourceText = document.getElementById('input-default-' + settingId).value;
    }
    
    if (!sourceText.replace(/<[^>]*>/g, '').trim()) {
        Swal.fire({
            icon: 'warning',
            title: 'Teks Utama Kosong',
            text: 'Silakan isi kolom bahasa utama terlebih dahulu sebelum menerjemahkan!'
        });
        return;
    }
    
    Swal.fire({
        title: 'Menerjemahkan...',
        text: 'Sedang menerjemahkan ke bahasa lain menggunakan AI, mohon tunggu.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Request AJAX ke Controller settings.translate
    fetch("{{ route('admin.settings.translate') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            setting_id: settingId, // Ditambahkan agar controller tahu ID setting yang diterjemahkan
            text: sourceText
        })
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        if (data.success) {
            // Isi otomatis semua input terjemahan (selain default)
            for (const [langId, translation] of Object.entries(data.translations)) {
                const targetInputId = 'input-trans-' + settingId + '-' + langId;
                
                // Amankan pembacaan nilai jika backend mengembalikan object atau langsung string biasa
                const value = (translation && typeof translation === 'object') ? translation.value : translation;
                
                if (type === 'richtext' || type === 'editor') {
                    const targetEditor = tinymce.get(targetInputId);
                    if (targetEditor) {
                        targetEditor.setContent(value);
                    } else {
                        const el = document.getElementById(targetInputId);
                        if (el) el.value = value;
                    }
                } else {
                    const el = document.getElementById(targetInputId);
                    if (el) el.value = value;
                }
            }
            
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Terjemah!',
                text: 'Terjemahan berhasil dibuat otomatis oleh AI!',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Terjemah',
                text: data.message || 'Terjadi kesalahan saat menerjemahkan.'
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error(error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan sistem saat menghubungi server.'
        });
    });
}

function toggleGroup(groupKey) {
    const content = document.getElementById('group-' + groupKey);
    const arrow = document.getElementById('arrow-' + groupKey);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}

function openMediaModal(callback) {
    tinymceCallback = callback;
    currentSettingKey = null; 
    document.getElementById('mediaModal').classList.remove('hidden');
}

function openMediaForSetting(key) {
    currentSettingKey = key;
    tinymceCallback = null; 
    document.getElementById('mediaModal').classList.remove('hidden');
}

function closeMediaModal() {
    document.getElementById('mediaModal').classList.add('hidden');
    document.querySelectorAll('.media-item').forEach(el => {
        el.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
    });
}

// Dioptimalkan: Mendukung input 2 parameter selectImage(url, element) 
// atau 3 parameter dari blade selectImage(url, path, element) secara aman
function selectImage(url, relativePathOrElement, element = null) {
    selectedImageUrl = url;
    
    // Hapus highlight dari semua item media
    document.querySelectorAll('.media-item').forEach(el => {
        el.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
    });
    
    // Cari elemen HTML yang sesungguhnya diklik
    let activeElement = null;
    if (element) {
        activeElement = element; // jika dipanggil 3 parameter
    } else if (relativePathOrElement && typeof relativePathOrElement === 'object') {
        activeElement = relativePathOrElement; // jika dipanggil 2 parameter
    }

    if (activeElement) {
        activeElement.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
    }
}

function confirmSelection() {
    if (!selectedImageUrl) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Gambar',
            text: 'Silakan klik salah satu gambar terlebih dahulu!'
        });
        return;
    }

    if (tinymceCallback) {
        tinymceCallback(selectedImageUrl, { alt: 'Gambar konten' });
        tinymceCallback = null;
        selectedImageUrl = null;
        closeMediaModal();
    } 
    else if (currentSettingKey) {
        let storageIndex = selectedImageUrl.indexOf('/storage/');
        let relativePath = selectedImageUrl;
        
        if (storageIndex !== -1) {
            relativePath = selectedImageUrl.substring(storageIndex + 9); 
        }

        const targetInput = document.getElementById('input-' + currentSettingKey);
        if (targetInput) {
            targetInput.value = relativePath;
        }

        const targetPreview = document.getElementById('preview-' + currentSettingKey);
        if (targetPreview) {
            targetPreview.src = selectedImageUrl;
        }
        
        currentSettingKey = null;
        selectedImageUrl = null;
        closeMediaModal();
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

function resetSettingImage(key) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Pilihan gambar pada kolom ini akan dikosongkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('input-' + key).value = '';
            document.getElementById('preview-' + key).src = 'https://placehold.co/100?text=No+Image';
            
            Swal.fire({
                icon: 'success',
                title: 'Direset!',
                text: 'Gambar berhasil dikosongkan.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

// Integrasi Validasi Submit Form dengan Sinkronisasi TinyMCE
document.querySelectorAll('.settings-group-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Amankan data editor agar tersinkronisasi ke textarea aslinya
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Pastikan semua data terjemahan Anda sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669', 
            cancelButtonColor: '#64748b',  
            confirmButtonText: '<i class="bi bi-check-circle-fill"></i> Ya, Simpan!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                const btn = form.querySelector('button[type="submit"]');
                if(btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1.5"></i> Menyimpan...';
                }
                form.submit();
            }
        });
    });
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000, 
        timerProgressBar: true 
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        showConfirmButton: true,
        confirmButtonColor: '#ef4444'
    });
</script>
@endif
@endpush