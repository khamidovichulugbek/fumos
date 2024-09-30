<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'controller' => AuthController::class], function () {
    Route::post('/sign-in', 'signIn')->name('sign-in');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/sign-out', 'signOut')->name('sign-out');
    });
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'user', 'as' => 'user.', 'controller' => UserController::class], function () {
        Route::post('/', 'createUser')->name('create-user');
        Route::get('/list', 'listUsers')->name('list-users');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.', 'controller' => CategoryController::class], function () {
        Route::post('/', 'createCategory')->name('create-category');
    });
});
