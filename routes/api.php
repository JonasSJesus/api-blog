<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;


// Rotas CRUD incluidas de forma dinamica
Route::apiResource('blog', BlogController::class);

// Rotas de buscas personalizadas
Route::get('/blog/category/{category}', [BlogController::class, 'showByCategory'])
    ->whereAlpha("category");

Route::get('/blog/title/{title}', [BlogController::class, 'showByTitle'])
    ->whereAlpha("title");
    
Route::get('/blog/author/{author}', [BlogController::class, 'showByAuthor'])
    ->whereAlpha("author");
