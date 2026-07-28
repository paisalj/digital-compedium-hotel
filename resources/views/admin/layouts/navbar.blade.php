<header class="bg-white h-20 shadow-sm border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-30">

    <!-- Left -->
    <div class="flex items-center gap-5">

        <!-- Mobile Menu (Opsional toggle jika ada script sidebar mobile) -->
<!-- Tombol Hamburger di Navbar -->
<button @click="sidebarOpen = !sidebarOpen" 
        class="text-2xl text-slate-700 hover:text-yellow-500 transition focus:outline-none p-1 rounded-xl hover:bg-slate-100">
    <i class="bi bi-list"></i>
</button>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                @yield('page-title')
            </h1>
            <p class="text-sm text-slate-500">
                Welcome back 👋
            </p>
        </div>

    </div>

    <!-- Right -->
    <div class="flex items-center gap-5">



        <!-- Divider -->
        <div class="w-px h-10 bg-gray-300"></div>

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ openProfile: false }">
            <button @click="openProfile = !openProfile" class="flex items-center gap-3 cursor-pointer focus:outline-none">
@if(Auth::user()->avatar)
    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-11 h-11 rounded-full border-2 border-yellow-400 object-cover shadow-sm" alt="Admin">
@else
    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=D4AF37&color=fff" class="w-11 h-11 rounded-full border-2 border-yellow-400 object-cover shadow-sm" alt="Admin">
@endif
                <div class="hidden md:block text-left">
                    <h3 class="font-semibold text-slate-800 text-sm">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </h3>
                    <p class="text-xs text-slate-500 capitalize">
                        {{ str_replace('_', ' ', Auth::user()->role ?? 'Super Admin') }}
                    </p>
                </div>

                <i class="bi bi-chevron-down text-gray-500 text-xs transition-transform duration-200" :class="{ 'rotate-180': openProfile }"></i>
            </button>

            <!-- Dropdown Menu Akun -->
            <div x-show="openProfile" @click.away="openProfile = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 text-xs">
                <div class="px-4 py-2 border-b border-slate-100 mb-1">
                    <p class="font-bold text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email ?? 'admin@hotel.com' }}</p>
                </div>

<a href="{{ route('admin.profile.edit') }}" class="flex items-center space-x-2 px-4 py-2 text-slate-700 hover:bg-slate-50 font-medium">
    <i class="bi bi-person-circle text-slate-400 text-sm"></i>
    <span>Pengaturan Akun</span>
</a>
                <div class="border-t border-slate-100 my-1"></div>

                <!-- Form Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
            </div>
        </div>

    </div>

</header>