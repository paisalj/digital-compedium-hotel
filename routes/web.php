<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\AiApiKeyController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Group untuk semua akses Admin (harus role super_admin atau admin)
    Route::middleware('role:super_admin,admin')->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Resources Umum
        Route::resource('languages', LanguageController::class);
        Route::resource('ai-api-keys', AiApiKeyController::class);

        // Category
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');
            Route::patch('/{category}/restore', [CategoryController::class, 'restore'])->withTrashed()->name('restore');
            Route::delete('/{category}/force-delete', [CategoryController::class, 'forceDelete'])->withTrashed()->name('forceDelete');
            Route::post('/update-order', [CategoryController::class, 'updateOrder'])->name('updateOrder');
        });
        Route::post('categories/translate', [CategoryController::class, 'translate'])->name('categories.translate');
        Route::resource('categories', CategoryController::class);

        // Content
        Route::prefix('contents')->name('contents.')->group(function () {
            Route::get('/trash', [ContentController::class, 'trash'])->name('trash');
            Route::post('/{id}/restore', [ContentController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [ContentController::class, 'forceDelete'])->name('force-delete');
            Route::put('/update-order', [ContentController::class, 'updateOrder'])->name('update-order');
        });
        Route::post('contents/translate', [ContentController::class, 'translate'])->name('contents.translate');
        Route::resource('contents', ContentController::class);

        // --- Fitur Terbatas untuk Super Admin saja ---
        Route::middleware('role:super_admin')->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        });
    });
});

/* Redirect Default */
Route::redirect('/', '/login');