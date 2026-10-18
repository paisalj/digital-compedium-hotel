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


public function index(Request $request)
{
    $categories = Category::with('translations')->get();
    $languages = Language::all();

    $selectedCategory = $request->get('category_id');
    $search = $request->get('search');

$status = $request->status;

$contents = Content::query()
    ->with(['translations.language', 'category.translations'])

    ->when($selectedCategory, function ($query) use ($selectedCategory) {
        $query->where('category_id', $selectedCategory);
    })

    ->when($search, function ($query) use ($search) {
        $query->whereHas('translations', function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%");
        });
    })

    ->when($status !== null && $status !== '', function ($query) use ($status) {
        $query->where('is_active', $status);
    })

    ->orderBy('sort_order')
    ->paginate(10)
    ->withQueryString();
    // ==========================
    // Statistik
    // ==========================

    $totalContents = Content::count();

    $activeContents = Content::where('is_active', true)->count();

    $inactiveContents = Content::where('is_active', false)->count();

    $trashContents = Content::onlyTrashed()->count();

    return view('admin.contents.index', compact(
        'contents',
        'categories',
        'languages',
        'selectedCategory',

        'totalContents',
        'activeContents',
        'inactiveContents',
        'trashContents'
    ));
}
public function create()
    {
$categories = Category::with([
    'translations.language'
])->get();
        $languages = Language::where('is_active', true)->get();

$media = \App\Models\Media::all();
return view('admin.contents.create', compact('languages', 'categories', 'media'));
    }

public function store(Request $request)
{

    // 1. Validasi
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'icon' => 'nullable|string',
        'translations' => 'required|array',
    ]);

    try {
        return \DB::transaction(function () use ($request) {
            
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('contents/thumbnails', 'public');
            }

            // HITUNG URUTAN: Ambil max dari kategori terkait saja
            $nextOrder = (\App\Models\Content::where('category_id', $request->category_id)->max('sort_order') ?? 0) + 1;
            
            // SIMPAN KE CONTENT
            $content = Content::create([
                'category_id' => $request->category_id,
                'icon'        => $request->icon,
                'sort_order'  => $nextOrder, // ✨ GUNAKAN $nextOrder di sini
                'is_active'   => $request->is_active ?? true,
            ]);

            // SIMPAN TRANSLATION
            foreach ($request->translations as $langId => $translationData) {
                if (!empty($translationData['title'])) {
                    ContentTranslation::create([
                        'content_id'  => $content->id,
                        'language_id' => $langId,
                        'title'       => $translationData['title'],
                        'body'        => $translationData['body'] ?? '',
                        'slug'        => \Str::slug($translationData['title']),
                    ]);
                }
            }

            return redirect()->route('admin.contents.index')
                             ->with('success', 'Konten berhasil disimpan!');
        });

    } catch (\Exception $e) {
        \Log::error("Gagal simpan konten: " . $e->getMessage());
        return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
}
public function edit(string $id)
{
    $content = Content::findOrFail($id);
$categories = Category::with([
    'translations.language'
])->get();
    $languages = Language::where('is_active', true)->get();

    // Jalur penuh sudah benar agar tidak error class not found
    $media = \App\Models\Media::latest()->get(); 
    
    $translations = $content->translations->keyBy('language_id');

    // PERBAIKAN: Tambahkan 'media' di paling kanan compact
    return view('admin.contents.edit', compact('content', 'categories', 'languages', 'translations', 'media'));
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
        $content->sort_order = $request->sort_order ?? $content->sort_order;
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
                         ->with('success', 'Konten berhasil diperbarui!');
    }

public function destroy($id)
{
    $content = Content::findOrFail($id);
    $deletedOrder = $content->sort_order; // Simpan urutan item yang dihapus
    
    // 1. Hapus kontennya
    $content->delete();

    // 2. TATA ULANG (Reorder):
    // Cari semua konten yang urutannya lebih besar dari item yang dihapus
    $remainingContents = Content::where('sort_order', '>', $deletedOrder)->get();

    foreach ($remainingContents as $item) {
        // Kurangi angka urutannya sebanyak 1
        $item->sort_order = $item->sort_order - 1;
        $item->save();
    }

    return redirect()->route('admin.contents.index')->with('success', 'Konten dihapus dan urutan diperbarui!');
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
            // 2. KIRIM KE AI
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

            $rawText = trim($result->translatedText ?? '');

            // 🧹 BERSIHKAN MARKDOWN (Antisipasi jika AI mengirim bungkus ```json ... ```)
            $rawText = preg_replace('/^```json\s*|\s*```$/i', '', $rawText);
            $rawText = trim($rawText, " \t\n\r\0\x0B`");

            // Decode JSON dari AI
            $decoded = json_decode($rawText, true);

            // Ambil hasil terjemahan, jika gagal decode gunakan teks asli sebagai cadangan aman
            $translatedTitle = (is_array($decoded) && isset($decoded['title'])) ? $decoded['title'] : $request->title;
            $translatedBody  = (is_array($decoded) && isset($decoded['body'])) ? $decoded['body'] : $bodyWithPlaceholders;

            // 3. KEMBALIKAN GAMBAR (Replace placeholder dengan tag img asli)
            foreach ($images as $id => $originalImgTag) {
                $translatedBody = str_replace($id, $originalImgTag, $translatedBody);
            }

            $translations[$lang->id] = [
                'title' => $translatedTitle,
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
            'message' => 'Terjadi kesalahan saat memproses terjemahan: ' . $e->getMessage()
        ], 500);
    }
}

public function updateOrder(Request $request)
{
    // 1. Validasi data yang masuk wajib berupa array isi angka
    $request->validate([
        'sort_order' => 'required|array',
        'sort_order.*' => 'required|integer|min:0',
    ]);

    // 2. Lakukan looping untuk mengupdate urutan setiap konten berdasarkan ID
    foreach ($request->sort_order as $id => $order) {
        Content::where('id', $id)->update([
            'sort_order' => $order
        ]);
    }

    // 3. Kembalikan ke halaman index dengan pesan sukses
    return redirect()->route('admin.contents.index')->with('success', 'Susunan urutan konten berhasil diperbarui!');
}

public function trash(Request $request)
{
    
    $query = Content::onlyTrashed()
        ->with([
            'translations.language',
            'category.translations'
        ]);

    // Search
    if ($request->filled('search')) {

        $query->whereHas('translations', function ($q) use ($request) {

            $q->where('title', 'like', '%' . $request->search . '%');

        });

    }

    // Filter
    if ($request->filled('filter')) {

        switch ($request->filter) {

            case 'today':
                $query->whereDate('deleted_at', today());
                break;

case 'week':
    $startWeek = now()->copy()->startOfWeek();
    $endWeek   = now()->copy()->endOfWeek();

    $query->whereBetween('deleted_at', [
        $startWeek,
        $endWeek
    ]);
    break;
    
            case 'month':
                $query->whereMonth('deleted_at', now()->month)
                      ->whereYear('deleted_at', now()->year);
                break;

        }

    }

    $contents = $query
        ->latest('deleted_at')
        ->paginate(10)
        ->withQueryString();

    $contents->getCollection()->transform(function ($content) {

$daysPassed = $content->deleted_at
    ->startOfDay()
    ->diffInDays(now()->startOfDay());

$content->remaining_days = max(0, 30 - $daysPassed);

        return $content;

    });

    // Statistik
    $totalDeleted = Content::onlyTrashed()->count();

    $deletedToday = Content::onlyTrashed()
        ->whereDate('deleted_at', today())
        ->count();

$deletedThisWeek = Content::onlyTrashed()
    ->where('deleted_at', '>=', now()->subDays(7))
    ->count();

    $waitingRestore = Content::onlyTrashed()->count();

    return view('admin.contents.trash', compact(
        'contents',
        'totalDeleted',
        'deletedToday',
        'deletedThisWeek',
        'waitingRestore'
    ));
}
public function restore($id)
{
    // 1. Cari konten yang ada di trash
    $content = Content::onlyTrashed()->findOrFail($id);

    // 2. Cari angka urutan terbesar di tabel index saat ini
    $maxOrder = Content::max('sort_order');

    // 3. Berikan urutan baru agar dia berada di posisi paling bawah
    $content->sort_order = $maxOrder + 1;
    
    // ✨ TAMBAHAN: Otomatis ubah status menjadi Nonaktif (0)
    // (Silakan sesuaikan nama 'is_active' dengan nama kolom status di database Anda jika berbeda)
    $content->is_active = 0; 
    
    // 4. Restore kontennya
    $content->restore();
    $content->save();

    return redirect()->route('admin.contents.trash')->with('success', 'Konten berhasil dikembalikan ke posisi terakhir dengan status Nonaktif!');
}
public function forceDelete($id)
{
    $content = Content::onlyTrashed()->findOrFail($id);
    
    // Hapus juga data translasinya jika ada relasi cascade / manual cascading
    $content->translations()->delete(); 
    
    $content->forceDelete(); // Hapus permanen dari DB

    return redirect()->route('admin.contents.trash')->with('success', 'Konten telah dihapus permanen!');
}

}