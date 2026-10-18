<?php

declare(strict_types=1);

namespace App\Services\AI\Contracts;

use App\Services\AI\DTO\TranslationResult;

/**
 * Contract for AI translation providers.
 *
 * Every AI provider (Gemini, OpenAI, Claude, DeepL, etc.)
 * must implement this interface.
 */
interface TranslationProvider
{
    /**
     * Translate text from one language to another.
     *
     * @param string $text Original text.
     * @param string $from Source language code.
     * @param string $to Target language code.
     *
     * @return TranslationResult
     */
    public function translate(
        string $text,
        string $from,
        string $to
    ): TranslationResult;
}