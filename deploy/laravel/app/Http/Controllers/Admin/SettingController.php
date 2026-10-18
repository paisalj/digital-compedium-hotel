<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SettingTranslation;
use App\Models\Language;
use App\Models\AiApiKey;
use App\Services\AI\TranslationService;
use App\Services\AI\DTO\TranslationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Media;

class SettingController extends Controller
{
    protected TranslationService $translator;

    public function __construct(TranslationService $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Menampilkan halaman pengaturan utama website
     */
    public function index()
    {
        $settings = Setting::with('translations.language')->get();
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        
        // Ambil data media untuk modal Media Library
        $media = Media::latest()->get(); 

        return view('admin.settings.index', compact('settings', 'languages', 'media'));
    }

    /**
     * Memperbarui data pengaturan website beserta terjemahannya (Multibahasa)
     */
public function update(Request $request)
    {
        // Gunakan Transaction agar jika salah satu simpan gagal, database rollback otomatis
        DB::beginTransaction();

        try {
            // 1. UPDATE BAHASA UTAMA (Tabel settings)
            // Mengambil input dari name="settings[id_setting]"
            $settingsData = $request->input('settings', []);

            foreach ($settingsData as $settingId => $value) {
                $setting = Setting::find($settingId);
                if ($setting) {
                    $setting->update([
                        'value' => $value // Nilai default bahasa utama disimpan di sini
                    ]);
                }
            }

            // 2. UPDATE BAHASA TERJEMAHAN (Tabel setting_translations)
            // Mengambil input dari name="translations[id_bahasa][id_setting]"
            $translationsData = $request->input('translations', []);

            foreach ($translationsData as $languageId => $settings) {
                foreach ($settings as $settingId => $value) {
                    
                    // 🔥 PEMBERSIH DATABASE: Jika nilainya kosong atau null (seperti logo/background)
                    if (is_null($value) || trim($value) === '') {
                        // Otomatis hapus data lamanya di database jika ada, biar tabel bersih total
                        SettingTranslation::where([
                            'setting_id'  => $settingId,
                            'language_id' => $languageId,
                        ])->delete();
                        
                        continue; // Lewati ke perulangan berikutnya, jangan buat baris baru
                    }

                    // Gunakan updateOrCreate untuk memasukkan data baru 
                    // atau mengupdate data terjemahan yang sudah ada di database
                    SettingTranslation::updateOrCreate(
                        [
                            'setting_id'  => $settingId,
                            'language_id' => $languageId,
                        ],
                        [
                            'value' => $value // Nilai terjemahan disimpan di kolom generic 'value'
                        ]
                    );
                }
            }

            // Jika semua proses berhasil tanpa error, commit ke database
            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Pengaturan website berhasil diperbarui!');

        } catch (\Throwable $e) {
            // Jika ada error di tengah jalan, batalkan semua perubahan database
            DB::rollBack();

            // Catat detail error ke file storage/logs/laravel.log agar mudah didebug
            Log::error("[UPDATE SETTINGS FAILED]: " . $e->getMessage() . "\n" . $e->getTraceAsString());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage());
        }
    }
    
    /**
     * Menerjemahkan teks pengaturan (Settings) menggunakan sistem rotasi API Key AI
     */
    public function translate(Request $request)
    {
        Log::info("=========================================");
        Log::info("[AI TRANSLATE SETTINGS] Memulai proses terjemahan untuk: '" . $request->text . "'");

        try {
            $sourceText = $request->text;
            
            $defaultLanguage = Language::where('is_default', true)->first();
            $fromCode = $defaultLanguage ? $defaultLanguage->code : 'id';

            $targetLanguages = Language::where('is_default', false)
                ->where('is_active', true)
                ->get();

            // 1. Ambil semua API Key AI yang aktif dari database
            $apiKeys = AiApiKey::where('is_active', 1)
                ->orderBy('id', 'asc')
                ->get();

            if ($apiKeys->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada API Key AI aktif yang dikonfigurasi di database.'
                ], 500);
            }

            $results = [];

            // Loop untuk setiap bahasa target
            foreach ($targetLanguages as $lang) {
                $finalText = null;
                $successWithKey = false;

                // 2. LOOP ROTASI: Coba setiap API Key yang ada di database sampai berhasil
                foreach ($apiKeys as $index => $apiKey) {
                    Log::info("[AI KEY MANAGER SETTINGS] Mencoba Kunci Ke-" . ($index + 1) . " untuk bahasa {$lang->code}");

                    try {
                        // Jalur penyelamat jika method setApiKey tidak didukung oleh Translator Service Anda
                        if (method_exists($this->translator, 'setApiKey')) {
                            $this->translator->setApiKey($apiKey->key);
                        } else {
                            $this->translator->apiKey = $apiKey->key;
                        }

                        $translatedName = $this->translator->translate(
                            new TranslationRequest(
                                text: $sourceText,
                                from: $fromCode,
                                to: $lang->code
                            )
                        );

                        // Cek jika ada error dari service AI
                        $isError = isset($translatedName->error) || (isset($translatedName->success) && !$translatedName->success);
                        
                        if (!$isError) {
                            // Ambil teks hasil terjemahan jika sukses
                            $finalText = $translatedName->translatedText 
                                         ?? $translatedName->text 
                                         ?? (is_string($translatedName) ? $translatedName : null);
                            
                            if ($finalText) {
                                $successWithKey = true;
                                Log::info("[AI TRANSLATE SETTINGS] ---> Kunci Ke-" . ($index + 1) . " BERHASIL: '{$finalText}'");
                                break; // Sukses! Keluar dari loop kunci, lanjut ke bahasa berikutnya
                            }
                        }

                        Log::warning("[AI TRANSLATE SETTINGS] Kunci Ke-" . ($index + 1) . " memberikan respon error. Mencoba kunci cadangan berikutnya...");

                    } catch (\Throwable $keyException) {
                        Log::error("[AI TRANSLATE SETTINGS] Kunci Ke-" . ($index + 1) . " Gagal/Crash: " . $keyException->getMessage());
                        continue; // Lanjut ke kunci cadangan berikutnya di database
                    }
                }

                // 3. Jika setelah memutar semua kunci tetap gagal menerjemahkan bahasa ini
                if (!$successWithKey || is_null($finalText)) {
                    throw new \Exception("Semua kuota cadangan API Key AI Anda telah habis atau sedang sibuk.");
                }
                
                // Index 'value' sesuai dengan target output pembacaan JavaScript di Blade Anda
                $results[$lang->id] = [
                    'value' => $finalText
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Terjemahan AI berhasil diterapkan menggunakan sistem rotasi!',
                'translations' => $results
            ]);

        } catch (\Throwable $e) {
            Log::error("[AI TRANSLATE SETTINGS ERROR] Gagal Total: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Token semua kunci telah habis, akan di reset dalam waktu 10-15 menit jangan di klik terjemahan nya.',
            ], 500);
        }
    }
}