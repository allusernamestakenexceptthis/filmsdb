<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\DecodeUrls;

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

Route::middleware(['throttle:token'])->group(function () {
    Route::post('/get/token', [AuthController::class, "getToken"]);
});

/*
 *   Movie routes
 */
Route::get('/movies', [MovieController::class , 'getMovies'])->middleware(DecodeUrls::class);
Route::get('/movies/{id}', [MovieController::class , 'getMovie']);

/*
 *   User routes
 */

Route::middleware(['auth:sanctum', 'ability:user_access'])->group(function () {
    Route::get('/favorites', [UserController::class , 'getFavoriteMovies']);
    Route::post('/favorites/{id}', [UserController::class , 'addFavoriteMovie']);
    Route::delete('/favorites/{id}', [UserController::class , 'removeFavoriteMovie']);
    //Route::get('/me', [UserController::class , 'getUsers'])
});

/*
 *   Admin routes
 */
/*
Route::get('/users', [UserController::class , 'getUsers'])->middleware(['auth:sanctum', 'abilities:admin_access']);
Route::post('/movies', [MovieController::class , 'addMovie'])->middleware(['auth:sanctum', 'abilities:admin_access']);
Route::patch('/movies/{id}', [MovieController::class , 'updateMovie'])->middleware(['auth:sanctum', 'abilities:admin_access']);
Route::delete('/movies/{id}', [MovieController::class , 'deleteMovie'])->middleware(['auth:sanctum', 'abilities:admin_access']);*/