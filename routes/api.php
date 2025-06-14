<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;


// Rotas CRUD incluidas de forma dinamica
Route::apiResource('blog', BlogController::class);

// Rotas de buscas personalizadas
Route::get('/blog/category/{category}', [BlogController::class, 'showByCategory']);
Route::get('/blog/title/{title}', [BlogController::class, 'showByTitle']);
