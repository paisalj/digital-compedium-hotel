@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')


<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold">Manajemen User</h3>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Tambah Staf
        </a>
    </div>
@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full border-collapse">
        <!-- Header Tabel (Warna disamakan dengan Kategori) -->
        <thead class="bg-[#dce4ec] text-slate-700 text-xs font-bold uppercase tracking-wider">
            <tr>
                <th class="py-3.5 px-4 text-left">Nama</th>
                <th class="py-3.5 px-4 text-left">Email</th>
                <th class="py-3.5 px-4 text-center">Role</th>
                <th class="py-3.5 px-4 text-center">Status</th>
                <th class="py-3.5 px-4 text-center">Aksi</th>
            </tr>
        </thead>

        <!-- Isi Tabel (Garis pemisah horizontal halus) -->
        <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
            @foreach($users as $user)
<tr class="border-b odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 transition">
                    <td class="py-3 px-4 font-semibold text-slate-800">{{ $user->name }}</td>
                    <td class="py-3 px-4 text-slate-600">{{ $user->email }}</td>
                    
                    <!-- Role Badge -->
                    <td class="py-3 px-4 text-center">
                        @if($user->role == 'super_admin')
                            <span class="px-2.5 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold uppercase">Super Admin</span>
                        @elseif($user->role == 'admin')
                            <span class="px-2.5 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-bold uppercase">Admin</span>
                        @else
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-600 rounded-full text-xs font-bold uppercase">Staff</span>
                        @endif
                    </td>

                    <!-- Status Toggle -->
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" {{ $user->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </button>
                        </form>
                    </td>

                    <!-- Tombol Aksi -->
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Tombol Hapus (Fungsi confirmDelete Tetap Ada) -->
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="delete-form-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')" 
                                        class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition text-xs font-semibold">
                                    Hapus
                                </button>
                            </form>

                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-amber-500 text-white px-3 py-1.5 rounded-lg hover:bg-amber-600 transition text-xs font-semibold">
                                Edit
                            </a>
                        </div>
                    </td>  
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

<script>
function confirmDelete(id, name) { // Tambahkan parameter 'name' di sini
    Swal.fire({
        title: 'Apakah Anda yakin?',
        // Gunakan template literal (backtick) untuk memasukkan variabel nama
        text: `Data '${name}' akan dihapus secara permanen!`, 
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endsection