<?php

declare(strict_types=1);

namespace App\Services\AI;

use InvalidArgumentException;
use App\Services\AI\Contracts\TranslationProvider;
use App\Services\AI\DTO\TranslationRequest;
use App\Services\AI\DTO\TranslationResult;
use App\Services\AI\Prompts\TranslationPrompt;
use App\Services\AI\Providers\GeminiProvider;
use Illuminate\Support\Facades\Cache; // <--- 1. TAMBAHKAN INI UNTUK CACHING

/**
 * Translation Service.
 *
 * Responsible for handling all translation requests
 * using the configured AI provider.
 */
class TranslationService
{
    /**
     * Active translation provider.
     */
    protected TranslationProvider $provider;

    public function __construct(
        ?TranslationProvider $provider = null
    ) {
        $this->provider = $provider ?? $this->resolveProvider();
    }

    /**
     * Resolve translation provider from configuration.
     */
    protected function resolveProvider(): TranslationProvider
    {
        return match (config('ai.provider')) {

            'gemini' => new GeminiProvider(),

            default => new GeminiProvider(),

        };
    }

    /**
     * Translate a single text.
     * 
     * Menerjemahkan teks tunggal dengan sistem Cache untuk menghemat kuota AI.
     */
    public function translate(
        TranslationRequest $request
    ): TranslationResult {

        // 2. UBAH BAGIAN INI: Membuat key unik berdasarkan teks dan bahasa target
        $cacheKey = "ai_trans_" . md5(strtolower(trim($request->text))) . "_{$request->from}_{$request->to}";

        // Menyimpan hasil di memori selama 30 hari (60 detik * 60 menit * 24 jam * 30 hari)
        return Cache::remember($cacheKey, 60 * 60 * 24 * 30, function () use ($request) {
            
            // Kode asli Anda dipindahkan ke dalam fungsi penampung ini
            $prompt = TranslationPrompt::build(
                $request->text,
                $request->from,
                $request->to
            );

            return $this->provider->translate(
                $prompt,
                $request->from,
                $request->to
            );
            
        });
    }

    /**
     * Translate multiple texts.
     *
     * @param TranslationRequest[] $requests
     *
     * @return TranslationResult[]
     */
    public function translateBatch(array $requests): array
    {
        if (empty($requests)) {
            return [];
        }

        $results = [];

        foreach ($requests as $request) {

            if (! $request instanceof TranslationRequest) {
                throw new InvalidArgumentException(
                    'translateBatch() hanya menerima array TranslationRequest.'
                );
            }

            $results[] = $this->translate($request);
        }

        return $results;
    }
}