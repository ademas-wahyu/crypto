<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\API\CryptoController;
use App\Http\Controllers\API\PortfolioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Home Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    Route::get('/portfolio', function () {
        return view('portfolio.index');
    })->name('portfolio');
    
    Route::get('/market', [MarketController::class, 'index'])
        ->name('market');
    
    Route::get('/transactions', function () {
        return view('transactions.index');
    })->name('transactions');
    
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');
});

// API Routes
Route::prefix('api')->group(function () {
    // Public API
    Route::get('/crypto', [CryptoController::class, 'index']);
    Route::get('/crypto/trending', [CryptoController::class, 'trending']);
    Route::get('/crypto/gainers', [CryptoController::class, 'gainers']);
    Route::get('/crypto/losers', [CryptoController::class, 'losers']);
    Route::get('/crypto/search', [CryptoController::class, 'search']);
    Route::get('/crypto/price/{symbol}', [CryptoController::class, 'price']);
    Route::get('/crypto/historical/{symbol}', [CryptoController::class, 'historical']);
    Route::get('/crypto/{symbol}', [CryptoController::class, 'show']);
    
    // Protected API
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/portfolio', [PortfolioController::class, 'index']);
        Route::post('/portfolio/buy', [PortfolioController::class, 'buy']);
        Route::post('/portfolio/sell', [PortfolioController::class, 'sell']);
    });
});