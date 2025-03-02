<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Category\CategoryController;
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
        Route::post('/','create')->name('create');
        Route::match(['put','patch'],'/{user}','update')->name('update');
        Route::delete('/{user}','destroy')->name('destroy');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.','controller' => CategoryController::class],static function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{category}', 'show')->name('show');
        Route::post('/','create')->name('store');
        Route::match(['put','patch'],'/{category}','update')->name('update');
        Route::delete('/{category}','destroy')->name('destroy');
    });
});


