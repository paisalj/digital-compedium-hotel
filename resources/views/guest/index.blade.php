@php
    // 1. Cek apakah ada pilihan bahasa dari URL (?lang=...) atau dari Session aktif
    $currentLang = request('lang', session('lang'));

    // 2. Jika baru pertama kali scan QR (URL dan Session masih kosong)
    if (!$currentLang) {
        $browserLang = request()->server('HTTP_ACCEPT_LANGUAGE');
        
        // Deteksi jika perangkat/HP tamu menggunakan setelan bahasa Indonesia
        if ($browserLang && str_contains(strtolower($browserLang), 'id')) {
            $currentLang = 'id';
        } else {
            $currentLang = 'en'; // Standar bintang 5 jika tamu luar negeri/asing
        }
        
        // Simpan ke session agar pilihan bahasanya mengunci ke halaman berikutnya
        session(['lang' => $currentLang]);
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $settings['hotel_name'] ?? 'M Bahalap Hotel' }}</title>
    
    <!-- Google Fonts Kustom dari PHP Native -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Laravel Vite Asset Loading (Untuk Tailwind & Asset project) -->
    @vite('resources/css/app.css')

    <style>
        /* FIX STRUKTUR PAS 1 LAYAR PENUH (ANTI-SCROLL - LOCKED) */
        * { margin:0; padding:0; box-sizing:border-box; -webkit-tap-highlight-color:transparent; }
        html, body { 
            width:100%; 
            height: 100vh;
            height: 100dvh;
            overflow: hidden !important; /* Mengunci halaman agar tidak bisa digeser bawah/atas */
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: linear-gradient(rgba(230, 255, 255, 0.82), rgba(230, 255, 255, 0.82)), 
                              url('{{ isset($settings['hotel_background']) && $settings['hotel_background'] ? asset("storage/" . $settings['hotel_background']) : asset("assets/img/default_bg.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            user-select: none; 
            -webkit-user-select: none; 
            cursor: default; 
            position: relative;
        }

        /* Background Pattern Bintik Halus */
        .bg-pattern { position:absolute; inset:0; background: radial-gradient(circle at center, rgba(0,0,0,0.02) 1px, transparent 1px); background-size:100px 100px; opacity:0.5; z-index:1; }

        /* STRUKTUR WIDGET CONTAINER SATU LAYAR */
        #main-content {
            position: relative;
            z-index: 10;
            height: 100vh;
            height: 100dvh;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            padding: 20px 16px 36px 16px; 
        }

        .main-wrapper {
            text-align: center;
            width: 100%;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            display: flex !important;
            flex-direction: column !important;
            height: 100%;
            justify-content: space-between !important;
        }

        .top-group {
            width: 100%;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }

        /* Ukuran Logo Diperkecil Biar Space Longgar */
        .logo-container {
            display: flex;
            justify-content: center;
            margin-top: 16px;
            margin-bottom: 12px;
        }
        .logo-container img {
            width: 80px !important;
            height: 80px !important;
            object-fit: cover;
            border-radius: 9999px !important;
            border: 2px solid rgba(245, 158, 11, 0.8);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        /* WADAH TEKS SAMBUTAN */
        .luxury-card {
            margin-top: 60px; 
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }
        .luxury-card-inner {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 10px 16px !important; 
        }

        /* UKURAN FONT DI HP */
        .hotel-title { 
            font-family: 'Cinzel', serif; 
            color: #b78b2d; 
            letter-spacing: 1px; 
            line-height: 1.2 !important;
            font-size: 23px !important; 
            text-transform: uppercase;
            font-weight: 700;
        }  
        .hotel-title * { font-size: 23px !important; line-height: 1.2 !important; margin: 0 !important; color: #b78b2d !important; font-weight: 700 !important; }

        .dynamic-sambutan, .dynamic-sambutan * {
            font-size: 19px !important; 
            line-height: 1.3 !important;
            font-weight: 700 !important;
            color: #111827 !important; 
            font-style: normal !important;
            text-shadow: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dynamic-deskripsi, .dynamic-deskripsi * {
            font-size: 15px !important; 
            line-height: 1.7 !important;
            font-weight: 500 !important;
            color: #374151 !important; 
            font-style: normal !important; 
            text-shadow: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .dynamic-location, .dynamic-location * {
            font-size: 11px !important; 
            line-height: 1.2 !important;
            letter-spacing: 3.5px !important;
            margin-top: 4px !important;
            font-weight: 600;
            color: #c59a36 !important;
        }

        /* RESPONSIVITAS LAYAR TABLET / IPAD */
        @media (min-width: 640px) and (max-width: 1023px) {
            #main-content { padding-top: 40px; }
            .logo-container img { width: 100px !important; height: 100px !important; }
            .luxury-card { max-width: 580px; margin-top: 50px; }
            
            .hotel-title, .hotel-title * { font-size: 32px !important; }
            .dynamic-location, .dynamic-location * { font-size: 13px !important; letter-spacing: 4px !important; }
            .dynamic-sambutan, .dynamic-sambutan * { font-size: 22px !important; }
            .dynamic-deskripsi, .dynamic-deskripsi * { font-size: 17px !important; }
        }

        /* RESPONSIVITAS LAYAR LAPTOP / PC BESAR */
        @media (min-width: 1024px) {
            #main-content { padding-top: 50px; }
            .logo-container img { width: 115px !important; height: 115px !important; }
            .luxury-card { max-width: 640px; margin-top: 60px; }
            
            .hotel-title, .hotel-title * { font-size: 40px !important; }
            .dynamic-location, .dynamic-location * { font-size: 14px !important; letter-spacing: 5px !important; }
            .dynamic-sambutan, .dynamic-sambutan * { font-size: 24px !important; }
            .dynamic-deskripsi, .dynamic-deskripsi * { font-size: 18px !important; }
        }

        .gold { color: #c59a36; text-transform: uppercase; }
        
        /* Tombol Utama (Digital Compendium) */
        .btn-gold-wrapper {
            width: 100%;
            margin-top: auto; 
            margin-bottom: 24px;
            display: flex;
            justify-content: center;
        }
        .btn-gold { 
            background: #c59a36 !important; 
            color: white !important; 
            transition: 0.3s ease; 
            display: inline-flex !important; 
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 30px !important;
            border-radius: 9999px !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 13.5px !important;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(197,154,54,0.2);
        }
        .btn-gold:hover { background: #a97f26 !important; transform: translateY(-1px); }

        /* Animasi */
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { opacity: 0; animation: fadeInUp 0.6s ease-out forwards; }
        .delay-100 { animation-delay: 0.05s; }
        .delay-200 { animation-delay: 0.15s; }
        .delay-300 { animation-delay: 0.25s; }
        .delay-400 { animation-delay: 0.35s; }

        /* Tombol Bahasa */
        .btn-bahasa {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 2px;
            border-radius: 9999px;
            border: 1px solid rgba(229, 231, 235, 0.8);
            background-color: rgba(255, 255, 255, 0.95);
            padding: 5px 12px;
            font-size: 11px;
            font-weight: 700;
            color: #374151;
            cursor: pointer;
        }
        
        .stars-container {
            display: flex;
            justify-content: center;
            gap: 2px;
            margin-top: 2px;
            color: #f59e0b;
            font-size: 10px;
        }
        
        footer {
            position: absolute;
            bottom: 8px; 
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            z-index: 20;
        }
    </style>
</head>
<body> 
    <div class="bg-pattern"></div>

    <!-- 🌐 DROPDOWN BAHASA -->
    <div style="position: absolute; top: 14px; right: 14px; z-index: 50; display: inline-block;" class="animate-fade-in">
        <button type="button" id="btnDropdownLang" onclick="toggleLangDropdown(event)" 
                class="btn-bahasa" 
                style="padding: 8px 16px; font-size: 13px; gap: 8px; border-radius: 9999px;">
            
            <span style="font-size: 16px;">🌐</span> 
            
            <!-- Menggunakan Variabel Pintar $currentLang -->
            <span style="font-weight: 700;">{{ strtoupper($currentLang == 'dayak' ? 'DK' : $currentLang) }}</span>
            
            <svg style="width: 12px; height: 12px; color: #6b7280;" id="arrowDropdownLang" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <!-- Dropdown List Pilihan Bahasa -->
        <div id="boxDropdownLang" class="hidden" 
             style="position: absolute; right: 0; margin-top: 8px; width: 140px; border-radius: 10px; background-color: white; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.15); overflow: hidden;">
            <div style="padding: 4px 6px 0;">
                <a href="?lang=id" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 13px; color: #374151; text-decoration: none; font-weight: 600; {{ $currentLang == 'id' ? 'background-color: #fef3c7; color: #c59a36;' : '' }}">
                    <span>🇮🇩</span> Indonesia
                </a>
                <a href="?lang=en" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 13px; color: #374151; text-decoration: none; font-weight: 600; {{ $currentLang == 'en' ? 'background-color: #fef3c7; color: #c59a36;' : '' }}">
                    <span>🇬🇧</span> English
                </a>
                <a href="?lang=dayak" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 13px; color: #374151; text-decoration: none; font-weight: 600; {{ $currentLang == 'dayak' ? 'background-color: #fef3c7; color: #c59a36;' : '' }}">
                    <span>🛡️</span> Dayak
                </a>
            </div>
        </div>
    </div>

    <!-- 👑 MAIN CONTENT SECTION -->
    <section id="main-content">
        <div class="main-wrapper">
            
            <!-- 🔼 KELOMPOK ATAS -->
            <div class="top-group">
                
                <!-- Logo Bulat -->
                <div class="logo-container animate-fade-in delay-100">
                    <img src="{{ isset($settings['hotel_logo']) && $settings['hotel_logo'] ? asset('storage/' . $settings['hotel_logo']) : asset('assets/img/logo.jpeg') }}" alt="Logo Hotel">
                </div>

                <!-- NAMA HOTEL & BINTANG -->
                <div class="animate-fade-in delay-200" style="width: 100%;">
                    <div class="hotel-title">
                        {!! $settings['hotel_name'] ?? 'M BAHALAP HOTEL' !!}
                    </div>
                    <div class="gold dynamic-location">
                        {!! $settings['hotel_city'] ?? 'PALANGKARAYA' !!}
                    </div> 
                    <div class="stars-container">★★★★★</div>
                </div>

                <!-- KARTU SAMBUTAN (Dilengkapi Fallback Terjemahan Dinamis Bintang 5) -->
                <div class="luxury-card animate-fade-in delay-300">
                    <div class="luxury-card-inner">
                        <div class="dynamic-sambutan">
                            {!! $settings['hotel_welcome_title'] ?? ($currentLang == 'en' ? 'Welcome to M Bahalap Hotel Palangka Raya' : 'Selamat Datang di M Bahalap Hotel Palangka Raya') !!}
                        </div>
                        <div style="width: 50px; height: 2.0px; background-color: #c59a36; margin: 10px auto; border-radius: 9999px;"></div>
                        <div class="dynamic-deskripsi">
                            {!! $settings['hotel_description'] ?? ($currentLang == 'en' ? 'It is a distinct honor to welcome you here, and we hope you have a highly pleasant and memorable stay.' : 'Merupakan suatu kehormatan bagi kami menerima Anda di sini dan kami berharap Anda mendapatkan pengalaman menginap yang sangat menyenangkan.') !!}
                        </div>
                    </div>
                </div>

            </div>

            <!-- 🔽 KELOMPOK BAWAH -->
            <div class="btn-gold-wrapper animate-fade-in delay-400">
                <!-- Parameter Bahasa Ikut Dikirim ke Halaman Category -->
                <a href="{{ route('guest.category', ['lang' => $currentLang]) }}" class="btn-gold shadow-lg active:scale-95 transition-transform duration-150">
                    <span>Digital Compendium</span>
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

        </div>
    </section>

    <!-- 👣 FOOTER FIXED DI BAWAH LAYAR -->
    <footer class="animate-fade-in">
        <p style="font-size: 10px; color: #4b5563; font-weight: 600; letter-spacing: 0.025em;">
            &copy; {{ date('Y') }} {{ strip_tags($settings['hotel_name'] ?? 'M BAHALAP HOTEL') }}. All rights reserved.
        </p>
    </footer>

    <!-- ⚡ UTILITY JAVASCRIPT DROPDOWN -->
    <script>
        function toggleLangDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('boxDropdownLang');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        }
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('boxDropdownLang');
            const button = document.getElementById('btnDropdownLang');
            if (dropdown && !button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>
</html>