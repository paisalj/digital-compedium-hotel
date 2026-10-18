<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login CMS | M Bahalap Hotel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .page-transition {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-tr from-slate-950 via-slate-900 to-indigo-950 min-h-screen flex items-center justify-center px-4 font-sans antialiased">

    <!-- CONTAINER LOGIN CARD -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-100 py-8 px-8 md:px-10 page-transition">
        
<div class="text-center mb-8">
    <div class="w-14 h-14 bg-amber-50 border border-amber-100 rounded-2xl mx-auto flex items-center justify-center text-amber-600 text-2xl shadow-inner mb-4">
        <i class="bi bi-buildings-fill"></i>
    </div>
    <!-- Judul dibuat lebih ramah dan mengalir -->
    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang</h1>
    <!-- Sub-judul penjelas ditaruh di bawah dengan gaya yang rapi -->
    <p class="text-xs text-amber-700/80 mt-1 font-semibold tracking-wide">M Bahalap Hotel Management System</p>
</div>
        <!-- PESAN ERROR -->
        @if ($errors->any())
            <div class="mb-6 p-3.5 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl flex items-center gap-2 font-medium">
                <i class="bi bi-exclamation-circle-fill text-sm flex-shrink-0"></i>
                <span>Email atau kata sandi yang Anda masukkan salah.</span>
            </div>
        @endif

        <!-- FORM LOGIN -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5" autocomplete="off">
            @csrf

            <!-- Input Email (Ditambahkan autocomplete="new-email" agar browser tidak auto-fill) -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" value="" required autofocus autocomplete="off"
                           class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all duration-200"
                           placeholder="nama@mbahalaphotel.com">
                </div>
            </div>

            <!-- Input Password (Ditambahkan autocomplete="new-password" agar bersih dari auto-fill) -->
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                           class="w-full pl-10 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all duration-200"
                           placeholder="••••••••">
                    <!-- Tombol Mata (Show/Hide Password) -->
                    <button type="button" onclick="togglePasswordVisibility()" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-amber-600 transition-colors cursor-pointer">
                        <i id="togglePasswordIcon" class="bi bi-eye text-base"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500 mr-2 cursor-pointer">
                    <span>Ingat saya</span>
                </label>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" 
                    class="w-full mt-2 bg-amber-600 hover:bg-amber-700 active:scale-[0.98] text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all duration-200 flex items-center justify-center gap-2 text-sm cursor-pointer">
                <span>Masuk ke Dashboard</span>
                <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <!-- FOOTER -->
        <div class="mt-8 text-center border-t border-slate-100 pt-5">
            <p class="text-[10px] text-slate-400 tracking-wider uppercase font-medium">
                &copy; {{ date('Y') }} M Bahalap Hotel. All rights reserved.
            </p>
        </div>

    </div>

    <!-- SCRIPT TOGGLE PASSWORD -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>

</body>
</html>