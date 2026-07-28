<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Digital Compendium')
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css','resources/js/app.js'])


</head>

<body class="bg-slate-100 font-[Poppins]">

<div class="flex min-h-screen bg-slate-100" x-data="{ sidebarOpen: true }">
    
    {{-- Sidebar --}}
    @include('admin.layouts.sidebar')

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">

        {{-- Navbar --}}
        @include('admin.layouts.navbar')

        <main class="flex-1 overflow-x-hidden p-6">

            @yield('content')

        </main>

        {{-- Footer --}}
        @include('admin.layouts.footer')

    </div>

</div>

    <!-- FORM LOGOUT TERPISAH (Hidden & Aman dari Konflik Form Halaman Lain) -->
<form id="global-logout-form" action="{{ route('logout') }}" method="POST" class="hidden" style="display: none;">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

@include('admin.layouts.scripts')

@stack('scripts')

@if(session('success'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil',

    text: "{{ session('success') }}",

    confirmButtonColor:'#EAB308'

});

</script>

@endif


@if(session('error'))

<script>

Swal.fire({

    icon:'error',

    title:'Oops...',

    text:"{{ session('error') }}",

    confirmButtonColor:'#dc2626'

});

</script>

@endif
</body>

</html>