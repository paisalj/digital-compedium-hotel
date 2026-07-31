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

<div class="w-full overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">
<table class="min-w-full border-separate border-spacing-0">
            <thead class="bg-slate-300 border-b border-slate-400">
<tr class="bg-gray-100 text-gray-700 uppercase text-sm">
    <th class="p-3 border">Nama</th>
    <th class="p-3 border">Email</th>
    <th class="p-3 border">Role</th>
    <th class="p-3 border text-center">Status</th> <!-- Tambahkan text-center -->
    <th class="p-3 border text-center">Aksi</th>   <!-- Tambahkan text-center -->
</tr>
            </thead>
            <tbody>
                @foreach($users as $user)
<tr class="border-b odd:bg-gray-100 even:bg-gray-200 hover:bg-gray-300 transition">
                    <td class="p-3 border">{{ $user->name }}</td>
                    <td class="p-3 border">{{ $user->email }}</td>
<td class="p-3 border">
    @if($user->role == 'super_admin')
        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">Super Admin</span>
    @elseif($user->role == 'admin')
        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase">Admin</span>
    @else
        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Staff</span>
    @endif
</td>

<td class="p-3 border text-center">
    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
        @csrf
        <button type="submit" class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" {{ $user->is_active ? 'checked' : '' }} class="sr-only peer">
            <!-- Tampilan Switch -->
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
        </button>
    </form>
</td>
<td class="p-3 border flex gap-2">
    <!-- Tombol Hapus -->
<!-- Di dalam tabel, pada kolom aksi -->
<form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="delete-form-{{ $user->id }}">
    @csrf
    @method('DELETE')
<!-- Pastikan Anda mengirimkan $user->name ke dalam fungsi -->
<button type="button" 
        onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')" 
        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition text-sm">
    Hapus
</button>
</form>
    <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition text-sm">
    Edit
</a>
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