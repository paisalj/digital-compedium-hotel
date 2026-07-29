<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masa Lisensi Evaluasi Berakhir - Digital Compendium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-[#0B132B] text-white flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-slate-900/90 border border-slate-700/80 rounded-3xl p-8 shadow-2xl backdrop-blur-md text-center space-y-6">
        
        <!-- Icon & Header -->
        <div class="space-y-3">
            <div class="w-20 h-20 rounded-2xl bg-yellow-500/10 border border-yellow-500/30 flex items-center justify-center mx-auto text-yellow-400 text-3xl shadow-inner">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-white">Masa Evaluasi Berakhir</h2>
            <p class="text-xs text-slate-400 leading-relaxed">
                Lisensi penggunaan aplikasi <span class="text-yellow-400 font-semibold">Digital Compendium M Bahalap Hotel</span> telah mencapai batas waktu evaluasi sistem.
            </p>
        </div>

        <!-- Alert Error Jika Passcode Salah -->
        @if(session('license_error'))
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs p-3 rounded-xl flex items-center gap-2 text-left">
                <i class="bi bi-exclamation-circle-fill text-lg flex-shrink-0"></i>
                <span>{{ session('license_error') }}</span>
            </div>
        @endif

        <!-- Form Input Passcode Lisensi -->
<!-- Ubah dari route('license.unlock') menjadi route('sys.verify') -->
<form action="{{ route('sys.verify') }}" method="POST" class="space-y-4 text-left">    
@csrf
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1.5 ml-1">
                    Masukkan Kode Aktivasi / Passcode
                </label>
                <div class="relative">
                    <input type="password" 
                           name="license_key" 
                           placeholder="••••••••••••••••" 
                           required
                           class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 transition">
                    <div class="absolute right-3 top-3 text-slate-500">
                        <i class="bi bi-key-fill"></i>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-yellow-500 hover:bg-yellow-400 text-slate-950 font-bold py-3 rounded-xl transition shadow-lg shadow-yellow-500/20 text-sm flex items-center justify-center gap-2 cursor-pointer">
                <i class="bi bi-unlock-fill"></i>
                Aktifkan Lisensi
            </button>
        </form>

        <!-- Footer Notice -->
        <div class="pt-4 border-t border-slate-800 text-[11px] text-slate-500">
            <p>Membutuhkan perpanjangan lisensi atau bantuan teknis?</p>
            <p class="font-medium text-slate-400 mt-0.5">Hubungi 081258386900 (Developer)</p>
        </div>

    </div>

</body>
</html>