<?php

declare(strict_types=1);

namespace App\Services\AI\DTO;

/**
 * Data Transfer Object for translation results.
 */
class TranslationResult
{
    /**
     * Create a translation result.
     */
    public function __construct(

        public bool $success,

        public string $translatedText,

        public string $provider,

        public string $model = '',

        public string $sourceLanguage = '',

        public string $targetLanguage = '',

        public int $tokens = 0,

        public float $executionTime = 0,

        public bool $cached = false,

        public ?string $error = null,

    ) {
    }

    /**
     * Convert result to array.
     */
    public function toArray(): array
    {
        return [

            'success' => $this->success,

            'translated_text' => $this->translatedText,

            'provider' => $this->provider,

            'model' => $this->model,

            'source_language' => $this->sourceLanguage,

            'target_language' => $this->targetLanguage,

            'tokens' => $this->tokens,

            'execution_time' => $this->executionTime,

            'cached' => $this->cached,

            'error' => $this->error,

        ];
    }
}