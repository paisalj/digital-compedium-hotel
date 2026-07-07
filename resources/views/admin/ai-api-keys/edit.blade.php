@extends('admin.layouts.app')

@section('title', 'Edit AI API Key')
@section('page-title', 'Edit AI API Key')

@section('content')

<div class="bg-white rounded-2xl shadow-md">

    <!-- Judul Halaman -->
    <div class="border-b p-6">
        <h2 class="text-2xl font-bold">
            Edit AI API Key
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Perbarui data token atau sesuaikan status antrean kerja secara manual.
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
    <form action="{{ route('admin.ai-api-keys.update', $apiKey->id) }}" method="POST">
        @csrf
        @method('PUT')

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
                        value="{{ old('name', $apiKey->name) }}"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
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
                        <option value="1" {{ old('is_active', $apiKey->is_active) ? 'selected' : '' }}>
                            🟢 Diizinkan (Aktif dalam Antrean)
                        </option>
                        <option value="0" {{ !old('is_active', $apiKey->is_active) ? 'selected' : '' }}>
                            🔴 Ditangguhkan (Nonaktifkan Sementara)
                        </option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Input Token / API Key -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        Token (API Key Gemini)
                    </label>
                    <input
                        type="text"
                        name="api_key"
                        value="{{ old('api_key', $apiKey->api_key) }}"
                        class="w-full border rounded-xl px-4 py-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        required
                    >
                </div>

                <!-- Input Status Kerja (Bisa direset manual ke 'ready' jika masa block beralih) -->
                <div>
                    <label class="block mb-2 font-medium text-gray-700">
                        Status Kerja Saat Ini
                    </label>
                    <select
                        name="status"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        required
                    >
                        <option value="ready" {{ old('status', $apiKey->status) === 'ready' ? 'selected' : '' }}>
                            ✅ Aktif (Ready untuk Digunakan)
                        </option>
                        <option value="quota_exceeded" {{ old('status', $apiKey->status) === 'quota_exceeded' ? 'selected' : '' }}>
                            ⚠️ Limit (Sedang Masa Cooldown 429)
                        </option>
                    </select>
                    @if($apiKey->reset_quota_at)
                        <p class="text-xs text-red-500 mt-1.5">
                            *Token ini otomatis terkunci oleh sistem dan akan terbuka kembali pada pukul: <strong>{{ $apiKey->reset_quota_at->format('H:i:s') }}</strong>
                        </p>
                    @endif
                </div>
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
                Perbarui Kunci
            </button>
        </div>

    </form>
</div>

@endsection