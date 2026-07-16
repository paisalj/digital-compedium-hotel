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
    </style>
</head>
<body class="antialiased text-slate-800">

    <!-- CONTAINER UTAMA (RESPONSIVE WRAPPER - LOCKED) -->
    <div class="min-h-screen w-full max-w-md md:max-w-3xl lg:max-w-5xl mx-auto shadow-2xl relative flex flex-col justify-between overflow-x-hidden bg-transparent">
        
        <!-- Efek Pattern Bintik Halus dari Halaman Utama -->
        <div class="bg-pattern"></div>

        <!-- 1. TOP BAR PUTIH ELEGAN -->
        <div class="w-full bg-white border-b border-slate-100 shadow-xs" style="background-color: white; border-bottom: 1px solid #f1f5f9; padding: 0 20px; height: 56px; display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 20; box-sizing: border-box;">
            
            <!-- Tombol Kembali (Bahasanya Dikunci & Mengoper Parameter ke Halaman Utama) -->
            <a href="{{ url('/?lang=' . $currentLang) }}" class="flex items-center gap-1.5 text-gold font-semibold text-sm hover:opacity-80 active:scale-95 transition-all" style="display: flex; align-items: center; gap: 6px; text-decoration: none; color: #c59a36; font-size: 14px; font-weight: 600;">
                <i class="bi bi-chevron-left" style="-webkit-text-stroke: 0.5px; font-size: 12px;"></i>
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

            <!-- Dropdown Bahasa Container -->
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
                            <span>🇮🇩</span> Indonesia
                        </a>
                        <a href="?lang=en" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 13px; color: #374151; text-decoration: none; font-weight: 600; {{ $currentLang == 'en' ? 'background-color: #fef3c7; color: #c59a36; font-weight: bold;' : '' }}">
                            <span>🇬🇧</span> English
                        </a>
                        <a href="?lang=dayak" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; font-size: 13px; color: #374151; text-decoration: none; font-weight: 600; {{ $currentLang == 'dayak' ? 'background-color: #fef3c7; color: #c59a36; font-weight: bold;' : '' }}">
                            <span>🛡️</span> Dayak
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. MAIN CONTENT AREA (Kategori Dinamis Terhubung Akurat ke DB - LOCKED) -->
        <main class="flex-grow px-5 pt-6 pb-6 relative z-10 flex flex-col justify-start">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 md:gap-6">
                
                @forelse($categories as $category)
                    @php
                        $categoryName = $category->name;

                        $langMap = [
                            'id'    => 1,
                            'en'    => 2,
                            'dayak' => 3
                        ];
                        $targetLangId = $langMap[$currentLang] ?? 1;

                        if ($category->translations) {
                            $translation = $category->translations->first(function ($t) use ($targetLangId) {
                                return (int)$t->language_id === (int)$targetLangId;
                            });

                            if ($translation) {
                                $categoryName = $translation->name;
                            }
                        }
                    @endphp

                    <!-- Card Kategori Menuju Konten (Mengoper Bahasa ke Halaman Konten Detail) -->
                    <a href="{{ url('/category/' . $category->id . '?lang=' . $currentLang) }}" class="bg-white border border-slate-100 rounded-2xl p-5 md:p-6 flex flex-col items-center text-center shadow-xs hover:shadow-md md:hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all duration-200 group">
                        
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-amber-50 flex items-center justify-center text-gold mb-3.5 group-hover:bg-gold group-hover:text-white transition-colors duration-300 shadow-inner">
                            @if(!empty($category->icon))
                                <i class="bi {{ $category->icon }} text-2xl md:text-3xl"></i>
                            @else
                                <i class="bi bi-grid-fill text-2xl md:text-3xl"></i>
                            @endif
                        </div>
                        
                        <span class="serif-title font-bold text-sm md:text-base tracking-wide text-slate-800 transition-colors duration-200 group-hover:text-amber-700">
                            {{ $categoryName }}
                        </span>
                    </a>
                @empty
                    <div class="col-span-2 sm:col-span-3 md:col-span-4 text-center py-12 text-slate-400 text-xs md:text-sm">
                        Belum ada data kategori tersedia.
                    </div>
                @endforelse

            </div>
        </main>

        <!-- 3. WHATSAPP SUPPORT WIDGET CARD (LOCKED) -->
        <div class="px-5 mb-6 relative z-10 w-full md:max-w-xl mx-auto">
            <div class="bg-white border border-slate-100 rounded-2xl p-5 md:p-6 flex flex-col items-center text-center shadow-xs">
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

        <!-- 4. FOOTER HAK CIPTA -->
        <footer class="py-4 text-center z-10">
            <p class="text-[9px] md:text-[10px] text-slate-400 tracking-widest font-medium uppercase">
                &copy; {{ date('Y') }} M Bahalap Hotel. All rights reserved.
            </p>
        </footer>

    </div>

    <!-- JAVASCRIPT DROPDOWN BAHASA -->
    <script>
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

        document.addEventListener('click', function(event) {
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
    </script>

</body>
</html>