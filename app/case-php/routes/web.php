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

Route::get('/get-api-token', [App\Http\Controllers\ApiTokenController::class, 'update'])
    ->name('get-api-token');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');


Route::post('xml-file', [App\Http\Controllers\XMLFileController::class, 'upload'])
    ->middleware('auth')
    ->name('xml-file.upload');
