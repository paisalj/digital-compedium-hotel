<?php

declare(strict_types=1);

namespace App\Services\AI\Providers;

use Throwable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\AI\Contracts\TranslationProvider;
use App\Services\AI\DTO\TranslationResult;
use App\Models\AiApiKey;

class GeminiProvider implements TranslationProvider
{
    protected string $apiKey;

    protected string $model;

    public function __construct()
    {
        $this->apiKey = (string) config('ai.gemini.api_key');
        $this->model  = (string) config('ai.gemini.model', 'gemini-2.5-flash');
    }

    public function translate(
        string $text,
        string $sourceLanguage,
        string $targetLanguage
    ): TranslationResult {

        if (trim($text) === '') {
            return new TranslationResult(
                success: false,
                translatedText: '',
                provider: 'Gemini',
                model: $this->model,
                error: 'Text kosong.'
            );
        }

        // =========================================================================
        // ALOGORITMA API KEY MANAGER (FALLBACK SYSTEM)
        // =========================================================================

        // 1. Reset otomatis kunci database yang masa pembatasan (cooldown) nya sudah terlewati
        try {
            AiApiKey::where('status', 'quota_exceeded')
                ->where('reset_quota_at', '<=', now())
                ->update([
                    'status' => 'ready',
                    'reset_quota_at' => null
                ]);
        } catch (Throwable $e) {
            Log::error('AI Key Manager: Gagal otomatis mereset status cooldown di DB', ['error' => $e->getMessage()]);
        }

        // 2. Ambil seluruh list API Key cadangan dari database yang aktif dan berstatus ready
        $dbKeys = [];
        try {
            $dbKeys = AiApiKey::where('is_active', true)
                ->where('status', 'ready')
                ->orderBy('id', 'asc')
                ->get();
        } catch (Throwable $e) {
            Log::error('AI Key Manager: Gagal memuat API Key dari DB', ['error' => $e->getMessage()]);
        }

        // 3. Satukan kunci dari DB dan kunci dari .env ke dalam satu antrean urutan kerja
        $keyQueue = [];
        foreach ($dbKeys as $dbKey) {
            $keyQueue[] = [
                'key' => $dbKey->api_key,
                'source' => 'db',
                'model' => $dbKey
            ];
        }

        // Tambahkan kunci utama .env sebagai ban serep paling akhir
        if (trim($this->apiKey) !== '') {
            $keyQueue[] = [
                'key' => $this->apiKey,
                'source' => 'env',
                'model' => null
            ];
        }

        // Jika tidak ada satu pun kunci yang bisa dipakai, langsung hentikan proses
        if (empty($keyQueue)) {
            return new TranslationResult(
                success: false,
                translatedText: '',
                provider: 'Gemini',
                model: $this->model,
                error: 'AI Translation sedang mencapai batas penggunaan. Silakan coba lagi beberapa menit.'
            );
        }

// 4. Lakukan looping mencari kunci yang valid dan sukses merespons
        foreach ($keyQueue as $index => $keyData) {
            $activeKey = $keyData['key'];

            try {
                Log::info("AI Key Manager: Mencoba Kunci Ke-" . ($index + 1) . " (Sumber: {$keyData['source']})", [
                    'text' => $text,
                    'from' => $sourceLanguage,
                    'to'   => $targetLanguage,
                ]);

                $response = Http::withoutVerifying()
                    ->retry(2, 500)
                    ->timeout(10) // Timeout lebih cepat agar rotasi instan
                    ->acceptJson()
                    ->contentType('application/json')
                    ->post(
                        "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$activeKey}",
                        ['contents' => [['parts' => [['text' => $text]]]]]
                    );

                // LOGIKA ROTASI: Jika gagal, langsung tandai dan lanjut ke key berikutnya
                if (! $response->successful()) {
                    Log::error("AI Key Manager: Kunci Ke-" . ($index + 1) . " Gagal (Status: " . $response->status() . ")");

                    if ($keyData['source'] === 'db' && $keyData['model']) {
                        $keyData['model']->update([
                            'status' => 'quota_exceeded',
                            'reset_quota_at' => now()->addMinutes(15)
                        ]);
                    }
                    continue; // PENTING: Ini yang membuat rotasi berjalan ke kunci berikutnya
                }

                // Jika Berhasil: Catat penggunaan dan kembalikan hasil
                if ($keyData['source'] === 'db' && $keyData['model']) {
                    $keyData['model']->update(['last_used_at' => now()]);
                }

                $translated = trim($response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '');

                return new TranslationResult(
                    success: true,
                    translatedText: $translated,
                    provider: 'Gemini',
                    model: $this->model,
                    sourceLanguage: $sourceLanguage,
                    targetLanguage: $targetLanguage
                );

            } catch (Throwable $e) {
                Log::error("AI Key Manager: Kunci Ke-" . ($index + 1) . " Exception", ['message' => $e->getMessage()]);
                
                // Amankan key jika error koneksi
                if ($keyData['source'] === 'db' && $keyData['model']) {
                    $keyData['model']->update([
                        'status' => 'quota_exceeded',
                        'reset_quota_at' => now()->addMinutes(15)
                    ]);
                }
                continue; // Lanjut ke key berikutnya
            }
        }
        // 5. Jika SEMUA kunci di antrean sudah habis dicoba dan gagal total
        return new TranslationResult(
            success: false,
            translatedText: '',
            provider: 'Gemini',
            model: $this->model,
            error: 'AI Translation sedang mencapai batas penggunaan. Silakan coba lagi beberapa menit.'
        );
    }
}