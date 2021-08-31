<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\MemberController;


use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowedBookController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\AdminusersController;

use App\Http\Controllers\Auth\ApiAuthController;



Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::get('/members/{member}', [MemberController::class, 'show']);
Route::put('/members/{member}', [MemberController::class, 'update']);
Route::delete('/members/{member}', [MemberController::class, 'destroy']);

Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{book}', [BookController::class, 'show']);
Route::put('/books/{book}', [BookController::class, 'update']);
Route::delete('/books/{book}', [BookController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);


Route::get('/booksinfo', [BorrowedBookController::class, 'index']);
Route::post('/borrowbook', [BorrowedBookController::class, 'borrowBook']);
Route::get('/availablebooks', [BorrowedBookController::class, 'available_books']);

Route::post('register', [ApiAuthController::class, 'register']);
Route::post('login', [ApiAuthController::class, 'login']);
Route::post('/borrowbook', [BorrowedBookController::class, 'borrowBook']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [ApiAuthController::class, 'userInfo']);
    Route::post('logout', [ApiAuthController::class, 'logout']);

});


