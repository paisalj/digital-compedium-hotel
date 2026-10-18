<?php

namespace App\Services\AI\Prompts;

class TranslationPrompt
{
    public static function build(
        string $text,
        string $from,
        string $to
    ): string {

        $languageNames = [
            'id' => 'Indonesian',
            'en' => 'English',
            'da' => 'Dayak Ngaju',
            'dk' => 'Dayak Ngaju',
        ];

        $fromName = $languageNames[$from] ?? $from;

        $isJsonPayload = (json_decode($text, true) !== null);

        /*
        |--------------------------------------------------------------------------
        | JSON Translation
        |--------------------------------------------------------------------------
        */

        if ($isJsonPayload) {

            if ($to === 'en') {

                return implode("\n", [

                    "You are a strict JSON translation API for a CMS.",

                    "Translate the 'title' and 'body' values inside the given JSON object from {$fromName} to English.",

                    "RULES:",

                    "1. Return ONLY a valid raw JSON object with exact keys \"title\" and \"body\".",

                    "2. PRESERVE ALL HTML TAGS exactly as they are.",

                    "3. DO NOT translate room names, hotel names, numbers or proper nouns.",

                    "4. DO NOT wrap the JSON inside markdown.",

                    "",

                    $text

                ]);
            }

            if (in_array($to, ['da', 'dk'])) {

                return implode("\n", [

                    "Anda adalah API penerjemah JSON profesional.",

                    "Terjemahkan nilai JSON berikut ke Bahasa Dayak Ngaju.",

                    "",

                    "ATURAN:",

                    "1. Output HARUS berupa JSON murni.",

                    "2. Jangan mengubah struktur JSON.",

                    "3. Pertahankan seluruh tag HTML.",

                    "4. Jangan menerjemahkan nama hotel, nama ruangan, angka maupun proper noun.",

                    "5. Jangan menambahkan penjelasan.",

                    "",

                    $text

                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Translation - English
        |--------------------------------------------------------------------------
        */

        if ($to === 'en') {

            return implode("\n", [

                "You are a professional translator.",

                "Translate the following Indonesian text into English.",

                "",

                "RULES:",

                "- Return ONLY the translated text.",

                "- No explanations.",

                "- No quotation marks.",

                "- Preserve HTML tags.",

                "- Preserve hotel names, room names, numbers and proper nouns.",

                "",

                "TEXT:",

                $text

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Translation - Dayak Ngaju
        |--------------------------------------------------------------------------
        */

        if (in_array($to, ['da', 'dk'])) {

            return implode("\n", [

                "You are a professional translator of Dayak Ngaju (Central Kalimantan, Indonesia).",

                "",

                "Translate the following Indonesian text into natural Dayak Ngaju.",

                "",

                "RULES:",

                "- Return ONLY the translated text.",

                "- No explanations.",

                "- No quotation marks.",

                "- No markdown.",

                "- Preserve HTML tags.",

                "- Preserve hotel names, room names, numbers and proper nouns.",

                "- If there is no proper Dayak Ngaju equivalent, keep the Indonesian word instead of translating into English.",

                "",

                "TEXT:",

                $text

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Default
        |--------------------------------------------------------------------------
        */

        return implode("\n", [

            "Translate the following text.",

            $text

        ]);
    }
}