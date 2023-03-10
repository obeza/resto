<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestoApiController; 
use App\Http\Controllers\RestoController; 
use App\Http\Controllers\RubriqueController;
use App\Http\Controllers\ArticleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::get('/user', [UserApiController::class, 'users'])->name('api.users')->middleware('auth');

Route::post('login', [AuthController::class, 'customLogin'])->name('login.post')->middleware('guest');
//Route::get('resto', [RestoApiController::class, 'restos'])->name('api.restos')->middleware('guest');
Route::resource('restos', RestoController::class)->middleware('auth:sanctum');
Route::resource('resto/{resto_id}/rubriques', RubriqueController::class)->middleware('auth:sanctum');
Route::post('/rubriques/liste', [RubriqueController::class, 'updateListeOrder'])->name('rubriques.liste')->middleware('auth:sanctum');
Route::resource('rubriques/{rubrique_id}/articles',ArticleController::class)->middleware('auth:sanctum');

// fonction ajouter dans ArticleController pour mettre a jour l'ordre des articles
Route::post('/articles/liste', [ArticleController::class, 'updateListeOrder'])->name('articles.liste')->middleware('auth:sanctum');

// upload photo pour les articles du menu
Route::post('/articles/upload/{id}', [ArticleController::class, 'uploadPicture'])->name('articles.upload')->middleware('auth:sanctum');
Route::post('/articles/upload/{id}/remove', [ArticleController::class, 'uploadPictureRemove'])->middleware('auth:sanctum');