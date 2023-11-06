<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(RegisterController::class)->group(function () {
    Route::post('/registerDefaultUser', 'registerDefaultUser'); //tested OK
    Route::post('/registerCorporateUser', 'registerCorporateUser'); //tested OK

});

Route::controller(\App\Http\Controllers\Auth\MailVerifyController::class)->group(function () {
    Route::post('/mailverify', 'verifyEmail');
    Route::post('/resendcode', 'resendCode');
});

Route::controller(\App\Http\Controllers\Auth\LoginController::class)->group(function () {
    Route::post('/login', 'loginUser');
});
