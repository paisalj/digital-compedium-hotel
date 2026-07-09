<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\AiApiKeyController;
use App\Http\Controllers\Admin\ContentController; // 👈 BERHASIL DITAMBAHKAN DI SINI

/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])
        ->name('login.authenticate');

});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    */

    Route::resource('admin/languages', LanguageController::class)
        ->names('admin.languages');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | Category Recycle Bin
            |--------------------------------------------------------------------------
            | HARUS di atas Route::resource()
            |--------------------------------------------------------------------------
            */

            Route::prefix('categories')
                ->name('categories.')
                ->group(function () {

                    Route::get('/trash', [CategoryController::class, 'trash'])
                        ->name('trash');

                    Route::patch('/{category}/restore', [CategoryController::class, 'restore'])
                        ->withTrashed()
                        ->name('restore');

                    Route::delete('/{category}/force-delete', [CategoryController::class, 'forceDelete'])
                        ->withTrashed()
                        ->name('forceDelete');

                    // ✨ RUTE YANG BENAR DAN AMAN TETAP DI SINI
                    Route::post('/update-order', [CategoryController::class, 'updateOrder'])
                        ->name('updateOrder');

                });

            Route::post(
                'categories/translate',
                [CategoryController::class, 'translate']
            )->name('categories.translate');

            /*
            |--------------------------------------------------------------------------
            | Category CRUD
            |--------------------------------------------------------------------------
            */

            Route::resource('categories', CategoryController::class);

            /*
            |--------------------------------------------------------------------------
            | Content CRUD & Custom Routes
            |--------------------------------------------------------------------------
            */
            
            // ✨ 1. RUTE BARU UNTUK TERJEMAHAN KONTEN DITAMBAHKAN DI SINI (DI ATAS RESOURCE)
            Route::post(
                'contents/translate',
                [ContentController::class, 'translate']
            )->name('contents.translate');

            // 2. RUTE BAWAAN RESOURCE KONTEN
            Route::resource('contents', ContentController::class);

            /*
            |--------------------------------------------------------------------------
            | AI API Key Manager CRUD
            |--------------------------------------------------------------------------
            */
            Route::resource('ai-api-keys', AiApiKeyController::class);

        });

});

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');