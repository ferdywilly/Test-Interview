<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// login controller
Route::post('login',[UserController::class, 'login']);
Route::post('register',[UserController::class, 'register']);

// Book controller
Route::get('books',[BookController::class, 'index']);
Route::get('books/{id}',[BookController::class, 'show']);
Route::post('books',[BookController::class, 'store']);
Route::put('books/{id}',[BookController::class, 'update']);
Route::delete('books/{id}',[BookController::class, 'destroy']);

// Route untuk peminjaman dan pengembalian
Route::post('books/{id}/borrow', [BookController::class, 'borrowBook']);
Route::post('books/{id}/return', [BookController::class, 'returnBook']);
Route::get('borrowed-books', [BookController::class, 'borrowedBooks']);

// Category controller
Route::get('categories',[CategoryController::class, 'index']);
Route::get('categories/{id}',[CategoryController::class, 'show']);
Route::post('categories',[CategoryController::class, 'store']);
Route::put('categories/{id}',[CategoryController::class, 'update']);
Route::delete('categories/{id}',[CategoryController::class, 'destroy']);
