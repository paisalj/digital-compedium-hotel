<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. TAMBAHKAN BLOK KODE HTTPS INI DI AWAL FUNGSI BOOT
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // KODE ASLI ANDA TETAP ADA DI BAWAHNYA
        $models = [
            \App\Models\Content::class,
            \App\Models\Category::class,
            \App\Models\User::class,
            \App\Models\Language::class, // Bahasa
            \App\Models\Media::class,
            \App\Models\Setting::class,
            \App\Models\AiApiKey::class, // API Key
        ];

        foreach ($models as $model) {
            $model::observe(\App\Observers\GlobalObserver::class);
        }
    }
}
