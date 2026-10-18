<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiApiKey;
use Illuminate\Http\Request;
use Throwable;

class AiApiKeyController extends Controller
{
    /**
     * Menampilkan daftar semua API Key
     */
    public function index()
    {
        $keys = AiApiKey::orderBy('id', 'asc')->get();
        return view('admin.ai-api-keys.index', compact('keys'));
    }

    /**
     * Menampilkan form tambah API Key
     */
    public function create()
    {
        return view('admin.ai-api-keys.create');
    }

    /**
     * Menyimpan API Key baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        try {
            AiApiKey::create([
                'name' => $request->name,
                'api_key' => trim($request->api_key),
                'is_active' => $request->is_active,
                'status' => 'ready',
            ]);

            return redirect()->route('admin.ai-api-keys.index')
                ->with('success', 'API Key baru berhasil ditambahkan.');
        } catch (Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit API Key
     */
    public function edit($id)
    {
        $apiKey = AiApiKey::findOrFail($id);
        return view('admin.ai-api-keys.edit', compact('apiKey'));
    }

    /**
     * Memperbarui data API Key di database
     */
    public function update(Request $request, $id)
    {
        $apiKey = AiApiKey::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
            'is_active' => 'required|boolean',
            'status' => 'required|string|in:ready,quota_exceeded',
        ]);

        try {
            $apiKey->update([
                'name' => $request->name,
                'api_key' => trim($request->api_key),
                'is_active' => $request->is_active,
                'status' => $request->status,
                // Jika admin mereset status secara manual ke 'ready', hapus batasan waktu cooldown nya
                'reset_quota_at' => $request->status === 'ready' ? null : $apiKey->reset_quota_at,
            ]);

            return redirect()->route('admin.ai-api-keys.index')
                ->with('success', 'API Key berhasil diperbarui.');
        } catch (Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus API Key dari database
     */
    public function destroy($id)
    {
        $apiKey = AiApiKey::findOrFail($id);
        
        try {
            $apiKey->delete();
            return redirect()->route('admin.ai-api-keys.index')
                ->with('success', 'API Key berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()->route('admin.ai-api-keys.index')
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}