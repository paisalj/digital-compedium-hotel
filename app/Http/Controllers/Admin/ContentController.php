<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Category;
use App\Models\Language;
use App\Models\ContentTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Tampilkan daftar semua konten portofolio.
     */
    public function index()
    {
        // Ambil konten beserta relasi kategori dan terjemahannya
        $contents = Content::with(['category.translations', 'translations.language'])->get();
        return view('admin.contents.index', compact('contents'));
    }

    /**
     * Tampilkan form untuk membuat konten baru.
     */
    public function create()
    {
        // Ambil data untuk dropdown kategori dan list form bahasa
        $categories = Category::with('translations')->get();
        $languages = Language::where('is_active', true)->get();

        return view('admin.contents.create', compact('categories', 'languages'));
    }

    /**
     * Simpan konten baru beserta terjemahannya ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'translations' => 'required|array',
        ]);

        // 1. Handle Upload Foto/Thumbnail Utama jika ada
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('contents/thumbnails', 'public');
        }

        // 2. Simpan data induk ke tabel 'contents'
        $content = Content::create([
            'category_id' => $request->category_id,
            'thumbnail' => $thumbnailPath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->is_active ?? true,
        ]);

        // 3. Simpan data teks multi-bahasa ke tabel 'content_translations'
        foreach ($request->translations as $langId => $translationData) {
            // Pastikan judul diisi untuk tiap bahasa
            if (!empty($translationData['title'])) {
                ContentTranslation::create([
                    'content_id' => $content->id,
                    'language_id' => $langId,
                    'title' => $translationData['title'],
                    'body' => $translationData['body'] ?? '', // Menampung HTML dari Rich Text Editor
                    'slug' => Str::slug($translationData['title']),
                ]);
            }
        }

        return redirect()->route('admin.contents.index')
                         ->with('success', 'Konten portofolio berhasil disimpan!');
    }

    /**
     * Tampilkan detail konten (Opsional).
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Tampilkan form untuk mengedit konten.
     */
    public function edit(string $id)
    {
        $content = Content::findOrFail($id);
        $categories = Category::with('translations')->get();
        $languages = Language::where('is_active', true)->get();
        
        // Mengambil data terjemahan yang sudah ada di-group berdasarkan language_id
        $translations = $content->translations->keyBy('language_id');

        return view('admin.contents.edit', compact('content', 'categories', 'languages', 'translations'));
    }

    /**
     * Perbarui konten yang ada di database.
     */
    public function update(Request $request, string $id)
    {
        $content = Content::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'translations' => 'required|array',
        ]);

        // Handle update foto/thumbnail
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($content->thumbnail) {
                Storage::disk('public')->delete($content->thumbnail);
            }
            $content->thumbnail = $request->file('thumbnail')->store('contents/thumbnails', 'public');
        }

        $content->category_id = $request->category_id;
        $content->sort_order = $request->sort_order ?? 0;
        $content->is_active = $request->is_active ?? true;
        $content->save();

        // Update data terjemahan
        foreach ($request->translations as $langId => $translationData) {
            if (!empty($translationData['title'])) {
                ContentTranslation::updateOrCreate(
                    [
                        'content_id' => $content->id,
                        'language_id' => $langId
                    ],
                    [
                        'title' => $translationData['title'],
                        'body' => $translationData['body'] ?? '',
                        'slug' => Str::slug($translationData['title']),
                    ]
                );
            }
        }

        return redirect()->route('admin.contents.index')
                         ->with('success', 'Konten portofolio berhasil diperbarui!');
    }

    /**
     * Hapus konten dari database.
     */
    public function destroy(string $id)
    {
        $content = Content::findOrFail($id);
        
        // Hapus file thumbnail fisik jika ada
        if ($content->thumbnail) {
            Storage::disk('public')->delete($content->thumbnail);
        }

        // Data di tabel content_translations otomatis terhapus karena onDelete('cascade') di database
        $content->delete();

        return redirect()->route('admin.contents.index')
                         ->with('success', 'Konten portofolio berhasil dihapus!');
    }
}