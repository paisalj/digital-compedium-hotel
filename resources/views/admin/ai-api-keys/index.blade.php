@extends('admin.layouts.app')

@section('title', 'AI API Key Manager')
@section('page-title', 'AI API Key Manager')

@section('content')

<div class="bg-white rounded-2xl shadow-md">
    
    <!-- Header Halaman -->
    <div class="border-b p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold">Daftar AI API Key</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola antrean token cadangan Google Gemini untuk menghindari pembatasan kuota.</p>
        </div>
        <div>
            <a href="{{ route('admin.ai-api-keys.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-xl font-medium inline-flex items-center gap-2 shadow-sm transition">
                <span>➕</span> Tambah API Key
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if (session('success'))
    <div class="m-6 p-4 text-sm text-green-700 bg-green-100 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="m-6 p-4 text-sm text-red-700 bg-red-100 rounded-xl">
        {{ session('error') }}
    </div>
    @endif

    <!-- Kotak Informasi Sistem Otomatis -->
<div class="m-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
    <div class="text-xl mt-0.5">ℹ️</div>
    <div>
        <h4 class="font-bold text-blue-900 text-sm">Cara Kerja Sistem Antrean Multi-API:</h4>
        <p class="text-xs text-blue-700 mt-1 leading-relaxed">
            Sistem akan otomatis menggunakan API Key dari urutan teratas (No. 1). Jika token tersebut kehabisan kuota atau terkena batasan <strong>Error 429 (Too Many Requests)</strong>, sistem akan mengistirahatkannya selama 15 menit dan <strong>otomatis beralih sendiri</strong> menggunakan token cadangan berikutnya di bawahnya. Anda tidak perlu mengubah file konfigurasi sistem.
        </p>
    </div>
</div>

    <!-- Tabel Data API Key -->
    <div class="p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-gray-200 text-gray-800 font-bold">
                    <th class="pb-4 text-center w-12">No</th>
                    <th class="pb-4 px-4">Nama Penanda</th>
                    <th class="pb-4 px-4">Token (API Key)</th>
                    <th class="pb-4 px-4 text-center">Status Kerja</th>
                    <th class="pb-4 px-4 text-center">Hak Akses</th>
                    <th class="pb-4 px-4 text-center">Terakhir Digunakan</th>
                    <th class="pb-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse ($keys as $index => $key)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-4 text-center font-medium">{{ $index + 1 }}</td>
                    <td class="py-4 px-4 font-semibold text-gray-900">{{ $key->name }}</td>
                    <td class="py-4 px-4 font-mono text-sm text-gray-500">
                        <!-- Sensor token agar aman dilihat, hanya munculkan 6 huruf awal & 4 huruf akhir -->
                        {{ Str::limit($key->api_key, 6, '') }}...{{ substr($key->api_key, -4) }}
                    </td>
                    <td class="py-4 px-4 text-center">
                        @if ($key->status === 'ready')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Aktif (Ready)</span>
                        @else
                            <div class="inline-block text-center">
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider block">Limit (429)</span>
                                @if($key->reset_quota_at)
                                    <span class="text-[10px] text-gray-400 block mt-1">Reset: {{ $key->reset_quota_at->format('H:i') }}</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-center">
                        @if ($key->is_active)
                            <span class="text-green-600 font-semibold flex items-center justify-center gap-1">🟢 Diizinkan</span>
                        @else
                            <span class="text-gray-400 font-semibold flex items-center justify-center gap-1">🔴 Ditangguhkan</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-center text-sm text-gray-500">
                        {{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'Belum Pernah' }}
                    </td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-2 text-sm font-medium">
                            <a href="{{ route('admin.ai-api-keys.edit', $key->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-0.5">
                                📝 Edit
                            </a>
                            <span class="text-gray-300">|</span>
<!-- Cari blok ini di bagian tombol aksi tabel Anda -->
<form action="{{ route('admin.ai-api-keys.destroy', $key->id) }}" method="POST" class="inline delete-form">
    @csrf
    @method('DELETE')
    <button type="button" onclick="konfirmasiHapus(this, '{{ $key->name }}')" class="text-red-600 hover:text-red-800 flex items-center gap-0.5">
        🗑️ Hapus
    </button>
</form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-gray-400 italic bg-gray-50 rounded-xl">
                        Belum ada API Key cadangan yang dimasukkan ke database. Sistem saat ini mengandalkan ban serep file .env.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiHapus(button, namaToken) {
        Swal.fire({
            title: 'Hapus API Key?',
            text: "Token '" + namaToken + "' akan dihapus permanen dari sistem antrean fallback!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Warna Merah (Tailwind red-500)
            cancelButtonColor: '#6b7280',  // Warna Abu-abu (Tailwind gray-500)
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-4 py-2 font-medium',
                cancelButton: 'rounded-xl px-4 py-2 font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika admin klik Ya, form dikirimkan secara otomatis
                button.closest('.delete-form').submit();
            }
        });
    }
</script>