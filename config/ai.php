<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default AI Provider
    |--------------------------------------------------------------------------
    */

    'provider' => env('AI_PROVIDER', 'gemini'),

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    */

    'default_source_language' => env('AI_SOURCE_LANGUAGE', 'id'),

    'default_target_language' => env('AI_TARGET_LANGUAGE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Translation
    |--------------------------------------------------------------------------
    */

    'translation' => [

        /*
        | Maksimal karakter sekali request.
        */

        'max_characters' => 10000,

        /*
        | Batch Translation
        */

        'batch_size' => 20,

        /*
        | Cache hasil translate
        */

        'cache' => true,

        /*
        | Lama cache (menit)
        */

        'cache_minutes' => 43200, // 30 hari

    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP
    |--------------------------------------------------------------------------
    */

    'http' => [

        'timeout' => env('AI_HTTP_TIMEOUT', 60),

        'retry' => env('AI_HTTP_RETRY', 3),

    ],

    /*
    |--------------------------------------------------------------------------
    | Gemini
    |--------------------------------------------------------------------------
    */

    'gemini' => [

        'api_key' => env('GEMINI_API_KEY'),

        'model' => env('GEMINI_MODEL', 'gemini-2.5-flash'),

        'base_url' => env(
            'GEMINI_BASE_URL',
            'https://generativelanguage.googleapis.com/v1beta'
        ),

    ],

    /*
    |--------------------------------------------------------------------------
    | OpenAI
    |--------------------------------------------------------------------------
    */

    'openai' => [

        'api_key' => env('OPENAI_API_KEY'),

        'model' => env('OPENAI_MODEL', 'gpt-5'),

    ],

];