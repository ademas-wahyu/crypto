<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Crypto Portal'); ?> - Dashboard Cryptocurrency</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg mr-3"></div>
                        <span class="text-xl font-bold text-gray-900">CryptoPortal</span>
                    </div>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="/" class="border-transparent text-gray-600 hover:border-gray-300 hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">
                            Beranda
                        </a>
                        <a href="/market" class="border-transparent text-gray-600 hover:border-gray-300 hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">
                            Pasar
                        </a>
                        <?php if(auth()->guard()->check()): ?>
                        <a href="/dashboard" class="border-transparent text-gray-600 hover:border-gray-300 hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">
                            Dashboard
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if(auth()->guard()->guest()): ?>
                    <a href="/login" class="btn-primary">
                        Masuk
                    </a>
                    <a href="/register" class="btn-secondary">
                        Daftar
                    </a>
                    <?php else: ?>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-700"><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Dashboard
                            </a>
                            <a href="/portfolio" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Portfolio
                            </a>
                            <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Pengaturan
                            </a>
                            <hr class="my-1 border-gray-200">
                            <form method="POST" action="/logout">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; <?php echo e(date('Y')); ?> CryptoPortal. Semua hak dilindungi.</p>
                <p class="mt-2">Platform monitoring cryptocurrency terpercaya di Indonesia</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH /home/ademas-wahyu/vod-dev/crypto/resources/views/layouts/app.blade.php ENDPATH**/ ?>