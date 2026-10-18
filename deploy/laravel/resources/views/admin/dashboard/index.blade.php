@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<!-- Chart.js CDN untuk membuat grafik dinamis -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6">

<!-- LOGIKA WAKTU (SELAMAT PAGI/SIANG/SORE/MALAM) -->
<!-- LOGIKA WAKTU -->
@php
    $jam = \Carbon\Carbon::now()->format('H');
    
    if ($jam >= 5 && $jam < 11) {
        $sapaan = 'Selamat Pagi';
    } elseif ($jam >= 11 && $jam < 15) {
        $sapaan = 'Selamat Siang';
    } elseif ($jam >= 15 && $jam < 18) {
        $sapaan = 'Selamat Sore';
    } else {
        $sapaan = 'Selamat Malam';
    }
    
    $roleName = auth()->user()->role ?? 'admin';
    $userName = auth()->user()->name ?? 'Administrator';
    $fullGreeting = "{$sapaan}, Selamat Datang Kembali ({$roleName}) 👋";
@endphp

<!-- BANNER DENGAN EFEK KETIK (TYPEWRITER) -->
<div class="bg-gradient-to-r from-slate-900 to-slate-700 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden flex justify-between items-center">
    <div class="relative z-10 max-w-full">
        <!-- Elemen Judul dengan Efek Ketik -->
        <h2 id="typewriter-text" class="text-2xl md:text-3xl font-bold min-h-[40px] border-r-4 border-yellow-400 pr-2 inline-block animate-pulse">
            <!-- Teks akan diketik otomatis oleh JavaScript di bawah -->
        </h2>
        <p class="mt-2 text-slate-300 text-sm md:text-base">
            Kelola seluruh Digital Compendium M Bahalap Hotel dari dashboard ini.
        </p>
    </div>
    <div class="hidden md:flex items-center gap-2 bg-white/10 px-4 py-2 rounded-2xl backdrop-blur-md border border-white/10 text-xs font-semibold shrink-0">
        <i class="bi bi-calendar-event text-yellow-400"></i>
        <span>{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</span>
    </div>
</div>

<!-- KARTU STATISTIK INTERAKTIF (100% DINAMIS DARI DATABASE) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">

    <!-- 1. KATEGORI -->
    <a href="{{ route('admin.categories.index') ?? '#' }}" 
       class="block bg-white rounded-2xl p-5 border-2 border-blue-200 hover:border-blue-500 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Kategori</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">
                    {{ $totalCategories }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-100 group-hover:bg-blue-600 group-hover:text-white text-blue-600 flex items-center justify-center shrink-0 transition-colors">
                <i class="bi bi-folder-fill text-2xl"></i>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-blue-50 flex items-center justify-between text-[11px]">
            <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                {{ $activeCategories }} Aktif
            </span>
            <span class="inline-flex items-center gap-1 font-semibold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-200">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                {{ $inactiveCategories }} Off
            </span>
        </div>
    </a>

    <!-- 2. KONTEN -->
    <a href="{{ route('admin.contents.index') ?? '#' }}" 
       class="block bg-white rounded-2xl p-5 border-2 border-emerald-200 hover:border-emerald-500 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Konten</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">
                    {{ $totalContents }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-100 group-hover:bg-emerald-600 group-hover:text-white text-emerald-600 flex items-center justify-center shrink-0 transition-colors">
                <i class="bi bi-file-earmark-text-fill text-2xl"></i>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-emerald-50 flex items-center justify-between text-[11px]">
            <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                {{ $activeContents }} Aktif
            </span>
            <span class="inline-flex items-center gap-1 font-semibold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-200">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                {{ $inactiveContents }} Off
            </span>
        </div>
    </a>

    <!-- 3. MEDIA -->
    <a href="{{ route('admin.media.index') ?? '#' }}" 
       class="block bg-white rounded-2xl p-5 border-2 border-purple-200 hover:border-purple-500 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-purple-600 uppercase tracking-wider">Media</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">
                    {{ $totalMedia }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-100 group-hover:bg-purple-600 group-hover:text-white text-purple-600 flex items-center justify-center shrink-0 transition-colors">
                <i class="bi bi-images text-2xl"></i>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-purple-50 flex items-center text-[11px] text-purple-600 font-semibold">
            <span><i class="bi bi-arrow-right-circle mr-1"></i> Lihat semua aset</span>
        </div>
    </a>

    <!-- 4. BAHASA -->
    <a href="{{ route('admin.languages.index') ?? '#' }}" 
       class="block bg-white rounded-2xl p-5 border-2 border-amber-200 hover:border-amber-500 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Bahasa</p>
                <h3 class="text-3xl font-extrabold text-gray-800 mt-1">
                    {{ $totalLanguages }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 group-hover:bg-amber-500 group-hover:text-white text-amber-600 flex items-center justify-center shrink-0 transition-colors">
                <i class="bi bi-translate text-2xl"></i>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-amber-50 flex items-center text-[11px] text-amber-600 font-semibold">
            <span><i class="bi bi-check-circle-fill mr-1"></i> Semua Bahasa Aktif</span>
        </div>
    </a>
<!-- 5. KARTU RINGKASAN: TOTAL ITEM COMPENDIUM (KATEGORI + KONTEN) -->
<div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-5 border-2 border-slate-700 shadow-md text-white flex flex-col justify-between">
    <div class="flex justify-between items-start">
        <div>
            <p class="text-xs font-bold text-yellow-400 uppercase tracking-wider">Total Item Compendium</p>
            <h3 class="text-3xl font-extrabold mt-1">
                {{ $totalCompendiumData }}
            </h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-white/10 text-yellow-400 flex items-center justify-center shrink-0 backdrop-blur-sm border border-white/10">
            <i class="bi bi-pie-chart-fill text-2xl"></i>
        </div>
    </div>

    <!-- Rincian Status Aktif & Off Pas (12 + 4 = 16) -->
    <div class="mt-4 pt-3 border-t border-slate-700/60 flex items-center justify-between text-[11px]">
        <span class="inline-flex items-center gap-1 font-bold text-emerald-400" title="Total Kategori & Konten Aktif">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            {{ $totalAllActive }} Aktif
        </span>
        <span class="inline-flex items-center gap-1 font-bold text-rose-400" title="Total Kategori & Konten Non-aktif">
            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
            {{ $totalAllInactive }} Off
        </span>
    </div>
</div>

</div>

<!-- 3. SECTION GRAFIK STATISTIK (Line Chart & Donut Chart) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Line Chart: Tren Kunjungan Tamu (Mengambil 2 Kolom dengan lg:col-span-2) -->
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
        
        <!-- HEADER GRAFIK & BADGE -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-lg font-bold text-gray-800">Statistik Kunjungan Tamu</h3>
                    @if(isset($topCategory))
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold rounded-full">
                            <i class="bi bi-fire text-amber-500"></i>
                            Paling Dilihat: <strong class="text-amber-800">{{ $topCategory->name ?? 'Restoran & Cafe' }}</strong> ({{ $topCategory->views ?? 0 }}x)
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Estimasi pantauan trafik pembaca compendium secara real-time</p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <span class="bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200">
                    <i class="bi bi-calendar3 mr-1"></i> 1 Bulan Terakhir
                </span>
            </div>
        </div>

        <!-- CANVAS CHART.JS -->
        <div class="relative w-full h-[280px]">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>

<!-- Donut Chart: Distribusi Bahasa (Mengambil 1 Kolom) -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 flex flex-col justify-between">
        <div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Penggunaan Bahasa</h3>
            <p class="text-xs text-gray-400 mb-4">Bahasa yang dipilih tamu hotel</p>
            <div class="h-48 relative flex justify-center items-center">
                <canvas id="languageChart"></canvas>
            </div>
        </div>
        
        <div class="grid grid-cols-3 gap-2 text-center pt-4 border-t border-gray-100 mt-2">
            <div>
                <span class="block text-[10px] text-gray-400 uppercase font-semibold">Indo</span>
                <!-- 👈 Ubah teks statis jadi dinamis -->
                <span class="text-xs font-bold text-slate-700">{{ $languageUsage['Indo'] ?? 0 }}%</span>
            </div>
            <div>
                <span class="block text-[10px] text-gray-400 uppercase font-semibold">English</span>
                <!-- 👈 Ubah teks statis jadi dinamis -->
                <span class="text-xs font-bold text-slate-700">{{ $languageUsage['English'] ?? 0 }}%</span>
            </div>
            <div>
                <span class="block text-[10px] text-gray-400 uppercase font-semibold">Dayak</span>
                <!-- 👈 Ubah teks statis jadi dinamis -->
                <span class="text-xs font-bold text-slate-700">{{ $languageUsage['Dayak'] ?? 0 }}%</span>
            </div>
        </div>
    </div>

</div>
<!--  -->

    <!-- 4. SECTION KATEGORI TERPOPULER, QUICK ACTION & AKTIVITAS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

<!-- Kategori Terpopuler -->
<div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 flex flex-col justify-between">
    <div>
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">🔥 Kategori Terpopuler</h3>
            <span class="text-xs text-gray-400">Dilihat Tamu</span>
        </div>

<div class="space-y-3">
    @forelse($popularCategories as $index => $cat)
        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
            <div class="flex items-center space-x-3">
                <!-- Peringkat Urutan (1, 2, 3 naik-turun otomatis) -->
                <span class="w-6 h-6 flex items-center justify-center bg-amber-100 text-amber-700 font-bold text-xs rounded-lg">
                    {{ $index + 1 }}
                </span>
                <div>
                    <h4 class="text-sm font-bold text-slate-700">{{ $cat->name }}</h4>
                </div>
            </div>
            
            <!-- Total Views dari tabel guest_views -->
            <span class="text-xs font-semibold text-slate-600 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                {{ $cat->total_views }} views
            </span>
        </div>
    @empty
        <p class="text-xs text-gray-400 text-center py-4">Belum ada data kunjungan kategori.</p>
    @endforelse
</div>

</div>
</div>

<!-- Statistik Perangkat Tamu (Versi Premium & Modern) -->
<div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 flex flex-col justify-between">
    <div>
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <span>📱</span> Perangkat Tamu
            </h3>
            <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg border border-slate-200">
                Total: {{ $totalDeviceVisits ?? 0 }} Akses
            </span>
        </div>

        <div class="space-y-4">
            <!-- 1. Mobile / Smartphone -->
            <div class="p-3.5 bg-blue-50/50 rounded-xl border border-blue-100/60 transition-all hover:bg-blue-50">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg text-sm shadow-sm">
                            📱
                        </span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-700">Smartphone / Mobile</h4>
                            <span class="text-[10px] text-slate-400">Android & iOS</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold text-blue-600">{{ $devicePercentages['Mobile'] ?? 0 }}%</span>
                        <span class="block text-[10px] text-slate-400">{{ $devices['Mobile'] ?? 0 }} akses</span>
                    </div>
                </div>
                <div class="w-full bg-blue-100/60 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $devicePercentages['Mobile'] ?? 0 }}%"></div>
                </div>
            </div>

            <!-- 2. Tablet / iPad -->
            <div class="p-3.5 bg-amber-50/50 rounded-xl border border-amber-100/60 transition-all hover:bg-amber-50">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-8 h-8 flex items-center justify-center bg-amber-100 text-amber-600 rounded-lg text-sm shadow-sm">
                            📖
                        </span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-700">Tablet / iPad</h4>
                            <span class="text-[10px] text-slate-400">Layar Besar / Tab</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold text-amber-600">{{ $devicePercentages['Tablet'] ?? 0 }}%</span>
                        <span class="block text-[10px] text-slate-400">{{ $devices['Tablet'] ?? 0 }} akses</span>
                    </div>
                </div>
                <div class="w-full bg-amber-100/60 h-2 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-2 rounded-full transition-all duration-500" style="width: {{ $devicePercentages['Tablet'] ?? 0 }}%"></div>
                </div>
            </div>

            <!-- 3. Desktop / Laptop -->
            <div class="p-3.5 bg-emerald-50/50 rounded-xl border border-emerald-100/60 transition-all hover:bg-emerald-50">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-8 h-8 flex items-center justify-center bg-emerald-100 text-emerald-600 rounded-lg text-sm shadow-sm">
                            💻
                        </span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-700">Komputer / Laptop</h4>
                            <span class="text-[10px] text-slate-400">Desktop Browser</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-bold text-emerald-600">{{ $devicePercentages['Desktop'] ?? 0 }}%</span>
                        <span class="block text-[10px] text-slate-400">{{ $devices['Desktop'] ?? 0 }} akses</span>
                    </div>
                </div>
                <div class="w-full bg-emerald-100/60 h-2 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width: {{ $devicePercentages['Desktop'] ?? 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- WIDGET: Konten Spesifik Terfavorit & Jumlah Disukai -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5 flex-1">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="font-extrabold text-gray-800 text-sm flex items-center gap-2">
                <i class="bi bi-star-fill text-amber-500"></i> Konten Paling Disukai (Favorit)
            </h3>
            <p class="text-[11px] text-gray-400 mt-0.5">Halaman compendium spesifik beserta total yang disimpan tamu.</p>
        </div>
        <span class="text-[11px] bg-amber-50 text-amber-600 font-bold px-2.5 py-1 rounded-md border border-amber-100">
            Top Favorites
        </span>
    </div>

    <!-- Daftar Konten Terfavorit -->
    <div class="space-y-2.5">
        @forelse($topFavoriteContents ?? [] as $index => $item)
        @php
            $translation = $item->translations->first();
            $categoryName = $item->category->translations->first()->name ?? $item->category->name ?? 'Umum';
        @endphp
        <div class="flex items-start justify-between p-3 bg-gray-50/70 rounded-xl border border-gray-100/80 hover:bg-amber-50/30 transition gap-3">
            <div class="flex items-start gap-3 min-w-0 flex-1">
                <!-- Nomor Peringkat -->
                <span class="w-6 h-6 rounded-lg bg-amber-100 text-amber-700 font-extrabold text-xs flex items-center justify-center shrink-0 mt-0.5">
                    {{ $index + 1 }}
                </span>
                
                <!-- Judul & Kategori (Bisa turun ke bawah / Multi-line) -->
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-gray-800 leading-snug break-words">
                        {{ $translation->title ?? 'Tanpa Judul' }}
                    </p>
                    <span class="inline-block text-[10px] font-medium text-gray-400 mt-0.5">
                        ({{ $categoryName }})
                    </span>
                </div>
            </div>
            
            <!-- Badge Jumlah Disukai -->
            <span class="text-[11px] font-bold text-amber-600 bg-white px-2.5 py-1 rounded-lg border border-gray-200/60 shrink-0 flex items-center gap-1 shadow-2xs">
                <i class="bi bi-star-fill text-[10px] text-amber-500"></i> {{ $item->favorites_count ?? 0 }} disukai
            </span>
        </div>
        @empty
        <div class="text-center py-10 text-gray-400 text-xs italic">
            Belum ada data konten favorit yang tersimpan.
        </div>
        @endforelse
    </div>
</div>

    </div>

</div>

<!-- PASTIKAN LIBRARY CHART.JS SUDAH DILOAD -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. GRAFIK STATISTIK KUNJUNGAN TAMU (Line Chart)
    const visitorCanvas = document.getElementById('visitorChart');
    if (visitorCanvas) {
        const ctx = visitorCanvas.getContext('2d');
        const labels = @json($chartDates ?? []);
        const dataViews = @json($chartViews ?? []);

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(15, 23, 42, 0.15)');
        gradient.addColorStop(1, 'rgba(15, 23, 42, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kunjungan Tamu',
                    data: dataViews,
                    borderColor: '#0f172a',
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#0f172a',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return ` ${context.raw} Views / Kunjungan`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10, weight: '600' },
                            color: '#64748b',
                            maxRotation: 45,
                            autoSkip: true,
                            maxTicksLimit: 15
                        }
                    },
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { size: 11 },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    }

// 2. GRAFIK PENGGUNAAN BAHASA (Donut Chart)
    const langCanvas = document.getElementById('languageChart');
    if (langCanvas) {
        const ctxLang = langCanvas.getContext('2d');
        new Chart(ctxLang, {
            type: 'doughnut',
            data: {
                labels: ['Indo', 'English', 'Dayak'],
                datasets: [{
                    data: [
                        {{ $languageUsage['Indo'] ?? 0 }}, 
                        {{ $languageUsage['English'] ?? 0 }}, 
                        {{ $languageUsage['Dayak'] ?? 0 }}
                    ],
                    backgroundColor: ['#2563eb', '#16a34a', '#eab308'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '75%'
            }
        });
    }
    
    // 3. SCRIPT EFEK KETIK
    const text = @json($fullGreeting ?? '');
    const target = document.getElementById("typewriter-text");
    if (target && text) {
        let index = 0;
        function typeEffect() {
            if (index < text.length) {
                target.innerHTML += text.charAt(index);
                index++;
                setTimeout(typeEffect, 70);
            } else {
                target.classList.remove("border-r-4", "animate-pulse");
            }
        }
        typeEffect();
    }

});
</script>

@endsection