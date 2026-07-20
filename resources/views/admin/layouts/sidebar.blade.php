<aside class="w-72 min-h-screen bg-slate-900 text-white flex flex-col shadow-xl">

    <!-- Logo -->
<!-- ===========================
     HOTEL BRAND
=========================== -->
<div class="px-6 py-8 border-b border-slate-700">

    <div class="flex flex-col items-center">

        <!-- Logo -->
        <div class="w-15 h-15 rounded-full bg-white border-[3px] border-yellow-400 shadow-lg flex items-center justify-center overflow-hidden">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="Logo Hotel"
                class="w-14 h-14 object-contain"
            >

        </div>

        <!-- Nama Hotel -->
        <h2 class="mt-4 text-xl font-bold tracking-wide text-white text-center">
            M Bahalap Hotel
        </h2>

        <!-- Bintang -->
        <div class="flex items-center gap-1 mt-2">

            <i class="bi bi-star-fill text-yellow-400 text-sm"></i>
            <i class="bi bi-star-fill text-yellow-400 text-sm"></i>
            <i class="bi bi-star-fill text-yellow-400 text-sm"></i>
            <i class="bi bi-star-fill text-yellow-400 text-sm"></i>
            <i class="bi bi-star-fill text-yellow-400 text-sm"></i>

        </div>

        <!-- Sub Title -->
        <p class="mt-3 text-xs tracking-widest uppercase text-slate-400">
            Digital Compendium 
        </p>

    </div>

</div>

<!-- Menu -->
    <nav class="flex-1 mt-6">

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-6 py-3 hover:bg-slate-800 transition">

            <i class="bi bi-grid-fill"></i>

            Dashboard

        </a>

<a href="{{ route('admin.categories.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">
    <i class="bi bi-folder-fill"></i>
    Kategori
</a>

<a href="{{ route('admin.contents.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('admin.contents.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">
    <i class="bi bi-file-earmark-text-fill"></i>
    Konten
</a>

<a href="{{ route('admin.media.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-slate-800 transition">
    <i class="bi bi-images"></i>
    Media
</a>
<a href="{{ route('admin.languages.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('admin.languages.*') ? 'bg-slate-800 border-l-4 border-blue-500' : '' }}">
    <i class="bi bi-translate"></i>
    Bahasa
</a>
<a href="{{ route('admin.settings.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-slate-800 transition">

    <i class="bi bi-gear-fill"></i>

    Pengaturan

</a>
<a href="{{ route('admin.activity-logs.index') }}" 
   class="flex items-center gap-3 px-6 py-3 hover:bg-slate-800 transition">

    <i class="bi bi-clock-history"></i>

    Activity Log

</a>
  

<!-- Bagian bawah sidebar -->
<div class="mt-auto border-t border-gray-700 pt-4">
    <!-- Link Mode Admin / Lihat Website -->
    <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-3 px-6 py-3 text-sm text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
        <i class="bi bi-eye"></i> 
        <span>Lihat Website</span>
    </a>
    
@if(auth()->user()->role == 'super_admin')
    <a href="{{ route('admin.users.index') }}"
       class="flex items-center gap-3 px-6 py-3 hover:bg-slate-800 transition {{ request()->routeIs('admin.users.*') ? 'bg-slate-800' : '' }}">
        
        <i class="bi bi-people-fill"></i>
        
        User
        
    </a>
@endif
</div>


</nav>

    <!-- Logout -->
    <div class="border-t border-slate-700 p-5">

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 rounded-lg py-2 transition">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </button>

        </form>

    </div>

</aside>