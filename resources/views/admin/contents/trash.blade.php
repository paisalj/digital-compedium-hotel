@extends('admin.layouts.app')

@section('title', 'Recycle Bin contents')
@section('page-title', 'Recycle Bin')

@section('content')
<div class="p-6 bg-white rounded-2xl shadow-md">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800">🗑️ Recycle Bin Konten</h3>
            <p class="text-sm text-gray-500">Daftar konten portofolio yang dihapus sementara</p>
        </div>
        <a href="{{ route('admin.contents.index') }}" class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition shadow-sm inline-flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-xl flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </span>
        </div>
    @endif

    @if($contents->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b bg-gray-50/50">
                    <tr>
                        <th class="text-left py-3 w-12 pl-4">No</th>
                        <th class="text-left px-6 py-3">Icon</th>
                        <th class="text-left py-3">Judul Konten</th>
                        <th class="text-left py-3">Kategori</th>
                        <th class="text-left py-3">Tanggal Dihapus</th>
                        <th class="text-center py-3 w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($contents as $content)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 pl-4 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                <div class="w-10 h-10 rounded-xl bg-yellow-50 flex justify-center items-center text-yellow-500">
                                    <i class="bi {{ $content->icon ?? 'bi-file-earmark' }}"></i>
                                </div>
                            </td>
                            <td class="py-4 font-medium text-gray-800">
                                {{ $content->translations->where('language.code', app()->getLocale())->first()->title ?? $content->translations->first()->title ?? 'Tanpa Judul' }}
                            </td>
                            <td class="py-4 text-gray-600">
                                {{ $content->category->translations->first()->name ?? 'Tidak ada kategori' }}
                            </td>
                            <td class="py-4 text-sm text-gray-500">
                                {{ $content->deleted_at ? $content->deleted_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-4 text-center">
                                <div class="flex justify-center items-center gap-3">
                                    <form id="restore-form-{{ $content->id }}" action="{{ route('admin.contents.restore', $content->id) }}" method="POST">
                                        @csrf
                                    </form>
                                    <button type="button" 
                                            onclick="confirmAction('restore-form-{{ $content->id }}', 'Kembalikan konten ini?', 'Data akan dikembalikan ke urutan terakhir di daftar utama.', 'warning')" 
                                            class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 text-sm">
                                        <i class="bi bi-arrow-counterclockwise"></i> Restore
                                    </button>

                                    <span class="text-gray-300">|</span>

                                    <form id="delete-form-{{ $content->id }}" action="{{ route('admin.contents.force-delete', $content->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" 
                                            onclick="confirmAction('delete-form-{{ $content->id }}', 'Hapus permanen?', 'Data tidak dapat dipulihkan lagi setelah dihapus!', 'error')" 
                                            class="text-red-600 hover:text-red-800 font-medium flex items-center gap-1 text-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-16 text-gray-500 italic bg-gray-50 rounded-xl">
            Recycle bin kosong. Tidak ada konten yang dihapus.
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmAction(formId, title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: icon === 'error' ? '#dc2626' : '#2563eb',
        cancelButtonColor: '#6b7280',
        confirmButtonText: icon === 'error' ? 'Ya, Hapus Permanen!' : 'Ya, Kembalikan!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endsection