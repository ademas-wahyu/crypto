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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cryptos', [App\Http\Controllers\API\CryptoController::class, 'index']);
Route::get('/cryptos/{symbol}', [App\Http\Controllers\API\CryptoController::class, 'show']);
Route::get('/cryptos/{symbol}/price', [App\Http\Controllers\API\CryptoController::class, 'price']);
Route::get('/cryptos/{symbol}/historical', [App\Http\Controllers\API\CryptoController::class, 'historical']);
Route::get('/trending', [App\Http\Controllers\API\CryptoController::class, 'trending']);
Route::get('/gainers', [App\Http\Controllers\API\CryptoController::class, 'gainers']);
Route::get('/losers', [App\Http\Controllers\API\CryptoController::class, 'losers']);
Route::get('/search', [App\Http\Controllers\API\CryptoController::class, 'search']);
