@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-8">

    <!-- Welcome -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-700 rounded-3xl p-8 text-white shadow-xl">

        <h2 class="text-3xl font-bold">
            Selamat Datang, Administrator 👋
        </h2>

        <p class="mt-3 text-slate-300">
            Kelola seluruh Digital Compendium M Bahalap Hotel dari dashboard ini.
        </p>

    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">Kategori</p>

                    <h3 class="text-4xl font-bold mt-2">
                        12
                    </h3>

                </div>

                <div class="w-16 h-16 rounded-xl bg-blue-100 flex items-center justify-center">

                    <i class="bi bi-folder-fill text-3xl text-blue-600"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">Konten</p>

                    <h3 class="text-4xl font-bold mt-2">
                        48
                    </h3>

                </div>

                <div class="w-16 h-16 rounded-xl bg-green-100 flex items-center justify-center">

                    <i class="bi bi-file-earmark-text-fill text-3xl text-green-600"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">Media</p>

                    <h3 class="text-4xl font-bold mt-2">
                        126
                    </h3>

                </div>

                <div class="w-16 h-16 rounded-xl bg-purple-100 flex items-center justify-center">

                    <i class="bi bi-images text-3xl text-purple-600"></i>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">Bahasa</p>

                    <h3 class="text-4xl font-bold mt-2">
                        3
                    </h3>

                </div>

                <div class="w-16 h-16 rounded-xl bg-yellow-100 flex items-center justify-center">

                    <i class="bi bi-translate text-3xl text-yellow-600"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Action -->
    <div class="grid lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-md p-6">

            <h3 class="text-xl font-semibold mb-5">
                Quick Action
            </h3>

            <div class="space-y-3">

                <button class="w-full bg-slate-900 hover:bg-slate-800 text-white rounded-xl py-3 transition">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Konten
                </button>

                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl py-3 transition">
                    <i class="bi bi-folder-plus"></i>
                    Tambah Kategori
                </button>

                <button class="w-full bg-green-600 hover:bg-green-700 text-white rounded-xl py-3 transition">
                    <i class="bi bi-cloud-upload"></i>
                    Upload Media
                </button>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-md p-6">

            <h3 class="text-xl font-semibold mb-5">

                Aktivitas Terbaru

            </h3>

            <ul class="space-y-4 text-gray-600">

                <li>✅ Admin Login</li>

                <li>📂 Kategori "Restaurant" dibuat</li>

                <li>📝 Konten "Breakfast" diperbarui</li>

                <li>🖼 Media berhasil diupload</li>

            </ul>

        </div>

    </div>

</div>

@endsection