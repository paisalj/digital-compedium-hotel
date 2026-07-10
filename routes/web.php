<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\AiApiKeyController;
use App\Http\Controllers\Admin\ContentController;

/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    */
    Route::resource('admin/languages', LanguageController::class)->names('admin.languages');

    /*
    |--------------------------------------------------------------------------
    | Admin Group
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        /* Dashboard */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /* Category Recycle Bin & Custom Routes */
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');
            Route::patch('/{category}/restore', [CategoryController::class, 'restore'])->withTrashed()->name('restore');
            Route::delete('/{category}/force-delete', [CategoryController::class, 'forceDelete'])->withTrashed()->name('forceDelete');
            
            Route::post('/update-order', [CategoryController::class, 'updateOrder'])->name('updateOrder');
            // 🔴 Jalur konten yang salah di sini sudah DIHAPUS
        });

        Route::post('categories/translate', [CategoryController::class, 'translate'])->name('categories.translate');
        Route::resource('categories', CategoryController::class);

        /*
        |--------------------------------------------------------------------------
        | Content CRUD & Custom Routes
        |--------------------------------------------------------------------------
        */
        // 1. Rute Terjemahan Konten
        Route::post('contents/translate', [ContentController::class, 'translate'])->name('contents.translate');

        // ✨ 2. TEMPAT YANG BENAR: Rute Urutan Konten (Cukup tulis 'contents/update-order')
        Route::put('contents/update-order', [ContentController::class, 'updateOrder'])->name('contents.update-order');

        // 3. Rute Dasar Resource Konten
Route::get('contents/trash', [ContentController::class, 'trash'])->name('contents.trash');
Route::post('contents/{id}/restore', [ContentController::class, 'restore'])->name('contents.restore');
Route::delete('contents/{id}/force-delete', [ContentController::class, 'forceDelete'])->name('contents.force-delete');

Route::resource('contents', ContentController::class);
        /* AI API Key Manager CRUD */
        Route::resource('ai-api-keys', AiApiKeyController::class);

    });
});

/* Redirect */
Route::redirect('/', '/login');