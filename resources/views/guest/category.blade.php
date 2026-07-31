@php
    // Inisialisasi bahasa aktif di paling atas agar terbaca di semua baris kode
    $currentLang = request('lang', session('lang', 'id'));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories | M Bahalap Hotel</title>

    <link rel="icon" type="image/png" href="{{ isset($settings['hotel_logo']) && $settings['hotel_logo'] ? asset('storage/' . $settings['hotel_logo']) : asset('images/default-logo.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Marcellus&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: linear-gradient(rgba(230, 255, 255, 0.82), rgba(230, 255, 255, 0.82)),
                              url('{{ isset($settings['hotel_background']) && $settings['hotel_background'] ? asset("storage/" . $settings['hotel_background']) : asset("images/default-bg.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none;     /* IE 10 and IE 11 */
            user-select: none;         /* Standard syntax */
        }
        
        .serif-title {
            font-family: 'Marcellus', serif;
        }
        .text-gold { color: #c59a36; }
        .bg-gold { background-color: #c59a36; }

        /* Background Pattern Bintik Halus */
        .bg-pattern { 
            position: absolute; 
            inset: 0; 
            background: radial-gradient(circle at center, rgba(0,0,0,0.02) 1px, transparent 1px); 
            background-size: 20px 20px; 
            pointer-events: none;
            z-index: 0;
        }
/* Mengembalikan border tipis untuk tombol Favorit & Bahasa di Mode Siang */
    .btn-favorit, .btn-bahasa {
        border: 1px solid #e5e7eb !important;
    }
/* ========================================================= */
        /* DARK MODE HIDUP & ELEGAN (CATEGORY)                      */
        /* ========================================================= */
        
        /* 1. Background utama lebih transparan agar wallpaper hotel kelihatan hidup */
        html.dark body {
            background-image: linear-gradient(rgba(15, 23, 42, 0.90), rgba(15, 23, 42, 0.90)), 
                              url('{{ isset($settings['hotel_background']) && $settings['hotel_background'] ? asset("storage/" . $settings['hotel_background']) : asset("assets/img/default_bg.jpg") }}') !important;
        }

        /* 2. Kartu Menu / Kategori (Lebih terang, ada efek gradasi & border emas elegan) */
        html.dark .bg-white,
        html.dark div[class*="bg-white"] {
            background: linear-gradient(145deg, #1e293b, #0f172a) !important;
            border: 1px solid rgba(197, 154, 54, 0.4) !important; /* Border emas tipis menyala */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3) !important;
        }

        /* Efek hover saat kartu disentuh */
        html.dark .bg-white:hover,
        html.dark div[class*="bg-white"]:hover {
            border-color: #fbbf24 !important;
            box-shadow: 0 10px 25px rgba(197, 154, 54, 0.25) !important;
        }

        /* 3. Teks di dalam kartu & halaman agar terang & tajam */
        html.dark span, 
        html.dark p, 
        html.dark h3,
        html.dark a {
            color: #f3f4f6 !important;
        }

        /* 4. Memperbaiki Tombol "Favorit" agar teksnya terlihat jelas di mode malam */
        html.dark a[href*="favorit"],
        html.dark button[class*="favorit"],
        html.dark .btn-favorit {
            background-color: #1e293b !important;
            border: 1px solid #c59a36 !important;
            color: #ffffff !important;
        }

        /* 5. Memperbaiki Tombol / Dropdown Bahasa agar kontras & hidup */
        html.dark .btn-bahasa,
        html.dark #btnDropdownLang {
            background-color: #1e293b !important;
            border-color: #c59a36 !important;
            color: #ffffff !important;
        }

        html.dark #boxDropdownLang {
            background-color: #1e293b !important;
            border-color: #c59a36 !important;
        }

        html.dark #boxDropdownLang a {
            color: #ffffff !important;
        }

        html.dark #boxDropdownLang a:hover {
            background-color: #334155 !important;
            color: #fbbf24 !important;
        }

        /* 6. Kotak Bantuan WhatsApp di Bagian Bawah */
        html.dark div[style*="background-color: white"],
        html.dark .help-section {
            background: linear-gradient(135deg, #1e293b, #111827) !important;
            border: 1px solid rgba(197, 154, 54, 0.5) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4) !important;
        }

        /* 7. Tombol Toggle Mode */
        html.dark #theme-toggle {
            background-color: #1e293b !important;
            border-color: #c59a36 !important;
            color: #f3f4f6 !important;
        }
        /* 1. Mengubah tombol Favorit & Tombol Bahasa agar gelap dan tidak silau saat Mode Malam */
    html.dark .btn-favorit,
    html.dark .btn-bahasa,
    html.dark #btnDropdownLang {
        background-color: #1e293b !important;
        border-color: #c59a36 !important;
        color: #f3f4f6 !important;
    }

    /* 2. Mengubah kotak menu dropdown bahasa agar latar belakangnya gelap */
    html.dark #boxDropdownLang {
        background-color: #1e293b !important;
        border: 1px solid #c59a36 !important;
    }

    /* 3. Mengubah teks pilihan bahasa di dalam dropdown agar kontras dan terbaca jelas */
    html.dark #boxDropdownLang a {
        color: #f3f4f6 !important;
    }

/* Memaksa item bahasa yang aktif di dropdown agar tidak silau saat Dark Mode */
    html.dark #boxDropdownLang a[style*="background-color"] {
        background-color: #334155 !important;
        color: #fbbf24 !important;
    }
    
    /* Efek hover saat disentuh di mode malam */
    html.dark #boxDropdownLang a:hover {
        background-color: #334155 !important;
        color: #fbbf24 !important;
    }
    /* Definisi Animasi Masuk (Fade In + Slide Up) */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Menerapkan animasi ke container utama halaman agar tampil mulus saat dibuka */
    .page-transition {
        animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Efek transisi halus untuk card/item di dalam halaman */
    .card-animate {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0; /* Mulai dari transparan sebelum animasi berjalan */
    }

    /* Memberikan jeda waktu (stagger effect) agar card muncul bergantian secara estetik */
    .card-animate:nth-child(1) { animation-delay: 0.05s; }
    .card-animate:nth-child(2) { animation-delay: 0.1s; }
    .card-animate:nth-child(3) { animation-delay: 0.15s; }
    .card-animate:nth-child(4) { animation-delay: 0.2s; }
    .card-animate:nth-child(n+5) { animation-delay: 0.25s; }

    /* Khusus Top Bar / Header: Matikan border kuning di Dark Mode */
html.dark div.sticky {
    border: none !important;
    border-bottom: 1px solid #334155 !important; /* Hanya garis penyekat tipis di bawah */
    box-shadow: none !important;
}
/* ========================================================= */
/* MATIKAN EFEK BORDER & SHADOW KUNING TOP BAR SAAT DIKLIK   */
/* ========================================================= */
html.dark div.sticky,
html.dark div.sticky:hover,
html.dark div.sticky:focus,
html.dark div.sticky:active {
    border: none !important;
    border-bottom: 1px solid #334155 !important;
    box-shadow: none !important;
    outline: none !important;
}

/* Menghilangkan sorotan klik bawaan browser HP / Webkit */
div.sticky, 
div.sticky * {
    -webkit-tap-highlight-color: transparent !important;
    outline: none !important;
}
/* Memaksa warna teks input saat mode gelap aktif */
    .dark .search-input-custom {
        color: #ffffff !important;
        -webkit-text-fill-color: #ffffff !important;
    }
    .search-input-custom {
        color: #0f172a !important;
    }

        </style>
</head>
<body class="antialiased text-slate-800">

    <!-- CONTAINER UTAMA -->
<!-- 1. TOP BAR PUTIH ELEGAN (STICKY) -->
<!-- 1. TOP BAR PUTIH ELEGAN (STICKY) -->
<div class="sticky top-0 z-50 w-full bg-white border-b border-slate-100 shadow-xs" style="background-color: white; border-bottom: 1px solid #f1f5f9; padding: 0 20px; height: 56px; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box;">
    
    <!-- Tombol Kembali -->
    <a href="{{ url('/?lang=' . $currentLang) }}" class="hover:opacity-80 active:scale-95 transition-all" style="display: flex; align-items: center; gap: 4px; text-decoration: none; color: #c59a36; font-size: 14px; font-weight: 600;">
        <i class="bi bi-chevron-left" style="-webkit-text-stroke: 0.5px; font-size: 13px; transform: translateY(1px);"></i>
        <span>
            @if($currentLang == 'en')
                Back
            @elseif($currentLang == 'dayak')
                Haluli
            @else
                Kembali
            @endif
        </span>
    </a>

    <!-- Bagian Kanan: Tombol Favorit & Dropdown Bahasa -->
    <div style="display: flex; align-items: center; gap: 8px;">

        <!-- 🌙 TOMBOL BULAT TOGGLE MODE (BARU) -->
        <button type="button" id="theme-toggle" onclick="toggleTheme()"
            style="width: 36px; height: 36px; border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.95); border: 2px solid #c59a36; cursor: pointer; box-shadow: 0 2px 5px rgba(197, 154, 54, 0.3);">
            <span id="theme-icon" style="font-size: 14px;">🌙</span>
        </button>


<button type="button" onclick="toggleFavoritesDrawer()" class="btn-favorit" style="padding: 0 10px; height: 32px; font-size: 13px; border-radius: 9999px; display: flex; align-items: center; justify-content: center; gap: 5px; cursor: pointer; font-weight: 600;">
    <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;" viewBox="0 0 24 24" fill="currentColor" class="text-amber-500">
        <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.159 2.68 1.34 2.838 2.839 1.7 16.522-17.13 16.522-15.418 0 .158-1.5 1.34-2.68 2.838-2.839z" clip-rule="evenodd" />
    </svg>
    <span style="font-size: 12px;">Favorit</span>
</button>

        <!-- === DROPDOWN BAHASA === -->
        <div style="position: relative; z-index: 50; display: flex; align-items: center;">
            <button type="button" id="btnDropdownLang" onclick="toggleLangDropdown(event)" 
                class="btn-bahasa" 
                style="padding: 0 14px; height: 32px; font-size: 13px; border-radius: 9999px; display: flex; align-items: center; justify-content: center; gap: 6px; background: white; border: 1px solid #e5e7eb; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05); font-weight: 700; color: #374151; box-sizing: border-box;">
                <span style="font-size: 15px; display: flex; align-items: center;">🌐</span> 
                <span style="display: flex; align-items: center; line-height: 1;">{{ strtoupper($currentLang == 'dayak' ? 'DK' : $currentLang) }}</span>
                <svg style="width: 12px; height: 12px; color: #6b7280; transition: transform 0.2s; display: flex; align-items: center;" id="arrowDropdownLang" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="boxDropdownLang" class="hidden" 
                 style="position: absolute; right: 0; top: 100%; margin-top: 8px; width: 140px; border-radius: 10px; background-color: white; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.15); overflow: hidden; z-index: 100;">
                <div style="padding: 4px 0;">
                    <a href="?lang=id" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 13px; color: #374151; text-decoration: none; font-weight: 600; {{ $currentLang == 'id' ? 'background-color: #fef3c7; color: #c59a36; font-weight: bold;' : '' }}">
                        <span>ID</span> Indonesia
                    </a>
                    <a href="?lang=en" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 13px; color: #374151; text-decoration: none; font-weight: 600; {{ $currentLang == 'en' ? 'background-color: #fef3c7; color: #c59a36; font-weight: bold;' : '' }}">
                        <span>EN</span> English
                    </a>
                    <a href="?lang=dayak" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 13px; color: #374151; text-decoration: none; font-weight: 600; {{ $currentLang == 'dayak' ? 'background-color: #fef3c7; color: #c59a36; font-weight: bold;' : '' }}">
                        <span>DK</span> Dayak
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- === WADAH / MODAL POPUP (DRAWER) FAVORIT DENGAN ID === -->
    <div id="favoritesDrawer" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex justify-end hidden">
        
        <div class="w-full max-w-sm bg-white h-full shadow-2xl flex flex-col p-5">
            
            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                    <span class="text-amber-500">⭐</span> Daftar Favorit Saya
                </h3>
                <button type="button" onclick="toggleFavoritesDrawer()" class="text-gray-400 hover:text-gray-600 text-lg font-bold p-1 cursor-pointer">
                    ✕
                </button>
            </div>

            <!-- Konten Daftar Favorit -->
            <div id="favorites-container" class="flex-1 overflow-y-auto py-4 space-y-3">
                <p class="text-xs text-gray-400 text-center py-10 italic">
                    Belum ada konten yang ditandai sebagai favorit.
                </p>
            </div>

            <div class="pt-3 border-t border-gray-100 text-center">
                <p class="text-[10px] text-gray-400">Penyimpanan tersimpan otomatis di perangkat Anda.</p>
            </div>
        </div>
    </div>

</div>

<!-- Input Pencarian -->
<div class="px-5 py-3 mb-4">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
<input type="text" id="searchInput" onkeyup="searchContent()" placeholder="Cari informasi..."
    class="w-full pl-10 pr-4 py-2.5 text-xs bg-white dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none search-input-custom">

    </div>
</div>
<main class="flex-grow px-5 pt-6 pb-6 z-10 flex flex-col justify-start page-transition ">            
            <!-- GRID DAFTAR KATEGORI (Posisi pertama) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 md:gap-6 mb-8">
                
                @forelse($categories as $category)
                    @php
                        $categoryName = data_get($category, 'name');

                        $langMap = [
                            'id'    => 1,
                            'en'    => 2,
                            'dayak' => 3
                        ];
                        $targetLangId = $langMap[$currentLang] ?? 1;

                        if (data_get($category, 'translations')) {
                            $translation = $category->translations->first(function ($t) use ($targetLangId) {
                                return (int)$t->language_id === (int)$targetLangId;
                            });

                            if ($translation) {
                                $categoryName = $translation->name;
                            }
                        }
                    @endphp

<!-- Tambahkan 'relative' di bagian class -->
<a href="{{ route('guest.content', ['slug' => data_get($category, 'slug'), 'lang' => $currentLang]) }}" 
   class="searchable-item relative bg-white border border-slate-100 rounded-2xl p-5 md:p-6 flex flex-col items-center text-center shadow-xs hover:shadow-md md:hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all duration-200 group card-animate">
   <!-- HAPUS SEMENTARA @auth dan @endauth -->
 
{{-- Badge NONAKTIF (Hanya dirender jika status 0) --}}
    @if(data_get($category, 'is_active') == 0)
        <div class="absolute top-2 left-2 z-20 flex items-center bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-lg pointer-events-none">
            <span class="w-2 h-2 bg-white rounded-full mr-1 animate-pulse"></span>
            NONAKTIF
        </div>
    @endif
    
    <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-amber-50 flex items-center justify-center text-gold mb-3.5 group-hover:bg-gold group-hover:text-white transition-colors duration-300 shadow-inner">
                            @if(!empty(data_get($category, 'icon')))
                                <i class="bi {{ data_get($category, 'icon') }} text-2xl md:text-3xl"></i>
                            @else
                                <i class="bi bi-grid-fill text-2xl md:text-3xl"></i>
                            @endif
                        </div>
                        
                        <span class="serif-title font-bold text-sm md:text-base tracking-wide text-slate-800 transition-colors duration-200 group-hover:text-amber-700">
                            {{ $categoryName }}
                            
                        </span>
                        <!-- Footer Tanggal Update untuk Kategori -->
                    </a>
                @empty
                    <div class="col-span-2 sm:col-span-3 md:col-span-4 text-center py-12 text-slate-400 text-xs md:text-sm">
                        Belum ada data kategori tersedia.
                    </div>
                @endforelse

            </div>

            <!-- 3. STICKY WHATSAPP SUPPORT WIDGET -->
            <!-- sticky bottom-4 membuat widget ini menempel di layar bawah (jarak 16px dari bawah) ketika di-scroll ke bawah -->
            <div class="sticky bottom-4 z-40 w-full mt-auto">
                <div class="w-full max-w-3xl mx-auto bg-white/95 backdrop-blur-md border border-slate-100 rounded-2xl p-5 md:p-6 shadow-lg flex flex-col items-center text-center">
                    <div class="text-gold text-2xl md:text-3xl mb-2.5">
                        <i class="bi bi-headset"></i>
                    </div>
                    
                    <h3 class="font-bold text-sm md:text-base text-slate-800 tracking-wide">
                        @if($currentLang == 'en')
                            Need Immediate Assistance?
                        @elseif($currentLang == 'dayak')
                            Perlu Dohop Lakas?
                        @else
                            Butuh Bantuan Segera?
                        @endif
                    </h3>
                    
                    <p class="text-[11px] md:text-xs text-slate-400 mt-1.5 mb-4 max-w-[260px] md:max-w-md leading-relaxed font-medium">
                        @if($currentLang == 'en')
                            Click the button below to speak directly with our receptionist team.
                        @elseif($currentLang == 'dayak')
                            Picit tombol hong penda toh uka bapander langsung dengen resepsionis ikei.
                        @else
                            Klik tombol di bawah ini untuk berbicara langsung dengan tim resepsionis kami.
                        @endif
                    </p>
                    
                    @php
                        $nomorWa = $settings['hotel_whatsapp'] ?? '628123456789';
                        $nomorWa = preg_replace('/[^0-9]/', '', $nomorWa);
                        
                        if (str_starts_with($nomorWa, '0')) {
                            $nomorWa = '62' . substr($nomorWa, 1);
                        } elseif (str_starts_with($nomorWa, '8')) {
                            $nomorWa = '62' . $nomorWa;
                        }
                    @endphp

                    <a href="https://wa.me/{{ $nomorWa }}" target="_blank" 
                       class="w-full bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-xl py-2.5 md:py-3 px-4 flex items-center justify-center gap-2 text-xs md:text-sm font-semibold shadow-md active:scale-[0.98] transition-all duration-200">
                        <i class="bi bi-whatsapp text-base md:text-lg"></i>
                        <span>
                            @if($currentLang == 'en')
                                Contact Receptionist
                            @elseif($currentLang == 'dayak')
                                Bapander dengen Resepsionis
                            @else
                                Hubungi Resepsionis
                            @endif
                        </span>
                    </a>
                </div>
            </div>
            
            <!-- Footer dengan Jarak Normal dan Rapih -->
            <div class="pt-8 pb-2 text-center">
                <p class="text-[9px] md:text-[10px] text-slate-400 tracking-widest font-medium uppercase">
                    &copy; {{ date('Y') }} M Bahalap Hotel. All rights reserved.
                </p>
            </div>
        </main>
    </div>

    <!-- JAVASCRIPT DROPDOWN BAHASA -->
    <script>
// 1. FUNGSI FAVORIT
    function toggleFavorite(button) {
        const id = button.getAttribute('data-id');
        const slug = button.getAttribute('data-slug');
        const title = button.getAttribute('data-title');
        const url = button.getAttribute('data-url');

        let favorites = JSON.parse(localStorage.getItem('hotel_favorites')) || [];
        const index = favorites.findIndex(fav => fav.id === id || fav.slug === slug);

        if (index > -1) {
            favorites.splice(index, 1);
            button.classList.remove('text-amber-500', 'bg-amber-50', 'border-amber-200');
            button.querySelector('svg').setAttribute('fill', 'none');
        } else {
            favorites.push({ id, slug, title, url });
            button.classList.add('text-amber-500', 'bg-amber-50', 'border-amber-200');
            button.querySelector('svg').setAttribute('fill', 'currentColor');
        }

        localStorage.setItem('hotel_favorites', JSON.stringify(favorites));
        loadFavoritesToDrawer();
        updateButtonStates();
    }

    function toggleFavoritesDrawer() {
        const drawer = document.getElementById('favoritesDrawer');
        if (drawer) {
            drawer.classList.toggle('hidden');
            if (!drawer.classList.contains('hidden')) {
                loadFavoritesToDrawer();
            }
        }
    }

    function loadFavoritesToDrawer() {
        const container = document.getElementById('favorites-container');
        if (!container) return;

        let favorites = JSON.parse(localStorage.getItem('hotel_favorites')) || [];

        if (favorites.length === 0) {
            container.innerHTML = `
                <p class="text-xs text-gray-400 text-center py-10 italic">
                    Belum ada konten yang ditandai sebagai favorit.
                </p>`;
            return;
        }

        let html = '';
favorites.forEach(fav => {
    html += `
        <div class="flex items-center justify-between p-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm transition">
            <!-- TAMBAHKAN ?open=${fav.id} DI SINI -->
            <a href="${fav.url}?open=${fav.id}" class="text-sm font-medium text-slate-800 dark:text-slate-100 hover:text-amber-500 truncate">
                ${fav.title}
            </a>
            <button onclick="removeFavorite('${fav.id}')" class="text-slate-400 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 p-1">
                &times;
            </button>
        </div>
    `;
});
container.innerHTML = html;
    }

function removeFavorite(id) {
    let favorites = JSON.parse(localStorage.getItem('hotel_favorites')) || [];
    favorites = favorites.filter(fav => fav.id !== id);
    localStorage.setItem('hotel_favorites', JSON.stringify(favorites));
    
    loadFavoritesToDrawer();
    updateButtonStates();
}
    function updateButtonStates() {
        const buttons = document.querySelectorAll('.favorite-btn');
        let favorites = JSON.parse(localStorage.getItem('hotel_favorites')) || [];

        buttons.forEach(button => {
            const id = button.getAttribute('data-id');
            const isFav = favorites.some(fav => fav.id === id);

            if (isFav) {
                button.classList.add('text-amber-500', 'bg-amber-50', 'border-amber-200');
                button.querySelector('svg').setAttribute('fill', 'currentColor');
            } else {
                button.classList.remove('text-amber-500', 'bg-amber-50', 'border-amber-200');
                button.querySelector('svg').setAttribute('fill', 'none');
            }
        });
    }

    // 2. FUNGSI DROPDOWN BAHASA & PANAH
    function toggleLangDropdown(event) {
        event.stopPropagation();
        const box = document.getElementById('boxDropdownLang');
        const arrow = document.getElementById('arrowDropdownLang');
        
        if (box) {
            box.classList.toggle('hidden');
            if (arrow) {
                if (box.classList.contains('hidden')) {
                    arrow.style.transform = 'rotate(0deg)';
                } else {
                    arrow.style.transform = 'rotate(180deg)';
                }
            }
        }
    }

    // 3. FUNGSI TOGGLE THEME (MODE MALAM / TERANG)
function toggleTheme() {
        const htmlTag = document.documentElement;
        const themeIcon = document.getElementById("theme-icon");

        if (htmlTag.classList.contains("dark")) {
            htmlTag.classList.remove("dark");
            localStorage.setItem("theme", "light");
            if (themeIcon) themeIcon.textContent = "☀️"; // Jadi terang, ikon jadi matahari
        } else {
            htmlTag.classList.add("dark");
            localStorage.setItem("theme", "dark");
            if (themeIcon) themeIcon.textContent = "🌙"; // Jadi gelap, ikon jadi bulan
        }
    }
document.addEventListener("DOMContentLoaded", function () {
        loadFavoritesToDrawer();
        updateButtonStates();

        const savedTheme = localStorage.getItem("theme");
        const htmlTag = document.documentElement;
        const themeIcon = document.getElementById("theme-icon");

        if (savedTheme === "dark") {
            htmlTag.classList.add("dark");
            if (themeIcon) themeIcon.textContent = "🌙"; // Mode gelap tampilkan bulan
        } else {
            htmlTag.classList.remove("dark");
            if (themeIcon) themeIcon.textContent = "☀️"; // Mode terang tampilkan matahari
        }
    });
    
    // 5. GLOBAL CLICK UNTUK MENUTUP DROPDOWN KETIKA KLIK DI LUAR
    window.addEventListener('click', function(event) {
        const box = document.getElementById('boxDropdownLang');
        const btn = document.getElementById('btnDropdownLang');
        const arrow = document.getElementById('arrowDropdownLang');
        
        if (box && btn && !btn.contains(event.target) && !box.contains(event.target)) {
            box.classList.add('hidden');
            if (arrow) {
                arrow.style.transform = 'rotate(0deg)';
            }
        }
    });
function searchContent() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let items = document.querySelectorAll('.searchable-item');

    items.forEach(item => {
        let text = item.textContent.toLowerCase();
        if (text.includes(input)) {
            item.style.display = ""; // Tampilkan jika cocok
        } else {
            item.style.display = "none"; // Sembunyikan jika tidak cocok
        }
    });
}
    
            </script>
</body>
</html>