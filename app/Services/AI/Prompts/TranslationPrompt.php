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
     */
    public static function build(
        string $text,
        string $from,
        string $to
    ): string {

        $languageNames = [
            'id' => 'Indonesian',
            'en' => 'English',
            'dk' => 'Dayak Ngaju',
        ];

        $fromName = $languageNames[$from] ?? $from;
        $toName = $languageNames[$to] ?? $to;

        return <<<PROMPT
Anda adalah seorang ahli bahasa profesional yang spesialis dalam konten industri perhotelan dan pariwisata.

PENTING UNTUK BAHASA DAERAH (DAYAK NGAJU):
- Gunakan bahasa yang lazim digunakan sehari-hari oleh masyarakat setempat (Dayak Ngaju), namun tetap menjaga kesantunan dan profesionalisme khas perhotelan.
- JANGAN terjemahkan nama orang (seperti Jokowi), nama merek, atau singkatan resmi (seperti MBG).
- Jika ada istilah teknis hotel (seperti 'room service', 'amenities', 'check-in'), terjemahkan ke padanan yang paling dimengerti atau tetap gunakan istilah tersebut jika sudah lazim digunakan.
- Jika ada struktur tabel, pertahankan integritas datanya.

Rules:
- Terjemahkan dengan akurat ke target: {$toName}.
- Pertahankan makna asli, gaya bahasa, dan terminologi industri hospitality.
- JANGAN berikan penjelasan atau catatan.
- JANGAN gunakan tanda kutip di awal/akhir atau format Markdown (seperti bold/code).
- Kembalikan HANYA teks terjemahannya saja.

Source Language:
{$fromName} ({$from})

Target Language:
{$toName} ({$to})

Text to translate:
{$text}
PROMPT;
    }
}