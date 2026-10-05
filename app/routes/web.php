<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'register')->name('register');
Route::post('/register', [RegistrationController::class, 'store']);

Route::controller(GameController::class)->prefix('game/{user:link_token}')->name('game.')->group(function () {
    Route::get('/', 'show')->name('show');
});
