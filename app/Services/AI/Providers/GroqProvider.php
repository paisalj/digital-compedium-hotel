<?php

namespace App\Services\AI\Providers;

use App\Services\AI\Contracts\TranslationProvider;
use App\Services\AI\DTO\TranslationResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqProvider implements TranslationProvider
{
    public function translate(string $text, string $from, string $to): TranslationResult
    {
        $apiKey = config('services.groq.api_key');
        $baseUrl = config('services.groq.base_url', 'https://api.groq.com/openai/v1');
        $model = config('services.groq.model', 'llama-3.3-70b-versatile');

        // 1. CEK APA YANG MASUK KE PROVIDER
        Log::info("DEBUG GROQ - Dari: {$from} | Ke: {$to} | Teks: {$text}");

        $response = Http::withoutVerifying()
            ->withToken($apiKey)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post("{$baseUrl}/chat/completions", [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $text // Menggunakan prompt utuh dari TranslationPrompt
                    ]
                ],
                'temperature' => 0.0,

                // ⬇️ TAMBAHKAN BARIS INI DI SINI ⬇️
                'max_tokens' => 4096,
            ]);

        // 2. CEK APA RESPON MENTAH DARI API GROQ
        Log::info("DEBUG GROQ - Respon Mentah API:", [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if (!$response->successful()) {
            throw new \Exception('Gagal terjemahan via Groq: ' . $response->body());
        }

        $result = $response->json();
        $translatedText = trim($result['choices'][0]['message']['content'] ?? '');
        $translatedText = trim($translatedText, '"\'');

        // 3. CEK HASIL AKHIR SEBELUM DIKEMBALIKAN
        Log::info("DEBUG GROQ - Hasil Akhir Terjemahan: " . $translatedText);

        // Menggunakan Named Arguments agar variabel terisi tepat pada propertinya
        return new TranslationResult(
            translatedText: $translatedText,
            sourceLanguage: $from,
            targetLanguage: $to,
            success: true,
            provider: 'groq'
        );
    }
}