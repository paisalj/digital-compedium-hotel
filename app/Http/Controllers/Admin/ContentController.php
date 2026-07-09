<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Category;
use App\Models\Language;
use App\Models\ContentTranslation;
use App\Services\AI\TranslationService;
use App\Services\AI\DTO\TranslationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    protected TranslationService $translator;

    public function __construct(TranslationService $translator)
    {
        $this->translator = $translator;
    }

public function index()
{
    // Ubah bagian ini agar menggunakan paginate() bukan get() atau all()
    $contents = Content::query()
        ->with('translations.language') // Sesuaikan dengan relasi jika ada
        ->latest()
        ->paginate(10); // <--- Kuncinya ada di sini

    return view('admin.contents.index', compact('contents'));
}

    public function create()
    {
        $categories = Category::with('translations')->get();
        $languages = Language::where('is_active', true)->get();

        return view('admin.contents.create', compact('categories', 'languages'));
    }

public function store(Request $request)
{
    // 1. Validasi lebih ketat
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'icon' => 'nullable|string',
        'translations' => 'required|array',
    ]);

    try {
        // 2. Gunakan DB Transaction agar jika gagal di tengah jalan, 
        // data tidak tersimpan setengah-setengah di database
        return \DB::transaction(function () use ($request) {
            
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('contents/thumbnails', 'public');
            }

            $content = Content::create([
                'category_id' => $request->category_id,
                'icon'        => $request->icon, // <-- TAMBAHKAN BARIS INI
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->is_active ?? true,
            ]);

            foreach ($request->translations as $langId => $translationData) {
                // Pastikan title tidak kosong sebelum mencoba simpan
                if (!empty($translationData['title'])) {
                    ContentTranslation::create([
                        'content_id'  => $content->id,
                        'language_id' => $langId,
                        'title'       => $translationData['title'],
                        // Penting: Pastikan body terambil dari textarea (hasil tinymce.triggerSave)
                        'body'        => $translationData['body'] ?? '',
                        'slug'        => Str::slug($translationData['title']),
                    ]);
                }
            }

            return redirect()->route('admin.contents.index')
                             ->with('success', 'Konten portofolio berhasil disimpan!');
        });

    } catch (\Exception $e) {
        // 3. Log error ke storage/logs/laravel.log agar kita tahu masalahnya
        \Log::error("Gagal simpan konten: " . $e->getMessage());
        
        // Kembalikan ke halaman sebelumnya dengan pesan error
        return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
}

public function edit(string $id)
    {
        $content = Content::findOrFail($id);
        $categories = Category::with('translations')->get();
        $languages = Language::where('is_active', true)->get();
        
        $translations = $content->translations->keyBy('language_id');

        return view('admin.contents.edit', compact('content', 'categories', 'languages', 'translations'));
    }

    public function update(Request $request, string $id)
    {
        $content = Content::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string',
            'translations' => 'required|array',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($content->thumbnail) {
                Storage::disk('public')->delete($content->thumbnail);
            }
            $content->thumbnail = $request->file('thumbnail')->store('contents/thumbnails', 'public');
        }

        $content->category_id = $request->category_id;
        $content->icon = $request->icon;
        $content->sort_order = $request->sort_order ?? 0;
        $content->is_active = $request->is_active ?? true;
        $content->save();

        foreach ($request->translations as $langId => $translationData) {
            if (!empty($translationData['title'])) {
                ContentTranslation::updateOrCreate(
                    ['content_id' => $content->id, 'language_id' => $langId],
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

    public function destroy(string $id)
    {
        $content = Content::findOrFail($id);
        if ($content->thumbnail) {
            Storage::disk('public')->delete($content->thumbnail);
        }
        $content->delete();

        return redirect()->route('admin.contents.index')
                         ->with('success', 'Konten portofolio berhasil dihapus!');
    }

public function translate(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'body'  => 'nullable|string',
        'from'  => 'required|string',
    ]);

    try {
        // 1. EKSTRAKSI GAMBAR (Penting agar tidak dikirim ke AI)
        // Kita simpan gambar ke dalam array sementara, dan ganti dengan placeholder di body
        $images = [];
        $body = $request->body;
        
        $bodyWithPlaceholders = preg_replace_callback('/<img[^>]+>/i', function ($matches) use (&$images) {
            $id = 'IMAGE_PLACEHOLDER_' . count($images);
            $images[$id] = $matches[0];
            return $id;
        }, $body);

        $languages = Language::where('is_active', true)
            ->where('code', '!=', $request->from)
            ->get();

        $translations = [];

        foreach ($languages as $lang) {
            // 2. KIRIM KE AI (Hanya teks dan placeholder gambar)
            $result = $this->translator->translate(
                new TranslationRequest(
                    text: json_encode([
                        'title' => $request->title, 
                        'body'  => $bodyWithPlaceholders
                    ]),
                    from: $request->from,
                    to: $lang->code
                )
            );

            $decoded = json_decode($result->translatedText ?? '[]', true);
            $translatedBody = $decoded['body'] ?? $bodyWithPlaceholders;

            // 3. KEMBALIKAN GAMBAR (Replace placeholder dengan tag img asli)
            foreach ($images as $id => $originalImgTag) {
                $translatedBody = str_replace($id, $originalImgTag, $translatedBody);
            }

            $translations[$lang->id] = [
                'title' => $decoded['title'] ?? 'Hasil gagal',
                'body'  => $translatedBody
            ];
        }

        return response()->json([
            'success' => true, 
            'translations' => $translations
        ]);

    } catch (\Throwable $e) {
        Log::error("[CONTENT TRANSLATE ERROR]: " . $e->getMessage());
        return response()->json([
            'success' => false, 
            'message' => 'Terjadi kesalahan saat memproses tabel atau gambar.'
        ], 500);
    }
}
}