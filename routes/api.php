<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::middleware('user.active')->group(function () {
        Route::apiResource('users', UserController::class);
        
        Route::prefix('articles')->group(function () {
            Route::get('/', [ArticleController::class, 'index'])->name('articles.index')->withoutMiddleware('user.active');
            Route::get('/{article}', [ArticleController::class, 'show'])->name('articles.show')->withoutMiddleware('user.active');
            Route::post('/', [ArticleController::class, 'create'])->name('articles.create');
            Route::put('/{article}', [ArticleController::class, 'update'])->name('articles.update');
            Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
        });
        
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('categories.index')->withoutMiddleware('user.active');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show')->withoutMiddleware('user.active');
            Route::post('/', [CategoryController::class, 'create'])->name('categories.create');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });
    });
});
