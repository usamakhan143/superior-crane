<?php

use App\Http\Controllers\Apis\Auth\LoginController;
use App\Http\Controllers\Apis\Auth\PasswordResetController;
use App\Http\Controllers\Apis\JobController;
use App\Mail\SendOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
Route::post('login', [LoginController::class, 'mobile_sign_in']); // Mobile App Login
Route::post('web-login', [LoginController::class, 'web_sign_in']); // Web App Login
Route::post('logout', [LoginController::class, 'logout']);
Route::post('send-otp', [PasswordResetController::class, 'sendOtp']);
Route::post('verify-otp', [PasswordResetController::class, 'verifyOtp']);
Route::post('update-password', [PasswordResetController::class, 'updatePassword']);

// User CRUD
Route::post('create-user', 'App\Http\Controllers\Apis\AccountController@create_user');
Route::put('edit-user/{id}', 'App\Http\Controllers\Apis\AccountController@update_user');
Route::get('delete-user/{id}', 'App\Http\Controllers\Apis\AccountController@delete_user');

// Job CRUD
Route::get('jobs', [JobController::class, 'get_jobs']);
Route::post('create-job', [JobController::class, 'create_job']);
Route::put('edit-job/{id}', [JobController::class, 'update_job']);
