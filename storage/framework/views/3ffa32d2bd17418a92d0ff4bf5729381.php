<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dasbor Crypto</h1>
                    <p class="mt-2 text-gray-500 text-sm">
                        Pantau performa pasar cryptocurrency dan pergerakan koin terpopuler secara real-time.
                    </p>
                </div>

                <?php if($featuredCrypto): ?>
                    <div
                        class="crypto-card flex items-center justify-between w-full md:w-auto md:min-w-[320px] shadow-lg shadow-primary-900/20"
                        x-data="cryptoPrice"
                        data-symbol="<?php echo e($featuredCrypto->symbol); ?>"
                        data-price="<?php echo e((float) $featuredCrypto->current_price); ?>"
                        data-change="<?php echo e((float) $featuredCrypto->change_24h); ?>"
                        data-change-percent="<?php echo e((float) $featuredCrypto->change_percent_24h); ?>"
                    >
                        <div>
                            <p class="text-sm text-white/70">Performa Saat Ini</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-lg font-semibold"><?php echo e($featuredCrypto->symbol); ?></span>
                                <span class="text-xs bg-white/20 text-white px-2 py-1 rounded-full uppercase">
                                    Trending
                                </span>
                            </div>
                            <div class="mt-4">
                                <p class="text-2xl font-bold" x-text="Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price)"></p>
                                <p class="mt-1 text-sm" :class="priceClass">
                                    <span x-text="change >= 0 ? '+' : '-'" class="mr-1"></span>
                                    <span x-text="Math.abs(change).toFixed(2)"></span>
                                    <span class="ml-1">USD</span>
                                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs bg-white/10" x-text="`${changePercent >= 0 ? '+' : ''}${changePercent.toFixed(2)}%`"></span>
                                </p>
                            </div>
                        </div>
                        <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center">
                            <span class="text-2xl font-semibold"><?php echo e($featuredCrypto->symbol[0]); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card">
                    <p class="text-sm text-gray-500">Kapitalisasi Pasar Total</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900">
                        $<?php echo e(number_format($stats['totalMarketCap'], 0, '.', ',')); ?>

                    </p>
                    <p class="mt-1 text-xs text-gray-400">Gabungan dari <?php echo e($stats['activeCount']); ?> aset aktif.</p>
                </div>
                <div class="card">
                    <p class="text-sm text-gray-500">Volume Perdagangan 24 Jam</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900">
                        $<?php echo e(number_format($stats['totalVolume'], 0, '.', ',')); ?>

                    </p>
                    <p class="mt-1 text-xs text-gray-400">Total volume di seluruh bursa utama.</p>
                </div>
                <div class="card">
                    <p class="text-sm text-gray-500">Perubahan Rata-Rata 24 Jam</p>
                    <p class="mt-2 text-2xl font-semibold <?php echo e($stats['avgChange'] >= 0 ? 'text-emerald-500' : 'text-rose-500'); ?>">
                        <?php echo e($stats['avgChange'] >= 0 ? '+' : ''); ?><?php echo e(number_format($stats['avgChange'], 2)); ?>%
                    </p>
                    <p class="mt-1 text-xs text-gray-400">Rata-rata perubahan harga harian.</p>
                </div>
                <div class="card">
                    <p class="text-sm text-gray-500">Aset Aktif</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900"><?php echo e($stats['activeCount']); ?></p>
                    <p class="mt-1 text-xs text-gray-400">Koin dan token yang dipantau.</p>
                </div>
            </div>

            <?php if($featuredCrypto): ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="card lg:col-span-2" x-data="priceChart('<?php echo e($featuredCrypto->symbol); ?>')">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Grafik Harga <?php echo e($featuredCrypto->name); ?></h2>
                                <p class="text-sm text-gray-500">Data historis simulasi untuk periode pilihan.</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="period = '1d'" :class="period === '1d' ? 'btn-primary' : 'btn-secondary'">1H</button>
                                <button type="button" @click="period = '7d'" :class="period === '7d' ? 'btn-primary' : 'btn-secondary'">7H</button>
                                <button type="button" @click="period = '30d'" :class="period === '30d' ? 'btn-primary' : 'btn-secondary'">30H</button>
                                <button type="button" @click="period = '90d'" :class="period === '90d' ? 'btn-primary' : 'btn-secondary'">90H</button>
                            </div>
                        </div>
                        <div class="relative mt-6">
                            <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-white/80 z-10 rounded-xl">
                                <svg class="animate-spin h-6 w-6 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </div>
                            <div x-ref="chart" class="h-72"></div>
                        </div>
                    </div>

                    <div class="card">
                        <h2 class="text-lg font-semibold text-gray-900">Kapitalisasi Terbesar</h2>
                        <p class="mt-1 text-sm text-gray-500">5 aset dengan kapitalisasi pasar tertinggi.</p>
                        <ul class="mt-6 space-y-4">
                            <?php $__currentLoopData = $topByMarketCap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crypto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900"><?php echo e($crypto->rank); ?>. <?php echo e($crypto->name); ?></p>
                                        <p class="text-xs text-gray-500 uppercase"><?php echo e($crypto->symbol); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">
                                            $<?php echo e(number_format($crypto->market_cap, 0, '.', ',')); ?>

                                        </p>
                                        <p class="text-xs <?php echo e($crypto->change_percent_24h >= 0 ? 'text-emerald-500' : 'text-rose-500'); ?>">
                                            <?php echo e($crypto->change_percent_24h >= 0 ? '+' : ''); ?><?php echo e(number_format($crypto->change_percent_24h, 2)); ?>%
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card" x-data="dashboardTabs('trending')">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Analisis Pasar</h2>
                        <p class="text-sm text-gray-500">Bandingkan aset berdasarkan volume, kenaikan, dan penurunan.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="setTab('trending')" :class="tabClass('trending')">Trending</button>
                        <button type="button" @click="setTab('gainers')" :class="tabClass('gainers')">Top Gainers</button>
                        <button type="button" @click="setTab('losers')" :class="tabClass('losers')">Top Losers</button>
                    </div>
                </div>

                <div class="mt-6">
                    <div x-show="isActive('trending')">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $trendingCryptos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crypto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-4 border border-gray-200 rounded-xl hover:border-primary-200 transition-colors">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Rank #<?php echo e($crypto->rank); ?></p>
                                            <p class="font-semibold text-gray-900"><?php echo e($crypto->name); ?></p>
                                            <p class="text-xs text-gray-500 uppercase"><?php echo e($crypto->symbol); ?></p>
                                        </div>
                                        <span class="text-xs bg-primary-50 text-primary-600 px-2 py-1 rounded-full">Volume</span>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-lg font-semibold text-gray-900">
                                            $<?php echo e(number_format($crypto->current_price, 2, '.', ',')); ?>

                                        </p>
                                        <p class="text-xs text-gray-500">Volume 24H: $<?php echo e(number_format($crypto->volume_24h, 0, '.', ',')); ?></p>
                                    </div>
                                    <p class="mt-2 text-sm <?php echo e($crypto->change_percent_24h >= 0 ? 'text-emerald-500' : 'text-rose-500'); ?>">
                                        <?php echo e($crypto->change_percent_24h >= 0 ? '+' : ''); ?><?php echo e(number_format($crypto->change_percent_24h, 2)); ?>% dalam 24 jam
                                    </p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div x-show="isActive('gainers')" x-cloak>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $topGainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crypto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-4 border border-emerald-100 rounded-xl bg-emerald-50/50">
                                    <div class="flex items-center justify-between">
                                        <p class="font-semibold text-gray-900"><?php echo e($crypto->name); ?></p>
                                        <span class="text-xs text-emerald-600 bg-white px-2 py-0.5 rounded-full uppercase"><?php echo e($crypto->symbol); ?></span>
                                    </div>
                                    <p class="mt-3 text-lg font-semibold text-gray-900">
                                        $<?php echo e(number_format($crypto->current_price, 2, '.', ',')); ?>

                                    </p>
                                    <p class="text-sm text-emerald-600 font-semibold mt-1">
                                        +<?php echo e(number_format($crypto->change_percent_24h, 2)); ?>%
                                    </p>
                                    <p class="mt-2 text-xs text-gray-500">Volume 24H: $<?php echo e(number_format($crypto->volume_24h, 0, '.', ',')); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div x-show="isActive('losers')" x-cloak>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $topLosers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crypto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-4 border border-rose-100 rounded-xl bg-rose-50/60">
                                    <div class="flex items-center justify-between">
                                        <p class="font-semibold text-gray-900"><?php echo e($crypto->name); ?></p>
                                        <span class="text-xs text-rose-600 bg-white px-2 py-0.5 rounded-full uppercase"><?php echo e($crypto->symbol); ?></span>
                                    </div>
                                    <p class="mt-3 text-lg font-semibold text-gray-900">
                                        $<?php echo e(number_format($crypto->current_price, 2, '.', ',')); ?>

                                    </p>
                                    <p class="text-sm text-rose-600 font-semibold mt-1">
                                        <?php echo e(number_format($crypto->change_percent_24h, 2)); ?>%
                                    </p>
                                    <p class="mt-2 text-xs text-gray-500">Volume 24H: $<?php echo e(number_format($crypto->volume_24h, 0, '.', ',')); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ademas-wahyu/vod-dev/crypto/resources/views/dashboard/index.blade.php ENDPATH**/ ?>