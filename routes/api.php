<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FollowingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::resource('books', BookController::class);

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/books/{id}/collections', [BookController::class, 'get_collections']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/books', [BookController::class, 'store']);
    Route::post('/collections', [CollectionController::class, 'store']);
    Route::post('/following/follow/', [FollowingsController::class, 'followUser']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/books/reading/{id}', [BookController::class, 'addBook']);
    Route::put('/books/reading/{id}', [BookController::class, 'updateBook']);
    Route::delete('/books/reading/{id}', [BookController::class, 'removeBook']);
    Route::get('/users/reading', [BookController::class, 'getReadingBooks']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/users/toberead', [BookController::class, 'getToBeReadBooks']);
    Route::get('/users/collections', [CollectionController::class, 'user_collections']);
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::get('/books/{id}/ratings', [BookController::class, 'get_ratings']);
    Route::get('/books/search/{title}', [BookController::class, 'search']);
    Route::get('/following/followings', [AuthController::class, 'getFollowings']);
    Route::get('/following/followers', [AuthController::class, 'getFollowers']);
    Route::put('/users/editprofile', [AuthController::class, 'update']);
    Route::get('/books/{id}/img', [BookController::class, 'returnImg']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
