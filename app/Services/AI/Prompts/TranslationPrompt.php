<?php

declare(strict_types=1);

namespace App\Services\AI\Prompts;

/**
 * Builds translation prompts for AI providers.
 */
class TranslationPrompt
{
    /**
     * Build translation prompt.
     *
     * @param string $text Original text.
     * @param string $from Source language.
     * @param string $to Target language.
     *
     * @return string
     */
public static function build(
        string $text,
        string $from,
        string $to
    ): string {

        // Tambahkan pemetaan nama bahasa di sini agar AI tidak bingung
        $languageNames = [
            'id' => 'Indonesian',
            'en' => 'English',
            'dk' => 'Dayak Ngaju', // Tambahkan pemetaan ini
        ];

        $fromName = $languageNames[$from] ?? $from;
        $toName = $languageNames[$to] ?? $to;

        return <<<PROMPT
You are a professional hotel translator.

Your task is to translate hotel-related content accurately and naturally.

Rules:

- Translate accurately into the target language: {$toName}.
- Preserve the original meaning.
- Use natural and fluent language.
- Use hospitality terminology when appropriate.
- Do NOT explain.
- Do NOT add notes.
- Do NOT add quotation marks.
- Do NOT use Markdown.
- Return ONLY the translated text.

Source Language:
{$fromName} ({$from})

Target Language:
{$toName} ({$to})

Text:
{$text}
PROMPT;
    }
    }