@extends('admin.layouts.app')

@section('title', 'Activity Log')
@section('page-title', 'Activity Log')

@section('content')

<div class="p-6">
    <div class="bg-white p-6 shadow-sm rounded-lg border border-gray-200">
        
<!-- Header Utama -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b pb-4 border-gray-400">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Media Library</h2>
        <p class="text-sm text-gray-600">Kelola semua aset gambar dan file Anda di sini.</p>
    </div>
    
    <!-- Wrapper Tombol agar Sejajar -->
</div>



<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

    {{-- Total Akrivitas --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-folder2-open text-blue-600 text-lg"></i>
            <p class="text-sm text-blue-600 font-medium">Total Aktivitas</p>
        </div>

        <h2 class="text-3xl font-bold text-blue-700">
            {{ number_format($totalLogs) }}
        </h2>
    </div>

    {{-- Aktif --}}
    <div class="bg-green-50 border border-green-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
            <p class="text-sm text-green-600 font-medium">Aktivitas Hari Ini</p>
        </div>

        <h2 class="text-3xl font-bold text-green-700">
          {{ number_format($todayLogs) }}
        </h2>
    </div>

    {{-- Nonaktif --}}
    <div class="bg-red-50 border border-red-100 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-2">
            <i class="bi bi-x-circle-fill text-red-600 text-lg"></i>
            <p class="text-sm text-red-600 font-medium">Admin Aktif</p>
        </div>

        <h2 class="text-3xl font-bold text-red-700">
           {{ number_format($activeUsers) }}
        </h2>
    </div>

</div>


<!-- PART 2 & 3: Search & Filter Dropdown -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <!-- Search Input -->
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="🔍 Cari aktivitas (user, modul, deskripsi)..." 
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Filter Modul -->
        <div class="w-full md:w-48">
            <select name="module" class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-white">
                <option value="">Semua Modul</option>
                @foreach($modules as $mod)
                    <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>
                        {{ $mod }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Aksi -->
        <div class="w-full md:w-40">
            <select name="action" class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-white uppercase">
                <option value="">Semua Aksi</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>
                        {{ $act }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tombol Cari & Reset -->
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                Cari
            </button>
            @if(request()->hasAny(['search', 'module', 'action']))
                <a href="{{ url()->current() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm font-semibold text-center transition">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tabel Riwayat Aktivitas -->
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-xl font-bold mb-4">Riwayat Aktivitas</h3>
    
<div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full border-collapse">
        <!-- Header Tabel (Disamakan dengan Kategori & User, tanpa garis kotak) -->
        <thead class="bg-[#dce4ec] text-slate-700 text-xs font-bold uppercase tracking-wider">
            <tr>
                <th class="py-3.5 px-4 text-left">Waktu</th>
                <th class="py-3.5 px-4 text-left">User</th>
                <th class="py-3.5 px-4 text-left">Modul</th>
                <th class="py-3.5 px-4 text-center">Aksi</th>
                <th class="py-3.5 px-4 text-left">Deskripsi</th>
                <th class="py-3.5 px-4 text-left">IP Address</th>
                <th class="py-3.5 px-4 text-center">Opsi</th>
            </tr>
        </thead>

        <!-- Isi Tabel (Garis pemisah horizontal halus antar-baris) -->
        <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
            @forelse($logs as $log)
<tr class="border-b odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 transition">
                    <td class="py-3 px-4 whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i') }}</td>
                    <td class="py-3 px-4 font-semibold text-slate-800">{{ $log->user->name ?? 'System' }}</td>
                    <td class="py-3 px-4 font-medium text-slate-700">{{ $log->module }}</td>
                    
                    <!-- Badge Aksi -->
                    <td class="py-3 px-4 text-center whitespace-nowrap">
                        @php
                            $badgeColor = match(strtoupper($log->action)) {
                                'CREATE' => 'bg-emerald-100 text-emerald-700 border-emerald-300',
                                'UPDATE' => 'bg-blue-100 text-blue-700 border-blue-300',
                                'DELETE' => 'bg-red-100 text-red-700 border-red-300',
                                default  => 'bg-slate-100 text-slate-700 border-slate-300',
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase border {{ $badgeColor }}">
                            {{ $log->action }}
                        </span>
                    </td>

                    <td class="py-3 px-4 text-slate-600">{{ $log->description }}</td>
                    <td class="py-3 px-4 text-slate-500 font-mono text-xs">{{ $log->ip_address ?? '-' }}</td>
                    
                    <!-- Tombol Detail -->
                    <td class="py-3 px-4 text-center whitespace-nowrap">
                        <button type="button" 
                                onclick="showDetailModal(this)"
                                data-user="{{ $log->user->name ?? 'System' }}"
                                data-module="{{ $log->module }}"
                                data-action="{{ strtoupper($log->action) }}"
                                data-description="{{ $log->formatted_description }}"
                                data-time="{{ $log->created_at->format('d M Y, H:i:s') }}"
                                data-ip="{{ $log->ip_address ?? '-' }}"
                                class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-3 py-1.5 rounded-lg border border-slate-300 transition shadow-sm">
                            DETAIL
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-slate-400">
                        Tidak ada aktivitas yang sesuai dengan filter/pencarian.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>

<!-- PART 5: Modal Detail Aktivitas -->
<div id="detailModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6 shadow-xl transform transition-all border-t-4 border-blue-600">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-lg font-bold text-gray-800">Detail Aktivitas</h3>
            <button type="button" onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl leading-none">&times;</button>
        </div>
        
        <div class="space-y-3 text-sm">
            <div>
                <span class="text-gray-400 block text-xs uppercase font-semibold">User:</span>
                <strong id="modal-user" class="text-gray-800 text-base font-bold"></strong>
            </div>
            <div class="grid grid-cols-2 gap-2 border-t border-b py-2 my-2 bg-gray-50 px-2 rounded">
                <div>
                    <span class="text-gray-400 block text-xs uppercase font-semibold">Modul:</span>
                    <strong id="modal-module" class="text-gray-800"></strong>
                </div>
                <div>
                    <span class="text-gray-400 block text-xs uppercase font-semibold">Aksi:</span>
                    <span id="modal-action" class="inline-block px-2 py-0.5 text-xs font-bold uppercase rounded border mt-0.5"></span>
                </div>
            </div>
            <div>
                <span class="text-gray-400 block text-xs uppercase font-semibold">Deskripsi:</span>
                <div id="modal-description" class="p-2.5 bg-gray-50 rounded border border-gray-200 text-gray-700 mt-1 font-medium"></div>
            </div>
            <div class="grid grid-cols-2 gap-2 pt-2 border-t">
                <div>
                    <span class="text-gray-400 block text-xs uppercase font-semibold">Waktu:</span>
                    <span id="modal-time" class="text-gray-700 text-xs font-medium"></span>
                </div>
                <div>
                    <span class="text-gray-400 block text-xs uppercase font-semibold">IP Address:</span>
                    <span id="modal-ip" class="text-gray-700 text-xs font-mono font-medium"></span>
                </div>
            </div>
        </div>

        <div class="mt-6 text-right">
            <button type="button" onclick="closeDetailModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold transition">
                Tutup
            </button>
        </div>
    </div>
</div>
</div>
</div>

<script>
function showDetailModal(button) {
    const user = button.getAttribute('data-user');
    const module = button.getAttribute('data-module');
    const action = button.getAttribute('data-action');
    const description = button.getAttribute('data-description');
    const time = button.getAttribute('data-time');
    const ip = button.getAttribute('data-ip');

    document.getElementById('modal-user').innerText = user;
    document.getElementById('modal-module').innerText = module;
    document.getElementById('modal-description').innerText = description;
    document.getElementById('modal-time').innerText = time;
    document.getElementById('modal-ip').innerText = ip;

    const actionEl = document.getElementById('modal-action');
    actionEl.innerText = action;
    
    // Reset warna & pasang warna baru sesuai tipe aksi
    actionEl.className = 'inline-block px-2 py-0.5 text-xs font-bold uppercase rounded border mt-0.5 ';
    if (action === 'CREATE') {
        actionEl.className += 'bg-green-100 text-green-700 border-green-300';
    } else if (action === 'UPDATE') {
        actionEl.className += 'bg-blue-100 text-blue-700 border-blue-300';
    } else if (action === 'DELETE') {
        actionEl.className += 'bg-red-100 text-red-700 border-red-300';
    } else {
        actionEl.className += 'bg-gray-100 text-gray-700 border-gray-300';
    }

    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Tutup modal jika user klik area gelap di luar kotak modal
window.onclick = function(event) {
    const modal = document.getElementById('detailModal');
    if (event.target == modal) {
        closeDetailModal();
    }
}
</script>

@endsection