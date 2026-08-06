<aside :class="sidebarOpen ? 'w-64' : 'w-20'" 
       class="bg-[#0B132B] text-white sticky top-0 h-screen overflow-y-auto overflow-x-hidden flex-shrink-0 z-40 flex flex-col transition-all duration-300">

    <!-- ===========================
         HOTEL BRAND / LOGO AREA
    =========================== -->
    <div class="py-6 border-b border-slate-700 flex flex-col items-center">
        <!-- Pembungkus Logo -->
        <div class="w-12 h-12 rounded-full bg-white border-[3px] border-yellow-400 shadow-lg flex items-center justify-center overflow-hidden p-1 flex-shrink-0">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Logo Hotel"
                class="w-full h-full object-contain"
            >
        </div>

        <!-- Teks Branding (Disembunyikan saat sidebar collapse) -->
        <div class="mt-3 text-center" x-show="sidebarOpen" x-transition.opacity>
            <p class="text-xs font-semibold tracking-widest uppercase text-slate-200">
                Digital Compendium
            </p>
            <p class="text-[10px] tracking-wider text-yellow-400/90 mt-0.5 font-medium">
                M Bahalap Hotel
            </p>
        </div>
    </div>

    <!-- Menu -->
    <nav class="flex-1 mt-6 flex flex-col">

        <p class="px-6 mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-slate-500" x-show="sidebarOpen">
            Main Menu
        </p>
        
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
           class="flex items-center py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
           title="Dashboard">
            <i class="bi bi-grid-fill text-lg"></i>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
        </a>

        <!-- Kategori -->
        <a href="{{ route('admin.categories.index') }}"
           :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
           class="flex items-center py-3 transition {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
           title="Kategori">
            <i class="bi bi-folder-fill text-lg"></i>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Kategori</span>
        </a>

        <!-- Konten -->
        <a href="{{ route('admin.contents.index') }}"
           :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
           class="flex items-center py-3 transition {{ request()->routeIs('admin.contents.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
           title="Konten">
            <i class="bi bi-file-earmark-text-fill text-lg"></i>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Konten</span>
        </a>

        <!-- Media -->
        <a href="{{ route('admin.media.index') }}"
           :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
           class="flex items-center py-3 transition {{ request()->routeIs('admin.media.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
           title="Media">
            <i class="bi bi-images text-lg"></i>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Media</span>
        </a>

        <!-- Bahasa -->
        <a href="{{ route('admin.languages.index') }}"
           :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
           class="flex items-center py-3 transition {{ request()->routeIs('admin.languages.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
           title="Bahasa">
            <i class="bi bi-translate text-lg"></i>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Bahasa</span>
        </a>
         
        <!-- Bagian Bawah Sidebar -->
        <div class="mt-auto pt-4">
            
            <hr class="border-slate-700 mx-4 my-3">

            <p class="px-6 mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-slate-500" x-show="sidebarOpen">
                Website
            </p>
            
            <a href="{{ url('/') }}" target="_blank" 
               :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
               class="flex items-center py-3 text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all"
               title="Lihat Website">
                <i class="bi bi-eye text-lg"></i> 
                <span x-show="sidebarOpen" class="whitespace-nowrap">Lihat Website</span>
            </a>
            
            @if(auth()->user()->role == 'super_admin')
                <hr class="border-slate-700 mx-4 my-3">

                <p class="px-6 mb-3 text-[11px] font-semibold uppercase tracking-[0.30em] text-slate-500" x-show="sidebarOpen">
                    Sistem
                </p>
                
                <!-- Pengaturan -->
                <a href="{{ route('admin.settings.index') }}"
                   :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
                   class="flex items-center py-3 transition {{ request()->routeIs('admin.settings.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                   title="Pengaturan">
                    <i class="bi bi-gear-fill text-lg"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Pengaturan</span>
                </a>

                <!-- Activity Log -->
                <a href="{{ route('admin.activity-logs.index') }}" 
                   :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
                   class="flex items-center py-3 transition {{ request()->routeIs('admin.activity-logs.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                   title="Activity Log">
                    <i class="bi bi-clock-history text-lg"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Activity Log</span>
                </a>

                <!-- User -->
                <a href="{{ route('admin.users.index') }}"
                   :class="sidebarOpen ? 'px-6 justify-start gap-3' : 'px-0 justify-center'"
                   class="flex items-center py-3 transition {{ request()->routeIs('admin.users.*') ? 'bg-slate-800/80 border-l-4 border-yellow-400 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                   title="User">
                    <i class="bi bi-people-fill text-lg"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">User</span>
                </a>
            @endif
        </div>

    </nav>

    <!-- AREA LOGOUT -->
    <div class="border-t border-slate-700 p-4" x-data="{ showLogoutModal: false }">
        <!-- Tombol Trigger Logout -->
        <button
            @click="showLogoutModal = true"
            type="button"
            :class="sidebarOpen ? 'w-full px-4 gap-2' : 'w-10 h-10 mx-auto justify-center rounded-lg'"
            class="bg-red-600 hover:bg-red-700 py-2 transition flex items-center justify-center cursor-pointer text-white font-medium"
            title="Logout">
            <i class="bi bi-box-arrow-right text-lg"></i>
            <span x-show="sidebarOpen">Logout</span>
        </button>

        <!-- MODAL KONFIRMASI LOGOUT -->
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

                    <button type="button" 
                            onclick="event.preventDefault(); document.getElementById('global-logout-form').submit();"
                            class="px-4 py-2 rounded-lg text-sm bg-red-600 hover:bg-red-700 text-white font-semibold transition cursor-pointer">
                        Ya, Keluar
                    </button>
                </div>

            </div>
        </div>
    </div>
</aside>