<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';

$app->make(
    Illuminate\Contracts\Console\Kernel::class
)->bootstrap();

use App\Services\AI\TranslationService;
use App\Services\AI\DTO\TranslationRequest;

$service = new TranslationService();

$result = $service->translate(
    new TranslationRequest(
        text: 'Kamar Deluxe',
        from: 'id',
        to: 'en'
    )
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