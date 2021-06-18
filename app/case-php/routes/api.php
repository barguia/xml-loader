<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Resources\XMLFileCollection;
use App\Models\XMLFile;

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

Route::post('/login', [\App\Http\Controllers\ApiTokenController::class, 'login']);

Route::get('/xml-file', function() {
    $files = XMLFile::with('failures')->with('user')->get();
    return new XMLFileCollection($files);
})->middleware('auth:api');

Route::get('/xml-file/{id}', function($id) {
    return new XMLFileCollection([
        XMLFile::with('failures')->with('user')->findOrFail($id)
    ]);
})->middleware('auth:api');
