@extends('layouts.admin') {{-- Sesuaikan dengan nama layout admin Anda --}}

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Tambah Konten Portofolio</h2>
        <a href="{{ route('admin.contents.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <form action="{{ route('admin.contents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Baris Atas: Kategori & Thumbnail -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Kategori Konten</label>
                    <select name="category_id" class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            {{-- Menampilkan nama kategori berdasarkan bahasa default aplikasi --}}
                            <option value="{{ $category->id }}">
                                {{ $category->translations->where('language.code', app()->getLocale())->first()->name ?? $category->translations->first()->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Foto / Thumbnail Utama</label>
                    <input type="file" name="thumbnail" class="w-full border rounded-lg px-3 py-1.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            <!-- Loop Penginputan Multi-Bahasa -->
            @foreach($languages as $lang)
                <div class="mb-8 p-5 bg-gray-50 rounded-xl border border-gray-200">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="uppercase text-xs font-bold px-2 py-1 bg-blue-600 text-white rounded shadow-sm">
                            {{ $lang->code }}
                        </span>
                        <h3 class="font-bold text-gray-800">Form Konten Bahasa: {{ $lang->name }}</h3>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Judul Konten ({{ $lang->code }})</label>
                        <input type="text" name="translations[{{ $lang->id }}][title]" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan judul..." required>
                    </div>

                    <div class="mb-2">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Isi / Deskripsi Konten ({{ $lang->code }})</label>
                        {{-- ID khusus ditambahkan di textarea untuk target inisialisasi text editor --}}
                        <textarea id="editor-{{ $lang->code }}" name="translations[{{ $lang->id }}][body]" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 rows="6"></textarea>
                    </div>
                </div>
            @endforeach

            <!-- Tombol Simpan -->
            <div class="flex justify-end gap-3 mt-6">
                <button type="reset" class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100 transition font-medium">Reset</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium shadow-md shadow-blue-200">Simpan Konten</button>
            </div>
        </form>
    </div>
</div>

<!-- 🌐 INTEGRASI RICH TEXT EDITOR (CKEDITOR 5) -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.0.0/build/ckeditor.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Otomatis pasang text editor ke seluruh bahasa yang di-loop di atas
        @foreach($languages as $lang)
            ClassicEditor
                .create(document.querySelector('#editor-{{ $lang->code }}'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
                })
                .catch(error => {
                    console.error('Gagal memuat editor untuk bahasa {{ $lang->code }}:', error);
                });
        @endforeach
    });
</script>
@endsection