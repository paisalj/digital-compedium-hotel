@extends('guest.layouts.app')

@section('title', $content->title)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    
    <!-- Tombol Kembali -->
    <a href="{{ route('guest.home') }}#kamar" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600 mb-8 transition">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>

    <!-- Layout Utama Detail -->
    <div class="grid lg:grid-cols-3 gap-12 items-start">
        
        <!-- Sisi Kiri (Foto Utama & Konten Deskripsi Lengkap) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="aspect-[16/9] rounded-3xl overflow-hidden bg-slate-100 shadow-sm border border-slate-100">
                <img src="{{ $content->image ? asset('storage/' . $content->image) : 'https://placehold.co/1200x675?text=No+Image' }}" 
                     class="w-full h-full object-cover" 
                     alt="{{ $content->title }}">
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold uppercase rounded-md">
                        {{ $content->category->name }}
                    </span>
                    <span class="text-xs text-slate-400">
                        <i class="bi bi-calendar3"></i> Diperbarui {{ $content->updated_at->diffForHumans() }}
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                    {{ $content->title }}
                </h1>
            </div>

            <!-- Teks Deskripsi (Aman Render HTML dari TinyMCE) -->
            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed space-y-4">
                {!! $content->description !!}
            </div>
        </div>

        <!-- Sisi Kanan (Widget Pemesanan / Kontak Hubung) -->
        <div class="space-y-6 lg:sticky lg:top-24">
            
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
                <div>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Tertarik dengan unit ini?</span>
                    <h3 class="font-bold text-slate-900 text-lg mt-1">Konsultasikan & Reservasi</h3>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-xs text-slate-500 leading-relaxed">
                    Staf reservasi kami siap membantu Anda 24/7 untuk mempersiapkan proses menginap terbaik Anda.
                </div>

                <!-- 💬 INTEGRASI WA AUTO-TEXT YANG SANGAT MEMBANTU -->
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', $settings['hotel_whatsapp'] ?? '');
                    $message = urlencode("Halo admin " . ($settings['hotel_name'] ?? 'Hotel') . ", saya ingin bertanya / memesan mengenai unit: *" . $content->title . "*");
                @endphp
                
                <a href="https://wa.me/62{{ $waNumber }}?text={{ $message }}" 
                   target="_blank"
                   class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md transition flex items-center justify-center gap-2 text-sm">
                    <i class="bi bi-whatsapp text-lg"></i>
                    Hubungi Admin Via WhatsApp
                </a>
            </div>

        </div>

    </div>

    <!-- 🌟 REKOMENDASI KONTEN SEJENIS DI BAWAH -->
    @if($related_contents->count() > 0)
        <div class="mt-24 pt-12 border-t border-slate-200">
            <h3 class="text-xl font-bold text-slate-900 mb-8">Rekomendasi Serupa Lainnya</h3>
            <div class="grid sm:grid-cols-3 gap-8">
                @foreach($related_contents as $related)
                    <a href="{{ route('guest.content', $related->slug) }}" class="group block space-y-3">
                        <div class="aspect-[16/10] rounded-xl overflow-hidden bg-slate-100 shadow-sm border border-slate-100">
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : 'https://placehold.co/600x400?text=No+Image' }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300" 
                                 alt="{{ $related->title }}">
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm line-clamp-1 group-hover:text-blue-600 transition">{{ $related->title }}</h4>
                            <p class="text-xs text-slate-400 mt-1">Lihat detail <i class="bi bi-arrow-right"></i></p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection