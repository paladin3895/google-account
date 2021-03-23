<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::any('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/oauth/{type}/callback', [App\Http\Controllers\OauthController::class, 'callback'])->name('oauth.callback');
Route::get('/oauth/{type}', [App\Http\Controllers\OauthController::class, 'oauth'])->name('oauth');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
