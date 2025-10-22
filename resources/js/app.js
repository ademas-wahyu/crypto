import './bootstrap.js';
import '../css/app.css';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

// Crypto price updater
Alpine.data('cryptoPrice', () => ({
    price: 0,
    change: 0,
    changePercent: 0,
    symbol: '',
    interval: null,

    init() {
        this.symbol = this.$el.dataset.symbol;
        if (this.$el.dataset.price) {
            this.price = parseFloat(this.$el.dataset.price);
        }
        if (this.$el.dataset.change) {
            this.change = parseFloat(this.$el.dataset.change);
        }
        if (this.$el.dataset.changePercent) {
            this.changePercent = parseFloat(this.$el.dataset.changePercent);
        }

        if (!this.symbol) {
            console.warn('cryptoPrice component requires a symbol dataset attribute.');
            return;
        }

        this.updatePrice();
        this.interval = setInterval(() => this.updatePrice(), 5000);
    },

    destroy() {
        if (this.interval) {
            clearInterval(this.interval);
        }
    },
    
    async updatePrice() {
        try {
            const response = await fetch(`/api/crypto/price/${this.symbol}`);
            const data = await response.json();
            this.price = data.price;
            this.change = data.change;
            this.changePercent = data.changePercent;
        } catch (error) {
            console.error('Error updating price:', error);
        }
    },
    
    get priceClass() {
        return this.change >= 0 ? 'price-up' : 'price-down';
    }
}));

// Portfolio calculator
Alpine.data('portfolio', () => ({
    coins: [],
    totalValue: 0,
    totalChange: 0,
    
    init() {
        this.loadPortfolio();
        setInterval(() => this.loadPortfolio(), 10000);
    },
    
    async loadPortfolio() {
        try {
            const response = await fetch('/api/portfolio');
            const data = await response.json();
            this.coins = data.coins;
            this.totalValue = data.totalValue;
            this.totalChange = data.totalChange;
        } catch (error) {
            console.error('Error loading portfolio:', error);
        }
    }
}));

// Chart initialization
Alpine.data('chart', (type, data) => ({
    chart: null,
    
    init() {
        const options = {
            series: data.series,
            chart: {
                type: type,
                height: 350,
                toolbar: {
                    show: false
                }
            },
            theme: {
                mode: 'light'
            },
            ...data.options
        };
        
        this.chart = new ApexCharts(this.$el, options);
        this.chart.render();
    },
    
    destroy() {
        if (this.chart) {
            this.chart.destroy();
        }
    }
}));

Alpine.data('dashboardTabs', (initial = 'trending') => ({
    activeTab: initial,

    setTab(tab) {
        this.activeTab = tab;
    },

    isActive(tab) {
        return this.activeTab === tab;
    },

    tabClass(tab) {
        return this.isActive(tab)
            ? 'btn-primary'
            : 'btn-secondary';
    }
}));

Alpine.data('priceChart', (symbol) => ({
    symbol,
    period: '7d',
    chart: null,
    loading: true,

    async init() {
        await this.fetchData();
        this.$watch('period', () => this.fetchData());
    },

    async fetchData() {
        if (!this.symbol) {
            return;
        }

        this.loading = true;

        try {
            const response = await fetch(`/api/crypto/historical/${this.symbol}?period=${this.period}`);
            const data = await response.json();

            const seriesData = data.map((item) => parseFloat(item.price));
            const categories = data.map((item) => item.date);

            const options = {
                series: [{
                    name: this.symbol,
                    data: seriesData,
                }],
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: { show: false },
                    sparkline: { enabled: false },
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                colors: ['#4F46E5'],
                fill: {
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 90, 100],
                    },
                },
                xaxis: {
                    categories,
                    labels: {
                        style: {
                            colors: '#6B7280',
                        },
                    },
                },
                yaxis: {
                    labels: {
                        formatter: (value) => `$${value.toFixed(2)}`,
                        style: {
                            colors: '#6B7280',
                        },
                    },
                },
                grid: {
                    borderColor: '#E5E7EB',
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: (value) => `$${value.toFixed(2)}`,
                    },
                },
            };

            if (!this.chart) {
                this.chart = new ApexCharts(this.$refs.chart, options);
                await this.chart.render();
            } else {
                await this.chart.updateOptions({
                    xaxis: { categories },
                    series: [{ name: this.symbol, data: seriesData }],
                });
            }
        } catch (error) {
            console.error('Error fetching historical data:', error);
        } finally {
            this.loading = false;
        }
    },

    destroy() {
        if (this.chart) {
            this.chart.destroy();
        }
    }
}));

Alpine.data('marketTable', (cryptos) => ({
    coins: cryptos,
    query: '',
    filter: 'all',
    sortKey: 'rank',
    sortAsc: true,

    get filteredCoins() {
        let result = [...this.coins];

        if (this.filter === 'gainers') {
            result = result.filter((coin) => parseFloat(coin.change_percent_24h) > 0);
        } else if (this.filter === 'losers') {
            result = result.filter((coin) => parseFloat(coin.change_percent_24h) < 0);
        }

        if (this.query.trim() !== '') {
            const term = this.query.toLowerCase();
            result = result.filter((coin) =>
                coin.name.toLowerCase().includes(term) ||
                coin.symbol.toLowerCase().includes(term)
            );
        }

        const sorters = {
            rank: (a, b) => a.rank - b.rank,
            price: (a, b) => a.current_price - b.current_price,
            change: (a, b) => a.change_percent_24h - b.change_percent_24h,
            market_cap: (a, b) => a.market_cap - b.market_cap,
            volume: (a, b) => a.volume_24h - b.volume_24h,
        };

        const sorter = sorters[this.sortKey] ?? sorters.rank;

        result.sort((a, b) => {
            const comparison = sorter(a, b);
            return this.sortAsc ? comparison : -comparison;
        });

        return result;
    },

    setFilter(filter) {
        this.filter = filter;
    },

    filterClass(filter) {
        return this.filter === filter ? 'btn-primary' : 'btn-secondary';
    },

    sortBy(key) {
        if (this.sortKey === key) {
            this.sortAsc = !this.sortAsc;
        } else {
            this.sortKey = key;
            this.sortAsc = key === 'rank';
        }
    },

    sortIndicator(key) {
        if (this.sortKey !== key) {
            return '';
        }
        return this.sortAsc ? '▲' : '▼';
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            maximumFractionDigits: value > 100 ? 2 : 6,
        }).format(value);
    },

    formatChange(value) {
        const numeric = Number(value) || 0;
        const formatted = numeric.toFixed(2);
        return `${numeric >= 0 ? '+' : ''}${formatted}%`;
    },

    formatCompact(value) {
        return new Intl.NumberFormat('en-US', {
            notation: 'compact',
            maximumFractionDigits: 2,
        }).format(value);
    }
}));

Alpine.start();