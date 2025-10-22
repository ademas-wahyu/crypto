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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {\n    return $request->user();\n});\n\nRoute::get('/cryptos', [App\Http\Controllers\API\CryptoController::class, 'index']);\nRoute::get('/cryptos/{symbol}', [App\Http\Controllers\API\CryptoController::class, 'show']);\nRoute::get('/cryptos/{symbol}/price', [App\Http\Controllers\API\CryptoController::class, 'price']);\nRoute::get('/cryptos/{symbol}/historical', [App\Http\Controllers\API\CryptoController::class, 'historical']);\nRoute::get('/trending', [App\Http\Controllers\API\CryptoController::class, 'trending']);\nRoute::get('/gainers', [App\Http\Controllers\API\CryptoController::class, 'gainers']);\nRoute::get('/losers', [App\Http\Controllers\API\CryptoController::class, 'losers']);\nRoute::get('/search', [App\Http\Controllers\API\CryptoController::class, 'search']);\n
