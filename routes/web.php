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
    Route::post('/mailverify', 'verifyEmail');  //tested OK
    Route::post('/resendcode', 'resendCode');  //tested OK
});

Route::controller(\App\Http\Controllers\Auth\LoginController::class)->group(function () {
    Route::post('/login', 'loginUser');  //tested OK
});

Route::controller(\App\Http\Controllers\Songs\SongController::class)->group(function () {
    Route::get('/getSongs', 'getSongs');
});

Route::controller(\App\Http\Controllers\Songs\AlbumController::class)->group(function () {
    Route::post('/createAlbum', 'createAlbum');
    Route::get('/getAlbumsByUser', 'getAlbumsByUser');
    Route::delete('/deleteSongFromAlbum', 'deleteSongFromAlbum');
    Route::post('/addSongToAlbum', 'addSongToAlbum');
});
