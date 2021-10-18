<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

Route::post('/add-movie', [MovieController::class, 'add_new_movie'])->name('addNewMovie');
Route::post('/edit-movie', [MovieController::class, 'edit_movie'])->name('editMovie');
Route::post('/add-comment', [MovieController::class, 'add_comment'])->name('addComment');
Route::post('/delete-movie', [MovieController::class, 'delete_movie'])->name('deleteMovie');

Route::post('/search', [MovieController::class, 'search_movie'])->name('searchMovie');
