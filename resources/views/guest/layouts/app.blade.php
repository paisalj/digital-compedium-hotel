<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Compendium - {{ $settings['hotel_name'] ?? 'M Bahalap Hotel' }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-slate-950 text-slate-100 font-sans min-h-screen flex flex-col">

    <!-- 🧭 TOP COMPENDIUM BAR -->
    <nav class="bg-slate-900/80 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center justify-between">
            
            <!-- Logo & Brand (Aksen Emas) -->
            <a href="{{ route('guest.home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center overflow-hidden">
                    <img src="{{ isset($settings['hotel_logo']) && $settings['hotel_logo'] ? asset('storage/' . $settings['hotel_logo']) : 'https://placehold.co/100?text=Logo' }}" 
                         class="w-full h-full object-cover" 
                         onerror="this.src='https://placehold.co/100?text=M'">
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-xs text-amber-400 tracking-wider uppercase leading-none">
                        {{ $settings['hotel_name'] ?? 'M Bahalap Hotel' }}
                    </span>
                    <span class="text-[9px] text-slate-400 tracking-widest mt-0.5">DIGITAL COMPENDIUM</span>
                </div>
            </a>

            <!-- Tombol Darurat / Hubungi Front Desk -->
            @php
                $waNumber = preg_replace('/[^0-9]/', '', $settings['hotel_whatsapp'] ?? '');
            @endphp
            <a href="https://wa.me/62{{ $waNumber }}?text=Halo%20Resepsionis%2C%20saya%20butuh%20bantuan%20di%20kamar." 
               target="_blank"
               class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-extrabold rounded-full transition flex items-center gap-1.5 shadow-lg shadow-amber-500/20">
                <i class="bi bi-telephone-fill"></i>
                Layanan Kamar
            </a>

        </div>
    </nav>

    <!-- 📥 MAIN COMPENDIUM CONTAINER (Didesain Pas untuk Ukuran Layar HP) -->
    <main class="flex-grow max-w-md mx-auto w-full px-4 py-6 bg-slate-950">
        @yield('content')
    </main>

    <!-- 👣 FOOTER SIMPLE -->
    <footer class="bg-slate-900 border-t border-slate-800/80 py-6 text-center text-xs text-slate-500 mt-auto">
        <div class="max-w-md mx-auto px-4 space-y-2">
            <p>&copy; {{ date('Y') }} {{ $settings['hotel_name'] ?? 'M Bahalap Hotel' }}</p>
            <p class="text-[10px] text-slate-600">Terima kasih telah memilih kami sebagai tempat menginap Anda.</p>
        </div>
    </footer>

</body>
</html>