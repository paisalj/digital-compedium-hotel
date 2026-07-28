<aside x-show="sidebarOpen" 
       x-transition:enter="transition duration-300 ease-in-out" 
       x-transition:leave="transition duration-300 ease-in-out"
       class="w-64 bg-[#0B132B] text-white sticky top-0 h-screen overflow-y-auto flex-shrink-0 z-40 flex flex-col">

    <!-- Logo -->
    <!-- ===========================
        HOTEL BRAND
    =========================== -->
<!-- ===========================
    HOTEL BRAND / LOGO AREA
=========================== -->
<div class="px-6 py-6 border-b border-slate-700">
    <div class="flex flex-col items-center text-center">

        <!-- Pembungkus Logo (Menggunakan w-16 h-16 standar Tailwind) -->
        <div class="w-16 h-16 rounded-full bg-white border-[3px] border-yellow-400 shadow-lg flex items-center justify-center overflow-hidden p-1.5">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Logo Hotel"
                class="w-full h-full object-contain"
            >
        </div>

        <!-- Teks Branding (Satu atau Dua Baris) -->
        <div class="mt-3">
            <!-- Pilihan 1: Jika hanya ingin "Digital Compendium" tapi lebih terang -->
            <p class="text-xs font-semibold tracking-widest uppercase text-slate-200">
                Digital Compendium
            </p>

            <!-- Opsional: Tambahkan nama hotel di bawahnya sebagai sub-identitas -->
            <p class="text-[10px] tracking-wider text-yellow-400/90 mt-0.5 font-medium">
                M Bahalap Hotel
            </p>
        </div>

    </div>
</div>

<!-- Menu -->
    <nav class="flex-1 mt-6 flex flex-col">

    <p class="px-6 mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-slate-500">
        Main Menu
    </p>
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>

        <!-- Kategori -->
        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="bi bi-folder-fill"></i>
            Kategori
        </a>

        <!-- Konten -->
        <a href="{{ route('admin.contents.index') }}"
           class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('admin.contents.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="bi bi-file-earmark-text-fill"></i>
            Konten
        </a>

        <!-- Media -->
        <a href="{{ route('admin.media.index') }}"
           class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('admin.media.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="bi bi-images"></i>
            Media
        </a>

        <!-- Bahasa -->
        <a href="{{ route('admin.languages.index') }}"
           class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('admin.languages.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="bi bi-translate"></i>
            Bahasa
        </a>
         
        <!-- Bagian Bawah Sidebar (Utilitas & Pengaturan) -->
        <div class="mt-auto pt-4">
            
            <!-- GARIS PEMISAH (DIVIDER) -->
            <hr class="border-slate-700 mx-6 my-3">

    <p class="px-6 mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-slate-500">
        Website
    </p>
            <!-- Link Mode Admin / Lihat Website -->
            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-3 px-6 py-3 text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <i class="bi bi-eye"></i> 
                <span>Lihat Website</span>
            </a>
            
            
            @if(auth()->user()->role == 'super_admin')
            <hr class="border-slate-700 mx-6 my-3">

    <p class="px-6 mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-slate-500">
        Sistem
    </p>
                <!-- Pengaturan -->
                <a href="{{ route('admin.settings.index') }}"
                   class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('admin.settings.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-gear-fill"></i>
                    Pengaturan
                </a>

                <!-- Activity Log -->
                <a href="{{ route('admin.activity-logs.index') }}" 
                   class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('admin.activity-logs.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-clock-history"></i>
                    Activity Log
                </a>

                <!-- User -->
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('admin.users.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="bi bi-people-fill"></i>
                    User
                </a>

            @endif
        </div>

    </nav>

    <!-- =========================================================
         AREA LOGOUT (x-data diletakkan KHUSUS di sini agar aman)
    ========================================================== -->
    <div class="border-t border-slate-700 p-5" x-data="{ showLogoutModal: false }">
        <!-- Tombol Trigger Logout -->
        <button
            @click="showLogoutModal = true"
            type="button"
            class="w-full bg-red-600 hover:bg-red-700 rounded-lg py-2 transition flex items-center justify-center gap-2 cursor-pointer text-white font-medium">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>

        <!-- MODAL KONFIRMASI LOGOUT -->
        <!-- style="display: none;" mencegah modal muncul saat pindah/load halaman -->
        <div x-show="showLogoutModal" 
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            
            <div @click.outside="showLogoutModal = false"
                 class="bg-[#0B132B] border border-slate-700 text-white rounded-2xl p-6 w-full max-w-sm shadow-2xl space-y-4">
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-500/20 text-red-500 flex items-center justify-center flex-shrink-0 text-xl">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Konfirmasi Keluar</h3>
                        <p class="text-sm text-slate-400">Apakah Anda yakin ingin keluar dari aplikasi?</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button @click="showLogoutModal = false" 
                            type="button"
                            class="px-4 py-2 rounded-lg text-sm bg-slate-800 hover:bg-slate-700 text-slate-300 transition cursor-pointer">
                        Batal
                    </button>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg text-sm bg-red-600 hover:bg-red-700 text-white font-semibold transition cursor-pointer">
                            Ya, Keluar
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- END AREA LOGOUT -->

</aside>