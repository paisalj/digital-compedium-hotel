@php
    // Mengambil bahasa aktif saat ini dari URL atau Session
    $currentLang = request('lang', session('lang', 'en'));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Mengambil title dari database -->
    <title>{{ $content->title ?? $content['title'] ?? 'Detail - M Bahalap Hotel' }}</title>
    <link rel="icon" type="image/png" href="{{ isset($settings['hotel_logo']) && $settings['hotel_logo'] ? asset('storage/' . $settings['hotel_logo']) : asset('images/default-logo.png') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons (Tambahan agar ikon muncul) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Tailwind CSS (Vite) -->
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            background-image: linear-gradient(rgba(230, 255, 255, 0.82), rgba(230, 255, 255, 0.82)), 
                              url('{{ isset($settings["hotel_background"]) && $settings["hotel_background"] ? asset("storage/" . $settings["hotel_background"]) : asset("images/default-bg.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none;    /* IE 10 and IE 11 */
            user-select: none;        /* Standard syntax */
        }
        .luxury-title {
            font-family: 'Cinzel', serif;
            color: #b78b2d;
            letter-spacing: 1px;
        }
        .btn-back {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(229, 231, 235, 0.8);
            color: #374151;
            transition: all 0.2s ease;
        }
        .btn-back:active {
            transform: scale(0.95);
        }
        /* Custom scrollbar halus untuk konten panjang */
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
            border-radius: 4px;
        }
        /* Styling agar tabel di dalam konten terlihat rapi dan tidak polos */
        .custom-content-table table {
            width: auto; /* Agar tabel menyesuaikan isi konten */
            min-width: 100%; /* Tetap minimal selebar layar */
            border-collapse: collapse;
        }

        .custom-content-table th, .custom-content-table td {
            border: 1px solid #e5e7eb;
            padding: 10px 15px; /* Memberi ruang napas yang lebih lega */
            text-align: left;
            white-space: nowrap; /* KUNCI: Mencegah teks patah ke bawah */
        }

        .custom-content-table th {
            background-color: #f9fafb;
            font-weight: 600;
            font-size: 12px;
            color: #374151;
        }

        .custom-content-table td {
            font-size: 12px;
            color: #4b5563;
        }

        /* Memastikan gambar tetap rapi */
/* Memastikan gambar mengikuti ukuran dari dashboard & aman di HP */
        .custom-content-table img {
            max-width: 100%;    /* Batas maksimal: tidak akan keluar/jebol dari lebar layar HP */
            width: auto;        /* Mengikuti ukuran width yang kamu setel di dashboard */
            height: auto;       /* Menjaga proporsi gambar agar tidak gepeng */
            border-radius: 6px;
            display: block;
            margin: 10px auto;  /* Posisi gambar otomatis berada di tengah */
        }
        
        .custom-content-table p {
            margin-bottom: 1rem !important;
        }
        
        /* Menebalkan sedikit sub-judul jika ada di dalam teks */
        .custom-content-table strong {
            color: #374151; 
        }
        .custom-content-table ul {
            list-style-type: disc !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1rem !important;
        }

        /* Memberi jarak pada item list agar tidak rapat */
        .custom-content-table li {
            list-style-type: disc !important;
            margin-bottom: 0.5rem !important;
            padding-left: 0.5rem !important;
        }

        /* Jika ada list bernomor (ordered list) */
        .custom-content-table ol {
            list-style-type: decimal !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1rem !important;
        }

        /*  */
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

    #stickyCategoryTitle {
        color: #111827 !important;
    }

    /* Mode Gelap: Teks judul kategori otomatis jadi terang */
    .dark #stickyCategoryTitle {
        color: #f3f4f6 !important;
    }
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

    .page-transition {
        animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .card-animate {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .card-animate:nth-child(1) { animation-delay: 0.05s; }
    .card-animate:nth-child(2) { animation-delay: 0.1s; }
    .card-animate:nth-child(3) { animation-delay: 0.15s; }
    .card-animate:nth-child(4) { animation-delay: 0.2s; }
    .card-animate:nth-child(n+5) { animation-delay: 0.25s; }
</style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased">

    <!-- WRAPPER UTAMA -->
<div class="min-h-screen w-full mx-auto shadow-2xl relative flex flex-col bg-transparent">        
        <div class="bg-pattern"></div>

        <div class="sticky top-0 z-50 w-full bg-white border-b border-slate-100 shadow-xs" style="background-color: white; border-bottom: 1px solid #f1f5f9; padding: 0 20px; height: 56px; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box;">
            
            <a href="{{ url('/category/' . $category->slug . '?lang=' . $currentLang) }}" class="hover:opacity-80 active:scale-95 transition-all" style="display: flex; align-items: center; gap: 4px; text-decoration: none; color: #c59a36; font-size: 14px; font-weight: 600;">
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

<!-- Bagian Kanan: Tombol Dark Mode & Dropdown Bahasa -->
<div style="position: relative; z-index: 50; display: flex; align-items: center; gap: 4px;">
    
<!-- 🌙 TOMBOL GANTI MODE (Border ditebalkan jadi 2px) -->
    <button id="theme-toggle" onclick="toggleDarkMode()" type="button" 
            style="width: 30px; height: 30px; border-radius: 9999px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; padding: 0; background: #ffffff; border: 2px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05); flex-shrink: 0;">
        
        <!-- Ikon Matahari (Mode Siang) -->
        <svg id="theme-toggle-light-icon" class="hidden" style="width: 15px; height: 15px; color: #f59e0b;" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>
        
        <!-- Ikon Bulan (Mode Malam) -->
        <svg id="theme-toggle-dark-icon" class="hidden" style="width: 15px; height: 15px; color: #fbbf24; transform: scaleX(-1);" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>

    </button>
    
    <!-- Dropdown Bahasa Container -->
    <div style="position: relative; display: flex; align-items: center;">
        <button type="button" id="btnDropdownLang" onclick="toggleLangDropdown(event)" 
                class="btn-bahasa" 
                style="padding: 0 10px; height: 30px; font-size: 12px; border-radius: 9999px; display: flex; align-items: center; justify-content: center; gap: 4px; background: white; border: 1px solid #e5e7eb; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05); font-weight: 700; color: #374151; box-sizing: border-box;">
            <span style="font-size: 14px; display: flex; align-items: center;">🌐</span> 
            <span style="display: flex; align-items: center; line-height: 1;">{{ strtoupper($currentLang == 'dayak' ? 'DK' : $currentLang) }}</span>
            <svg style="width: 10px; height: 10px; color: #6b7280; transition: transform 0.2s; display: flex; align-items: center;" id="arrowDropdownLang" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

</div>
<main class="flex-grow px-5 pt-6 pb-6 z-10 flex flex-col justify-start page-transition">
            <h1 id="mainCategoryTitle" class="luxury-title text-2xl font-bold text-center border-b border-amber-200 pb-4">
            {{ $categoryName }}
        </h1>
        <div class="bg-white/50 rounded-2xl p-4 shadow-sm border border-gray-100">
            
            <div class="flex items-center gap-2 mb-5 text-amber-800 px-2">
                <span class="text-base">📁</span> 
                <h4 class="text-[11px] font-bold uppercase tracking-wider">
                    {{ $currentLang == 'en' ? 'Information' : 'Informasi' }}
                </h4>
            </div>

            <!-- WRAPPER KARTU-KARTU KECIL -->
            <div class="space-y-4">
                @if(isset($contents) && $contents->count() > 0)
                    @php
                        $langMap = ['id' => 1, 'en' => 2, 'dayak' => 3];
                        $targetLangId = $langMap[$currentLang] ?? 1;
                    @endphp

     @foreach($contents as $item)
    @php
        $translation = $item->translations->firstWhere('language_id', $targetLangId);
        // Pastikan baris ini ada di dalam blok @php
        $delay = $loop->index * 0.08; 
    @endphp

    @if($translation)
    
<!-- KARTU KECIL (INDIVIDU) -->
<!-- 1. Tambahkan 'relative' di sini agar badge absolute menempel dengan benar -->
<div class="relative bg-white p-4 rounded-xl border border-gray-100 shadow-sm {{ data_get($item, 'is_active') == 0 ? 'opacity-60 grayscale' : '' }} card-animate" style="animation-delay: {{ $delay }}s;">
    <!-- 2. Tambahkan 'pr-16' pada h3 agar teks tidak menabrak badge di kanan -->
    <h3 class="text-[14px] font-bold text-gray-800 mb-2 flex items-center gap-2 pr-16">
                <!-- ICON DITAMPILKAN DI SINI -->
        @if($item->icon)
            @if(filter_var($item->icon, FILTER_VALIDATE_URL))
                <img src="{{ $item->icon }}" alt="icon" class="w-4 h-4 object-contain">
            @elseif(str_contains($item->icon, 'bi-'))
                <i class="{{ $item->icon }} text-amber-600 text-[16px]"></i>
            @else
                <img src="{{ asset('storage/' . $item->icon) }}" alt="icon" class="w-4 h-4 object-contain">
            @endif
        @else
            <span class="text-[10px] text-amber-600">▶</span>
        @endif
        {{ $translation->title }}

<!-- TOMBOL BOOKMARK -->
<button type="button" 
        onclick="toggleFavorite(this)" 
        data-id="{{ $item->id }}" 
        data-slug="{{ $translation->slug ?? '' }}"
        data-title="{{ $translation->title ?? '' }}" 
        data-url="{{ url()->current() }}"
        class="favorite-btn absolute top-4 right-4 p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-400 hover:text-amber-500 transition-all cursor-pointer shadow-xs z-10">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
    </svg>
</button>

</h3>
    
    <div class="text-[13px] text-gray-600 leading-relaxed custom-content-table overflow-x-auto pl-6">
        {!! $translation->body !!}
    </div>
<!-- Footer Tanggal & Jam Update (Ambil dari $translation) -->
<div class="mt-4 pt-3 border-t border-gray-50 text-[10px] text-gray-400 flex justify-end items-center gap-1 italic">

<div>
            @auth
                @if(data_get($item, 'is_active') == 0)
                    <div class="inline-flex items-center bg-red-600 text-white font-bold px-2 py-0.5 rounded shadow-xs">
                        <span class="w-1.5 h-1.5 bg-white rounded-full mr-1 animate-pulse"></span>
                        NONAKTIF
                    </div>
                @endif
            @endauth
        </div>
    <!-- Logika: Jika updated_at hampir sama dengan created_at (selisih < 5 menit), berarti data asli -->
    @if($translation->updated_at->diffInMinutes($translation->created_at) < 5)
        <span>Dibuat:</span>
        <span class="font-medium text-gray-500">
            {{ $translation->created_at->translatedFormat('d F Y, H:i') }}
        </span>
    @else
        <!-- Jika sudah pernah diupdate -->
        <span>Diperbarui:</span>
        <span class="font-medium text-gray-500">
            {{ $translation->updated_at->translatedFormat('d F Y, H:i') }}
        </span>
    @endif
</div>


</div>
                        @endif
                    @endforeach
                @else
                    <div class="text-center py-10 text-gray-400">
                        <p class="text-sm">Konten belum tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
        </main>

        <footer class="py-4 text-center border-t border-gray-100 bg-white">
            <p class="text-[9px] text-gray-400 font-semibold uppercase tracking-wider">
                &copy; {{ date('Y') }} M Bahalap Hotel. All rights reserved.
            </p>
        </footer>

        <!-- Tombol Navigasi Sticky (Awalnya tersembunyi dengan opacity-0) -->
        <div id="navButtons" class="fixed bottom-5 left-0 w-full px-5 flex justify-between items-center z-50 transition-opacity duration-500 opacity-0 pointer-events-none">
            
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
        class="fixed bottom-6 right-6 z-50 w-11 h-11 bg-gray-800 text-white rounded-full shadow-lg hover:bg-gray-900 flex items-center justify-center transition-all duration-300 hover:-translate-y-1 active:scale-90 group">
    <i class="bi bi-arrow-up text-base group-hover:scale-110 transition-transform duration-200"></i>
</button>
        </div>

    </div>

    <!-- ⚡ SCRIPTS -->
<!-- ⚡ SCRIPTS -->
    <script>
        // 1. Script Copy to Clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard: ' + text);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        // 2. Script Dropdown Bahasa (Gunakan satu versi yang lengkap dengan animasi panah)
        function toggleLangDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('boxDropdownLang');
            const arrow = document.getElementById('arrowDropdownLang');
            
            dropdown.classList.toggle('hidden');
            
            if(dropdown.classList.contains('hidden')) {
                arrow.style.transform = 'rotate(0deg)';
            } else {
                arrow.style.transform = 'rotate(180deg)';
            }
        }

        // Menutup dropdown jika user klik area kosong di luar tombol
        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('boxDropdownLang');
            const arrow = document.getElementById('arrowDropdownLang');
            
            if (!event.target.closest('#btnDropdownLang') && dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                if(arrow) arrow.style.transform = 'rotate(0deg)';
            }
        });
        
        // Listener Scroll untuk Tombol Navigasi & Sticky Title
        window.addEventListener('scroll', function() {
            const navButtons = document.getElementById('navButtons');
            const mainTitle = document.getElementById('mainCategoryTitle');
            const stickyTitle = document.getElementById('stickyCategoryTitle');
            
            if (window.scrollY > 9) {
                navButtons.classList.remove('opacity-0', 'pointer-events-none');
                navButtons.classList.add('opacity-100');
            } else {
                navButtons.classList.add('opacity-0', 'pointer-events-none');
                navButtons.classList.remove('opacity-100');
            }

            if (mainTitle && stickyTitle) {
                if (window.scrollY > (mainTitle.offsetTop + mainTitle.offsetHeight)) {
                    stickyTitle.style.opacity = "1";
                } else {
                    stickyTitle.style.opacity = "0";
                }
            }
        });

function toggleFavorite(button) {
    const id = button.getAttribute('data-id');
    const slug = button.getAttribute('data-slug');
    const title = button.getAttribute('data-title');
    const url = button.getAttribute('data-url');

    // 1. Eksekusi LocalStorage & UI dulu agar tombol langsung responsif saat diklik
    let favorites = JSON.parse(localStorage.getItem('hotel_favorites')) || [];
    const index = favorites.findIndex(fav => fav.id == id || fav.slug === slug);

    if (index > -1) {
        favorites.splice(index, 1);
        button.classList.remove('text-amber-500', 'bg-amber-50', 'border-amber-200');
        if (button.querySelector('svg')) {
            button.querySelector('svg').setAttribute('fill', 'none');
        }
    } else {
        favorites.push({ id, slug, title, url });
        button.classList.add('text-amber-500', 'bg-amber-50', 'border-amber-200');
        if (button.querySelector('svg')) {
            button.querySelector('svg').setAttribute('fill', 'currentColor');
        }
    }

    localStorage.setItem('hotel_favorites', JSON.stringify(favorites));
    
    // Cek apakah fungsi drawer ada sebelum dipanggil agar tidak error
    if (typeof loadFavoritesToDrawer === 'function') {
        loadFavoritesToDrawer();
    }

// Kirim data ke database MySQL
    fetch('/guest/favorite/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ content_id: parseInt(id) }) // <-- Ubah id menjadi integer dengan parseInt()
    })
    .then(response => response.json())
    .then(data => {
        // Berhasil
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


// 4. Fungsi untuk Memuat Daftar ke Wadah (Drawer)
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
                    <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-xl hover:bg-amber-50/50 transition">
                        <a href="${fav.url}" class="text-xs font-semibold text-gray-700 hover:text-amber-600 line-clamp-1 flex-1">
                            ${fav.title}
                        </a>
                        <button onclick="removeFavorite('${fav.id}')" class="text-gray-300 hover:text-red-500 p-1 ml-2 text-xs font-bold cursor-pointer">
                            ✕
                        </button>
                    </div>`;
            });
            container.innerHTML = html;
        }

        // 5. Fungsi Hapus Item dari Drawer
        function removeFavorite(id) {
            let favorites = JSON.parse(localStorage.getItem('hotel_favorites')) || [];
            favorites = favorites.filter(fav => fav.id !== id);
            localStorage.setItem('hotel_favorites', JSON.stringify(favorites));

            loadFavoritesToDrawer();
            updateButtonStates();
        }

        // 6. Menyesuaikan Status Tombol
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

        // 7. Dark Mode Logic
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                updateThemeIcons('light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                updateThemeIcons('dark');
            }
        }

        function updateThemeIcons(theme) {
            const lightIcon = document.getElementById('theme-toggle-light-icon');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            
            if (!lightIcon || !darkIcon) return;

            if (theme === 'dark') {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            } else {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            }
        }

        // 8. Drawer Toggle untuk Favorit
        function toggleFavoritesDrawer() {
            const drawer = document.getElementById('favoritesDrawer');
            if (drawer) {
                drawer.classList.toggle('hidden');
            }
        }

        // Inisialisasi Saat Halaman Dimuat (Hanya 1 blok DOMContentLoaded yang bersih)
        document.addEventListener("DOMContentLoaded", function () {
            const currentTheme = localStorage.getItem('theme') || (document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            if (currentTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            updateThemeIcons(currentTheme);

            loadFavoritesToDrawer();
            updateButtonStates();
        });
    </script>
    
</body>
</html>