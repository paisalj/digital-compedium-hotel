<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\AI\Providers\GeminiProvider;

echo config('ai.gemini.api_key').PHP_EOL;

$provider = new GeminiProvider();

$result = $provider->translate(
    'Halo Dunia',
    'id',
    'en'
);

echo PHP_EOL;
echo "SUCCESS : ";
var_dump($result->success);

echo PHP_EOL;
echo "TRANSLATION :" . PHP_EOL;
var_dump($result->translatedText);

echo PHP_EOL;
echo "ERROR :" . PHP_EOL;
var_dump($result->error);

echo PHP_EOL;
echo "PROVIDER :" . PHP_EOL;
var_dump($result->provider);