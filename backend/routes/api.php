<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AircraftsController;
use App\Http\Controllers\Api\FlightsController;
use App\Http\Controllers\Api\PilotsController;
use App\Http\Controllers\Api\FilesController;

Route::get('analytics', fn() => Storage::disk('local')->get('analytics.json'))->middleware('auth:api');

Route::post('file/upload/{table}/{column}', [FilesController::class, 'uploadFile']);
Route::get('file/download', [FilesController::class, 'download']);

Route::get('/email/verify/{id}/{hash}', [UsersController::class, 'verifyEmail'])
    ->middleware(['signed'])->name('verification.verify');

Route::group([
    'middleware' => 'auth:api',
], function() {

    Route::get('users/autocomplete', [UsersController::class, 'findAllAutocomplete']);
    Route::get('users/count', [UsersController::class, 'count']);
    Route::resource('users', UsersController::class);

    Route::get('aircrafts/autocomplete', [AircraftsController::class, 'findAllAutocomplete']);
    Route::get('aircrafts/count', [AircraftsController::class, 'count']);
    Route::resource('aircrafts', AircraftsController::class);

    Route::get('flights/autocomplete', [FlightsController::class, 'findAllAutocomplete']);
    Route::get('flights/count', [FlightsController::class, 'count']);
    Route::resource('flights', FlightsController::class);

    Route::get('pilots/autocomplete', [PilotsController::class, 'findAllAutocomplete']);
    Route::get('pilots/count', [PilotsController::class, 'count']);
    Route::resource('pilots', PilotsController::class);

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function () {
    Route::any('signin/local', [AuthController::class, 'login'])->name('login');
    Route::put('verify-email', [UsersController::class, 'sendVerifyEmail']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('signin/google', [UsersController::class, 'signinGoogle']);
    Route::get('google/callback', [UsersController::class, 'callbackGoogle']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::put('password-update', [AuthController::class, 'passwordUpdate']);
    Route::post('send-password-reset-email', [AuthController::class, 'sendPasswordResetEmail']);
});
