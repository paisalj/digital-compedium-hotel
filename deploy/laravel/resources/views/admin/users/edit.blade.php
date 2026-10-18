@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">Edit Staf: {{ $user->name }}</h3>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Kembali</a>
        </div>
        
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM UPDATE -->
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT') <!-- Penting untuk update -->
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-2 rounded" required>
                </div>
                
                <!-- Password dikosongkan jika tidak ingin diubah -->
                <div class="mb-4 relative">
                    <label class="block font-semibold mb-1">Password Baru <span class="text-sm text-gray-500 font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full border p-2 rounded pr-10" autocomplete="new-password">
                        <button type="button" onclick="togglePassword()" class="absolute right-2 top-2 text-gray-500">
                            <i id="eye-icon" class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Role</label>
                    <select name="role" class="w-full border p-2 rounded bg-white">
                        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Update Staf
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove('bi-eye-fill');
        eyeIcon.classList.add('bi-eye-slash-fill');
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove('bi-eye-slash-fill');
        eyeIcon.classList.add('bi-eye-fill');
    }
}
</script>
@endsection