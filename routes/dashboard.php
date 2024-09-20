<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'controller' => AuthController::class], function () {
    Route::post('/sign-in', 'signIn')->name('sign-in');
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'controller' => UserController::class], function () {
    Route::post('/', 'createUser')->name('create-user');
    Route::get('/list', 'listUsers')->name('list-users');
});
