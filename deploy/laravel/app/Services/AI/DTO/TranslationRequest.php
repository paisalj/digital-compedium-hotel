<?php

declare(strict_types=1);

namespace App\Services\AI\DTO;

/**
 * Data Transfer Object for translation requests.
 */
class TranslationRequest
{
    /**
     * Create a new translation request.
     *
     * @param string $text Original text.
     * @param string $from Source language code.
     * @param string $to Target language code.
     */
    public function __construct(
        public string $text,
        public string $from,
        public string $to,
    ) {
    }
}