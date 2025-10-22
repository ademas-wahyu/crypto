<?php $__env->startSection('title', 'Pasar'); ?>

<?php $__env->startSection('content'); ?>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pasar Cryptocurrency</h1>
                    <p class="mt-2 text-gray-500 text-sm">Eksplorasi data harga, volume, serta pergerakan aset kripto secara lengkap.</p>
                </div>
                <div class="hidden md:flex items-center gap-3">
                    <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-200">
                        <p class="text-xs text-gray-500">Total Aset Aktif</p>
                        <p class="text-lg font-semibold text-gray-900"><?php echo e($cryptocurrencies->count()); ?></p>
                    </div>
                    <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-200">
                        <p class="text-xs text-gray-500">Top Volume 24H</p>
                        <p class="text-lg font-semibold text-gray-900">$<?php echo e(number_format(optional($trending->first())->volume_24h ?? 0, 0, '.', ',')); ?></p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card">
                    <h2 class="text-sm font-semibold text-gray-900">Trending</h2>
                    <p class="text-xs text-gray-500">Aset dengan volume perdagangan tertinggi.</p>
                    <ul class="mt-4 space-y-3">
                        <?php $__currentLoopData = $trending->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crypto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($crypto->name); ?></p>
                                    <p class="text-xs text-gray-500 uppercase"><?php echo e($crypto->symbol); ?></p>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">
                                    $<?php echo e(number_format($crypto->current_price, 2, '.', ',')); ?>

                                </p>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div class="card">
                    <h2 class="text-sm font-semibold text-gray-900">Top Gainers</h2>
                    <p class="text-xs text-gray-500">Kenaikan tertinggi dalam 24 jam terakhir.</p>
                    <ul class="mt-4 space-y-3">
                        <?php $__currentLoopData = $topGainers->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crypto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($crypto->name); ?></p>
                                    <p class="text-xs text-gray-500 uppercase"><?php echo e($crypto->symbol); ?></p>
                                </div>
                                <p class="text-sm font-semibold text-emerald-500">
                                    +<?php echo e(number_format($crypto->change_percent_24h, 2)); ?>%
                                </p>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div class="card">
                    <h2 class="text-sm font-semibold text-gray-900">Top Losers</h2>
                    <p class="text-xs text-gray-500">Penurunan terbesar dalam 24 jam terakhir.</p>
                    <ul class="mt-4 space-y-3">
                        <?php $__currentLoopData = $topLosers->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crypto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($crypto->name); ?></p>
                                    <p class="text-xs text-gray-500 uppercase"><?php echo e($crypto->symbol); ?></p>
                                </div>
                                <p class="text-sm font-semibold text-rose-500">
                                    <?php echo e(number_format($crypto->change_percent_24h, 2)); ?>%
                                </p>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>

            <div class="card" x-data="marketTable(<?php echo \Illuminate\Support\Js::from($cryptocurrencies->map(fn($crypto) => [
                'id' => $crypto->id,
                'symbol' => $crypto->symbol,
                'name' => $crypto->name,
                'current_price' => (float) $crypto->current_price,
                'market_cap' => (float) $crypto->market_cap,
                'volume_24h' => (float) $crypto->volume_24h,
                'change_24h' => (float) $crypto->change_24h,
                'change_percent_24h' => (float) $crypto->change_percent_24h,
                'rank' => $crypto->rank,
            ]))->toHtml() ?>)">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="relative w-full lg:max-w-xs">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zm-6 4a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <input type="text" x-model="query" placeholder="Cari koin atau simbol..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" @click="setFilter('all')" :class="filterClass('all')">Semua</button>
                        <button type="button" @click="setFilter('gainers')" :class="filterClass('gainers')">Gainers</button>
                        <button type="button" @click="setFilter('losers')" :class="filterClass('losers')">Losers</button>
                    </div>
                </div>

                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="py-3 cursor-pointer" @click="sortBy('rank')">Rank <span x-text="sortIndicator('rank')"></span></th>
                                <th class="py-3">Aset</th>
                                <th class="py-3 cursor-pointer" @click="sortBy('price')">Harga <span x-text="sortIndicator('price')"></span></th>
                                <th class="py-3 cursor-pointer" @click="sortBy('change')">Perubahan 24H <span x-text="sortIndicator('change')"></span></th>
                                <th class="py-3 cursor-pointer" @click="sortBy('market_cap')">Market Cap <span x-text="sortIndicator('market_cap')"></span></th>
                                <th class="py-3 cursor-pointer" @click="sortBy('volume')">Volume 24H <span x-text="sortIndicator('volume')"></span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" x-show="filteredCoins.length">
                            <template x-for="coin in filteredCoins" :key="coin.id">
                                <tr class="text-sm text-gray-700 hover:bg-gray-50/80">
                                    <td class="py-3 font-semibold text-gray-900" x-text="coin.rank"></td>
                                    <td class="py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary-500/20 to-primary-500/10 flex items-center justify-center text-primary-600 font-semibold">
                                                <span x-text="coin.symbol[0]"></span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900" x-text="coin.name"></p>
                                                <p class="text-xs text-gray-500 uppercase" x-text="coin.symbol"></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 font-semibold text-gray-900" x-text="formatCurrency(coin.current_price)"></td>
                                    <td class="py-3 font-semibold" :class="coin.change_percent_24h >= 0 ? 'text-emerald-500' : 'text-rose-500'" x-text="formatChange(coin.change_percent_24h)"></td>
                                    <td class="py-3" x-text="formatCompact(coin.market_cap)"></td>
                                    <td class="py-3" x-text="formatCompact(coin.volume_24h)"></td>
                                </tr>
                            </template>
                        </tbody>
                        <tbody x-show="!filteredCoins.length">
                            <tr>
                                <td colspan="6" class="py-8 text-center text-sm text-gray-500">Tidak ada aset yang sesuai dengan pencarian Anda.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ademas-wahyu/vod-dev/crypto/resources/views/market/index.blade.php ENDPATH**/ ?>