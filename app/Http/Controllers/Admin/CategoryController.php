<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\AiApiKey;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;

use App\Services\AI\DTO\TranslationRequest;
use App\Services\AI\TranslationService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class CategoryController extends Controller
{
    protected TranslationService $translator;

    public function __construct(
        TranslationService $translator
    ) {
        $this->translator = $translator;
    }

public function index(Request $request)
{
    $query = Category::query()
        ->with(['translations.language'])
        ->withCount('contents');

    // Search
    if ($request->filled('search')) {
        $search = $request->search;

        $query->whereHas('translations', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }

    // Filter Status
    if ($request->status !== null && $request->status !== '') {
        $query->where('is_active', $request->status);
    }

    $categories = $query
        ->orderBy('sort_order')
        ->paginate(10)
        ->withQueryString();

    // Statistik
    $statistics = [
        'total' => Category::count(),
        'active' => Category::where('is_active', true)->count(),
        'inactive' => Category::where('is_active', false)->count(),
        'contents' => \App\Models\Content::count(),
    ];

    return view(
        'admin.categories.index',
        compact(
            'categories',
            'statistics'
        )
    );
}

public function updateOrder(Request $request)
{
    // Validasi input
    $request->validate([
        'orders' => 'required|array',
    ]);

    // Lakukan update ke database
    foreach ($request->orders as $id => $order) {
        \App\Models\Category::where('id', $id)->update(['sort_order' => $order]);
    }

    return redirect()->back()->with('success', 'Susunan urutan berhasil diperbarui!');
}

public function create()
    {
        $languages = Language::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view(
            'admin.categories.create',
            compact('languages')
        );
    }
public function store(
        StoreCategoryRequest $request
    ) {
        DB::beginTransaction();

        try {

            $languages = Language::query()

                ->where('is_active', true)

                ->orderBy('sort_order')

                ->get();


            $defaultLanguage = $languages->firstWhere(

                'is_default',

                true

            );

            if (! $defaultLanguage) {

                throw new \Exception(
                    'Bahasa default tidak ditemukan.'
                );

            }


            $translations = $request->input(

                'translations',

                []

            );

            $defaultTranslation = $translations[
                $defaultLanguage->id
            ] ?? null;

            if (
                ! $defaultTranslation ||
                empty($defaultTranslation['name'])
            ) {

                throw new \Exception(
                    'Nama kategori bahasa utama wajib diisi.'
                );

            }


            $sourceName = trim(
                $defaultTranslation['name']
            );

            $sourceSlug = !empty($defaultTranslation['slug']) 
                ? trim($defaultTranslation['slug']) 
                : \Illuminate\Support\Str::slug($sourceName);


            // =================================================================
            // INI BLOK CATEGORY::CREATE YANG SUDAH LENGKAP & AMAN DARI ERROR SQL
            // =================================================================
$category = Category::create([

                'name'       => $sourceName, // Terisi dari Nama Bahasa Indonesia

                'slug'       => $sourceSlug, // Terisi dari Slug Bahasa Indonesia (Mencegah error slug kosong)

                'icon'       => $request->icon,

                'is_active'  => $request->boolean('is_active'),

                'sort_order' => (
                    (Category::max('sort_order') ?? 0) + 1
                ),

            ]);
            CategoryTranslation::create([

                'category_id' => $category->id,

                'language_id' => $defaultLanguage->id,

                'name'        => $sourceName,

                'slug'        => $sourceSlug,

            ]);            


            foreach ($languages as $language) {

                if ($language->id === $defaultLanguage->id) {
                    continue;
                }

                // 1. Cek apakah kolom input di form sudah terisi (hasil AI frontend / ketik manual)
                $inputName = $request->input("translations.{$language->id}.name");

                if (!empty($inputName)) {
                    // Jika sudah ada isinya, langsung pakai dan jangan panggil AI lagi (Hemat Kuota)
                    $finalName = $inputName;
                } else {
                    // Jika kosong, baru sistem memanggil AI backend
                    $translatedName = $this->translator->translate(
                        new TranslationRequest(
                            text: $sourceName,
                            from: $defaultLanguage->code,
                            to: $language->code
                        )
                    );
                    $finalName = $translatedName->translatedText;
                }

                // 2. Buat slug secara otomatis dari nama akhir
                $slug = \Illuminate\Support\Str::slug($finalName);

                // 3. Simpan data BARU ke database
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'language_id' => $language->id,
                    'name'        => $finalName,
                    'slug'        => $slug,
                ]);

            }


            DB::commit();

            return redirect()

                ->route('admin.categories.index')

                ->with(

                    'success',

                    'Kategori berhasil ditambahkan.'

                );

        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);

            return back()

                ->withInput()

                ->with(

                    'error',

                    'Gagal menambahkan kategori. ' . $e->getMessage()

                );

        }

    }
    public function show(Category $category)
    {
        return view(
            'admin.categories.show',
            compact('category')
        );
    }

    public function edit(Category $category)
    {

        $languages = Language::query()

            ->where('is_active', true)

            ->orderBy('sort_order')

            ->get();


        $category->load([

            'translations.language',

        ]);


        return view(

            'admin.categories.edit',

            [

                'category'  => $category,

                'languages' => $languages,

            ]

        );
    }

public function update(UpdateCategoryRequest $request, Category $category)
{
    DB::beginTransaction();

    try {
        // 1. Update data dasar kategori
        $category->update([
            'icon'      => $request->icon,
            'is_active' => $request->boolean('is_active'),
        ]);

        // 2. Ambil semua bahasa aktif
        $languages = Language::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $defaultLanguage = $languages->firstWhere('is_default', true);

        if (!$defaultLanguage) {
            throw new \Exception('Bahasa default tidak ditemukan.');
        }

        // 3. Ambil data terjemahan dari request
        $translations = $request->input('translations', []);
        $defaultTranslation = $translations[$defaultLanguage->id] ?? null;

        if (!$defaultTranslation || empty($defaultTranslation['name'])) {
            throw new \Exception('Nama kategori bahasa utama wajib diisi.');
        }

        $sourceName = trim($defaultTranslation['name']);
        $sourceSlug = trim($defaultTranslation['slug'] ?? '');

        // 4. Simpan/Update terjemahan bahasa default
        CategoryTranslation::updateOrCreate(
            ['category_id' => $category->id, 'language_id' => $defaultLanguage->id],
            ['name' => $sourceName, 'slug' => $sourceSlug]
        );

        // 5. Looping terjemahan bahasa lain
        foreach ($languages as $language) {
            if ($language->id === $defaultLanguage->id) {
                continue;
            }

            // Cek input manual (hemat kuota)
            $inputName = $request->input("translations.{$language->id}.name");

            if (!empty($inputName)) {
                $finalName = $inputName;
            } else {
                // Panggil AI jika input kosong
                $translatedName = $this->translator->translate(
                    new TranslationRequest(
                        text: $sourceName,
                        from: $defaultLanguage->code,
                        to: $language->code
                    )
                );

                // Cek error dari AI
                if (!$translatedName || (isset($translatedName->error))) {
                    throw new \Exception("Gagal menerjemahkan ke {$language->code}: Limit kuota AI tercapai.");
                }

                $finalName = $translatedName->translatedText ?? '';
            }

            $slug = \Illuminate\Support\Str::slug($finalName);

            CategoryTranslation::updateOrCreate(
                ['category_id' => $category->id, 'language_id' => $language->id],
                ['name' => $finalName, 'slug' => $slug]
            );
        }

        DB::commit();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');

// Lokasi: app/Http/Controllers/Admin/CategoryController.php

} catch (\Throwable $e) {
    DB::rollBack();
    
    // Log error secara detail ke laravel.log
    \Illuminate\Support\Facades\Log::error("[UPDATE CATEGORY FAILED]: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    
    // Gunakan 'back()' dengan pesan error
    return back()
        ->withInput()
        ->with('error', 'Gagal update: ' . $e->getMessage()); // Pesan error akan muncul di halaman edit
}

}
        public function destroy(Category $category)
    {
        if ($category->contents()->exists()) {

            return redirect()

                ->route('admin.categories.index')

                ->with(

                    'error',

                    'Kategori tidak dapat dihapus karena masih memiliki konten.'

                );

        }


        if (Category::count() <= 1) {

            return redirect()

                ->route('admin.categories.index')

                ->with(

                    'error',

                    'Minimal harus ada satu kategori.'

                );

        }


        $category->delete();

        return redirect()

            ->route('admin.categories.index')

            ->with(

                'success',

                'Kategori berhasil dipindahkan ke Trash.'

            );

    }

public function trash(Request $request)
{
    $query = Category::onlyTrashed();

    // ==========================
    // Search
    // ==========================
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('slug', 'like', '%' . $request->search . '%');

        });

    }

    // ==========================
    // Filter waktu
    // ==========================
    if ($request->filled('filter')) {

        switch ($request->filter) {

            case 'today':
                $query->whereDate('deleted_at', today());
                break;

            case 'week':
                $query->whereBetween('deleted_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
                break;

            case 'month':
                $query->whereMonth('deleted_at', now()->month)
                      ->whereYear('deleted_at', now()->year);
                break;

        }

    }

$categories = $query
    ->latest('deleted_at')
    ->paginate(10)
    ->withQueryString();

    $categories->getCollection()->transform(function ($category) {

$days = floor($category->deleted_at->diffInDays(now()));

$remaining = max(0, 30 - (int) $days);
    $category->remaining_days = $remaining;

    return $category;

});
    // Statistik
    $totalDeleted = Category::onlyTrashed()->count();

    $deletedToday = Category::onlyTrashed()
        ->whereDate('deleted_at', today())
        ->count();

    $deletedThisWeek = Category::onlyTrashed()
        ->whereBetween('deleted_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])
        ->count();

    $waitingRestore = Category::onlyTrashed()->count();

    return view('admin.categories.trash', compact(
        'categories',
        'totalDeleted',
        'deletedToday',
        'deletedThisWeek',
        'waitingRestore'
    ));
}

public function restore($id)
{
    $category = Category::onlyTrashed()->findOrFail($id);

    $category->restore();

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Kategori berhasil direstore.');
}

    public function forceDelete(
        int $id
    )
    {
        $category = Category::onlyTrashed()

            ->findOrFail($id);

        if ($category->contents()->exists()) {

            return back()

                ->with(

                    'error',

                    'Kategori masih memiliki konten.'

                );

        }

        $category->forceDelete();

        return redirect()

            ->route('admin.categories.trash')

            ->with(

                'success',

                'Kategori berhasil dihapus permanen.'

            );

    }

public function translate(\Illuminate\Http\Request $request)
    {
        \Illuminate\Support\Facades\Log::info("=========================================");
        \Illuminate\Support\Facades\Log::info("[AI TRANSLATE] Memulai proses terjemahan untuk: '" . $request->text . "'");

        try {
            $sourceText = $request->text;
            
            $defaultLanguage = \App\Models\Language::where('is_default', true)->first();
            $fromCode = $defaultLanguage ? $defaultLanguage->code : 'id';

            $targetLanguages = \App\Models\Language::where('is_default', false)
                ->where('is_active', true)
                ->get();

            $results = [];

            // Looping bahasa target menggunakan TranslationService (Groq)
            foreach ($targetLanguages as $lang) {
                $translated = $this->translator->translate(
                    new TranslationRequest(
                        text: $sourceText,
                        from: $fromCode,
                        to: $lang->code
                    )
                );

                if (!isset($translated->translatedText) || empty($translated->translatedText)) {
                    throw new \Exception("Gagal menerjemahkan ke bahasa {$lang->code}");
                }

                $finalText = $translated->translatedText;

                $results[$lang->id] = [
                    'name' => $finalText,
                    'slug' => \Illuminate\Support\Str::slug($finalText),
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Terjemahan AI berhasil!',
                'translations' => $results
            ]);

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("[AI TRANSLATE ERROR] Gagal Total: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menerjemahkan: ' . $e->getMessage(),
            ], 500);
        }
    }
}