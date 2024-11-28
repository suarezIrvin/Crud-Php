<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductPdfController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts',[PostController::class,'index']);
Route::get('/dash',[PostController::class,'dashboard']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Ruta para dashboard usando el controlador PostController
    Route::get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard');
});

Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{articulo}/edit', [PostController::class, 'edit']);
Route::put('/posts/{articulo}/update', [PostController::class, 'update']);
Route::delete('/posts/{articulo}/delete', [PostController::class, 'destroy']);
Route::get('/productos/pdf', [ProductPdfController::class, 'generatePdf'])->name('productos.pdf');
Route::get('storage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    return response()->file($path);
});







