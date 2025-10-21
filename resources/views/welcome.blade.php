@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 text-white">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                Platform Cryptocurrency
                <span class="block text-yellow-400">Terpercaya di Indonesia</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
                Monitor, analisis, dan kelola portfolio cryptocurrency Anda dengan mudah dan aman
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                <a href="/register" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 text-lg font-semibold">
                    Mulai Gratis
                </a>
                <a href="/market" class="btn-secondary border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 text-lg font-semibold">
                    Lihat Pasar
                </a>
                @else
                <a href="/dashboard" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 text-lg font-semibold">
                    Dashboard Saya
                </a>
                <a href="/market" class="btn-secondary border-2 border-white text-white hover:bg-white hover:text-blue-600 px-8 py-4 text-lg font-semibold">
                    Lihat Pasar
                </a>
                @endguest
            </div>
        </div>
    </div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-yellow-400 rounded-full opacity-20 animate-pulse-slow"></div>
        <div class="absolute top-1/2 -right-10 w-60 h-60 bg-blue-400 rounded-full opacity-20 animate-pulse-slow" style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-10 left-1/4 w-32 h-32 bg-purple-400 rounded-full opacity-20 animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">500K+</div>
                <div class="text-gray-600 dark:text-gray-400">Pengguna Aktif</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">10K+</div>
                <div class="text-gray-600 dark:text-gray-400">Transaksi/Hari</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">100+</div>
                <div class="text-gray-600 dark:text-gray-400">Cryptocurrency</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-2">24/7</div>
                <div class="text-gray-600 dark:text-gray-400">Support</div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Fitur Unggulan Kami
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Nikmati berbagai fitur canggih untuk trading cryptocurrency Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card text-center hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Real-time Analytics
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Monitor harga cryptocurrency secara real-time dengan grafik interaktif dan analisis mendalam
                </p>
            </div>
            
            <div class="card text-center hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Portfolio Management
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Kelola portfolio cryptocurrency Anda dengan mudah dan pantau profit/loss secara real-time
                </p>
            </div>
            
            <div class="card text-center hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Keamanan Terjamin
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Sistem keamanan berlapis dengan enkripsi data dan autentikasi dua faktor
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Trending Cryptocurrencies -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Cryptocurrency Trending
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                Pantau pergerakan cryptocurrency populer saat ini
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" x-data="cryptoPrice">
            @foreach(\App\Models\Cryptocurrency::where('is_active', true)->take(8)->get() as $crypto)
            <div class="crypto-card" data-symbol="{{ $crypto->symbol }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-400 rounded-full mr-3"></div>
                        <div>
                            <div class="font-semibold">{{ $crypto->symbol }}</div>
                            <div class="text-sm text-gray-400">{{ $crypto->name }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold">${{ number_format($crypto->current_price, 2) }}</div>
                        <div class="text-sm" :class="change >= 0 ? 'text-green-400' : 'text-red-400'">
                            {{ $crypto->change_24h >= 0 ? '+' : '' }}{{ number_format($crypto->change_percent_24h, 2) }}%
                        </div>
                    </div>
                </div>
                <div class="h-16 bg-gray-700 rounded-lg flex items-center justify-center">
                    <span class="text-gray-400 text-sm">Chart {{ $crypto->symbol }}</span>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="/market" class="btn-primary">
                Lihat Semua Cryptocurrency
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
            Siap Memulai Perjalanan Crypto Anda?
        </h2>
        <p class="text-xl mb-8 text-blue-100">
            Bergabunglah dengan ribuan trader yang telah mempercayai platform kami
        </p>
        @guest
        <a href="/register" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 text-lg font-semibold">
            Daftar Sekarang Gratis
        </a>
        @else
        <a href="/dashboard" class="btn-primary bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 text-lg font-semibold">
            Menuju Dashboard
        </a>
        @endguest
    </div>
</section>
@endsection