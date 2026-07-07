@extends('admin.layouts.app')

@section('title', 'Tambah AI API Key')
@section('page-title', 'Tambah AI API Key')

@section('content')

<div class="bg-white rounded-2xl shadow-md">

    <!-- Judul Halaman -->
    <div class="border-b p-6">
        <h2 class="text-2xl font-bold">
            Tambah AI API Key
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Tambahkan token (API Key) Google AI Studio baru ke dalam sistem antrean fallback.
        </p>
    </div>

    <!-- Alert Error Jika Validasi Gagal -->
    @if (session('error'))
    <div class="m-6 p-4 text-sm text-red-700 bg-red-100 rounded-xl">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="m-6 p-4 text-sm text-red-700 bg-red-100 rounded-xl">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Kotak Peringatan Input Token -->
<div class="m-6 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3">
    <div class="text-xl mt-0.5">⚠️</div>
    <div>
        <h4 class="font-bold text-amber-950 text-sm">Penting Sebelum Menyimpan:</h4>
        <p class="text-xs text-amber-800 mt-1 leading-relaxed">
            Pastikan Token (API Key) yang dimasukkan disalin secara utuh dari <strong>Google AI Studio</strong> dan diawali dengan karakter <strong>AQ...</strong>. Kesalahan penginputan kode dapat menyebabkan fitur penerjemah otomatis pada Kategori atau Konten Hotel mengalami kendala.
        </p>
    </div>
</div>

    <!-- Form Input -->
    <form action="{{ route('admin.ai-api-keys.store') }}" method="POST">
        @csrf

        <div class="p-6 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Input Nama Penanda -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        Nama Penanda / Label
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        placeholder="cth: Akun Utama M Bahalap / Cadangan Gmail Paisal"
                        required
                    >
                </div>

                <!-- Input Hak Akses / Status Aktif -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        Hak Akses Sistem
                    </label>
                    <select
                        name="is_active"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        required
                    >
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                            🟢 Diizinkan (Aktif dalam Antrean)
                        </option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                            🔴 Ditangguhkan (Nonaktifkan Sementara)
                        </option>
                    </select>
                </div>
            </div>

            <!-- Input Token / API Key (Dibuat panjang/lebar agar muat kode AQ...) -->
            <div>
                <label class="block mb-2 font-medium text-gray-700">
                    Token (API Key Gemini)
                </label>
                <input
                    type="text"
                    name="api_key"
                    value="{{ old('api_key') }}"
                    class="w-full border rounded-xl px-4 py-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    placeholder="Masukkan token Gemini yang diawali kode AQ..."
                    required
                >
                <p class="text-xs text-gray-400 mt-2">
                    *Pastikan token yang dimasukkan valid dari Google AI Studio agar tidak memicu gangguan translasi.
                </p>
            </div>

        </div>

        <!-- Tombol Aksi Bawah -->
        <div class="border-t p-6 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
            <a
                href="{{ route('admin.ai-api-keys.index') }}"
                class="px-6 py-3 border border-gray-300 bg-white text-gray-700 rounded-xl font-medium hover:bg-gray-100 transition"
            >
                Batal
            </a>

            <button
                type="submit"
                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-medium shadow-sm transition"
            >
                Simpan Kunci
            </button>
        </div>

    </form>
</div>

@endsection