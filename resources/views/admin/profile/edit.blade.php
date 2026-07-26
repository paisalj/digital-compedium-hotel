
@extends('admin.layouts.app')

@section('title', 'Edit pengaturan akun')

@section('page-title', 'Pengaturan Akun')

@section('content')
<div class="p-4 sm:p-8 max-w-4xl mx-auto">
    
    <!-- Header Banner Mini -->
    <div class="mb-6 bg-gradient-to-r from-[#0B132B] to-slate-800 rounded-2xl p-6 text-white shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold">Pengaturan Akun Pribadi</h1>
            <p class="text-xs text-slate-300 mt-1">Perbarui identitas dan tampilan profil Anda di sistem.</p>
        </div>
        <div class="hidden sm:block text-3xl text-yellow-400 opacity-80">
            <i class="bi bi-person-badge"></i>
        </div>
    </div>

    <!-- Pesan Sukses -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-xs font-semibold flex items-center gap-3 shadow-sm animate-fade-in">
            <i class="bi bi-check-circle-fill text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-6 sm:p-8 space-y-6" x-data="{ 
                photoPreview: null,
                updatePreview(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.photoPreview = e.target.result; };
                        reader.readAsDataURL(file);
                    }
                }
            }">
                
                <!-- Bagian Foto Profil dengan Live Preview -->
                <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-slate-100">
                    
                    <!-- Lingkaran Foto -->
                    <div class="relative group">
                        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-yellow-400 bg-slate-100 shadow-md">
                            <!-- Tampilkan Preview jika ada file dipilih, jika tidak tampilkan foto database/default -->
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=D4AF37&color=fff" class="w-full h-full object-cover" alt="Avatar">
                                @endif
                            </template>
                        </div>
                    </div>

                    <!-- Input File -->
                    <div class="flex-1 w-full text-center sm:text-left">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Profil Baru</label>
                        <div class="flex items-center justify-center sm:justify-start">
                            <label class="cursor-pointer bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-700 transition flex items-center gap-2 shadow-sm">
                                <i class="bi bi-cloud-upload text-yellow-600 text-sm"></i>
                                <span>Pilih Berkas Foto</span>
                                <input type="file" name="avatar" @change="updatePreview($event)" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-2">Mendukung format JPG, PNG, atau GIF. Ukuran maksimum 2MB.</p>
                        @error('avatar')
                            <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Input Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="bi bi-person text-sm"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 transition">
                    </div>
                    @error('name')
                        <span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Informasi Email (Read-only) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email Sistem</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="bi bi-envelope text-sm"></i>
                        </span>
                        <input type="email" value="{{ Auth::user()->email }}" disabled
                            class="w-full pl-10 pr-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 cursor-not-allowed">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Alamat email dikelola khusus melalui menu Manajemen User oleh Super Admin.</p>
                </div>

            </div>

            <!-- Footer Tombol Simpan -->
            <div class="px-6 sm:px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="submit" class="px-6 py-2.5 bg-[#0B132B] hover:bg-slate-800 text-white font-semibold rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                    <i class="bi bi-check2-circle text-sm text-yellow-400"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection