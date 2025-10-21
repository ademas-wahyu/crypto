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
    
    init() {
        this.symbol = this.$el.dataset.symbol;
        this.updatePrice();
        setInterval(() => this.updatePrice(), 5000);
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

Alpine.start();