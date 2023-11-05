<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
    Rotas de login.
*/
Route::post('login', 'API\AuthController@login');
Route::post('signup', 'API\AuthController@signup');

Route::apiResource('movie', 'API\MovieController')->only(['show', 'index']);
Route::apiResource('director', 'API\DirectorController')->only(['show', 'index']);
Route::apiResource('actor', 'API\ActorController')->only(['show', 'index']);


/* 
    Rotas de autenticação.
*/
Route::middleware(['auth:api'])->group(function () {
    
    Route::apiResource('director', 'API\DirectorController')->except(['show', 'index']);
    Route::apiResource('actor', 'API\ActorController')->except(['show', 'index']);

    Route::middleware(['admin'])->group(function () {
        Route::apiResource('movie', 'API\MovieController')->except(['show', 'index']);
    });

    Route::get('logout', 'API\AuthController@logout');
    Route::get('user', 'API\AuthController@user');

});

