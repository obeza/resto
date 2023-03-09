<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
// use App\Http\Controllers\UserController; 
 
// use App\Http\Controllers\RestoController; 
// use App\Http\Controllers\UserApiController; 


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'dashboard']); 
// Route::get('login', [AuthController::class, 'index'])->name('login');
// Route::post('login', [AuthController::class, 'customLogin'])->name('login.post'); 
// //Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
// //Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom'); 
// Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

// Route::resource('users', UserController::class)->middleware('auth');

// // lien pour verifier l'email de l'utilisateur
// Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('auth.verify'); 

// Route::get('/api/user', [UserApiController::class, 'users'])->name('api.users')->middleware('auth');

// 

// 
