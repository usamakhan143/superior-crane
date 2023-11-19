<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Authentication Routes
Route::post('/create-user', 'App\Http\Controllers\Apis\AccountController@create_user');
Route::put('/edit-user/{id}', 'App\Http\Controllers\Apis\AccountController@update_user');
