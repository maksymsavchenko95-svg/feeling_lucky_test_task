<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'register')->name('register');

Route::controller(LinkController::class)->prefix('link')->name('link.')->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::put('/{user:link_token}', 'update')->name('update');
    Route::delete('/{user:link_token}', 'destroy')->name('destroy');
});

Route::controller(GameController::class)->prefix('game/{user:link_token}')->name('game.')->group(function () {
    Route::get('/', 'show')->name('show');
    Route::post('play', 'play')->name('play');
    Route::get('history', 'history')->name('history');
});
