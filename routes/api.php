<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [AuthController::class, 'login'])
    ->name('auth.login');

Route::group(['middleware' => ['checkAuth']], static function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], static function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    Route::group(['prefix' => 'users', 'as' => 'users.','controller' => UserController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::post('/','store')->name('store');
        Route::match(['put','patch'],'/{user}','update')->name('update');
        Route::delete('/{user}','destroy')->name('destroy');
    });
});


