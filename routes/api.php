<?php

use App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::post('/login', [Api\Auth\AuthController::class, 'login'])->name('api.login');
//Route::post('/registration', [Api\Registration\RegistrationController::class, 'register'])->name('api.register');
//Route::post('/forgot-password', [Api\Auth\ResetPasswordController::class, 'forgot'])
//    ->name('api.forgot-password');
//Route::post('/reset-password', [Api\Auth\ResetPasswordController::class, 'reset'])
//    ->name('api.reset-password');
//Route::get('/email/verify', Api\Auth\EmailVerificationController::class)
//    ->name('api.verification.verify');

//Route::group(['middleware' => ['auth:sanctum']], function () {
//    Route::post('/logout', [Api\Auth\AuthController::class, 'logout'])->name('api.logout');
//});

// passport
// Register Route
Route::post('/register', [Api\Registration\RegistrationController::class, 'register']);
// Login Route
Route::post('/login', [Api\Auth\AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    //logout
    Route::get('/logout', [Api\Auth\AuthController::class, 'logout'])->name('logout.api');
});

//Oauth with passport
Route::post('/auth/Oauth', [Api\Auth\AuthController::class, 'oauth'])->name('oauth.simulate');
