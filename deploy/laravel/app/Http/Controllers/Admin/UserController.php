<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Menggunakan latest() agar yang baru dibuat muncul di paling atas
        $users = User::latest()->get(); 
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role'     => 'required|in:super_admin,admin,staff',
    ]);

    \App\Models\User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        'role'     => $validated['role'],
    ]);

    // UBAH DARI back() MENJADI redirect()->route()
    return redirect()->route('admin.users.index')
                     ->with('success', 'Staf baru berhasil ditambahkan!');
}
public function edit(User $user)
{
    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, User $user)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role'  => 'required|in:super_admin,admin,staff',
    ]);

    $data = $request->only(['name', 'email', 'role']);

    // Hanya update password jika diisi
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);
    
    return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
}

public function toggleStatus(User $user)
{
    // Balik statusnya
    $user->is_active = !$user->is_active;
    $user->save();
    
    // Tentukan pesan berdasarkan status baru
    $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
    
    return back()->with('success', "Status user '{$user->name}' berhasil {$statusText}!");
}
public function destroy(User $user)
{
    // Mencegah Super Admin menghapus dirinya sendiri
    if ($user->id === auth()->id()) {
        return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
    }

    $user->delete();
    return back()->with('success', 'User berhasil dihapus!');
}
}