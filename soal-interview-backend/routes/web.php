<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('books/{id}/edit', [BookController::class, 'edit']);
Route::get('categories/{id}/edit', [CategoryController::class, 'edit']);
Route::get('books/create', [BookController::class, 'create']);
Route::get('category/create', [CategoryController::class, 'create']);



