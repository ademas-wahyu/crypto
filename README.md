# CryptoPortal - Platform Dashboard Cryptocurrency

CryptoPortal adalah platform monitoring dan trading cryptocurrency yang dibangun dengan Laravel 12 dan Tailwind CSS. Platform ini menyediakan fitur lengkap untuk monitoring harga, manajemen portfolio, dan trading cryptocurrency.

## 🚀 Fitur Utama

### 🔐 Authentication System
- Registrasi dan login user
- Session management yang aman
- Bonus awal $10,000 untuk simulasi trading

### 📊 Real-time Dashboard
- Monitoring portfolio secara real-time
- Grafik performance portfolio
- Analisis profit/loss
- Alokasi aset

### 💰 Portfolio Management
- Tracking kepemilikan cryptocurrency
- Kalkulasi profit/loss otomatis
- Histori transaksi lengkap
- Average price calculation

### 📈 Market Data
- Data harga real-time
- Historical price charts
- Trending cryptocurrencies
- Top gainers & losers
- Search functionality

### 🔄 Trading Features
- Buy/Sell cryptocurrency
- Transaction fee calculation
- Order management
- Balance tracking

### 🎨 Modern UI/UX
- Responsive design dengan Tailwind CSS
- Dark mode support
- Interactive charts dengan ApexCharts
- Smooth animations dan transitions
- Mobile-friendly interface

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Frontend**: Blade Templates + Alpine.js
- **Styling**: Tailwind CSS 3.4
- **Charts**: ApexCharts
- **Database**: SQLite
- **Real-time**: Laravel Echo + Pusher
- **Icons**: Heroicons

## 📋 Persyaratan Sistem

- PHP 8.3+
- Composer
- Node.js 18+
- NPM/Yarn

## 🚀 Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd crypto-portal
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Konfigurasi variabel environment berikut untuk integrasi CoinGecko (nilai default sudah mengarah ke API publik CoinGecko):

   ```ini
   COINGECKO_API_BASE=https://api.coingecko.com/api/v3
   COINGECKO_API_TIMEOUT=10
   COINGECKO_CACHE_TTL_PRICE=30
   COINGECKO_CACHE_TTL_MARKET=120
   COINGECKO_CACHE_TTL_HISTORICAL=600
   COINGECKO_DEFAULT_CURRENCY=usd
   ```

4. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed --class=CryptocurrencySeeder
   ```

5. **Jalankan frontend development server**
   ```bash
   npm run dev
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

> 💡 Catatan: Proyek kini sepenuhnya menggunakan Blade Templates, Alpine.js, dan Tailwind CSS tanpa integrasi Next.js.

## 📁 Struktur Project

```
crypto-portal/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/
│   │   └── API/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── auth/
│   │   └── dashboard/
│   ├── css/
│   └── js/
├── routes/
└── ...
```

## 🎯 Penggunaan

### 1. Registrasi Akun
- Kunjungi halaman `/register`
- Isi form registrasi
- Dapatkan bonus $10,000 untuk memulai

### 2. Dashboard
- Monitor portfolio value
- Lihat performance charts
- Track profit/loss
- View recent transactions

### 3. Trading
- Pilih cryptocurrency dari market
- Input amount dan price
- Konfirmasi transaksi
- Monitor order status

### 4. Portfolio Management
- View asset allocation
- Track individual coin performance
- Export transaction history
- Set price alerts

## 🔗 API Endpoints

### Public Endpoints
- `GET /api/crypto` - List all cryptocurrencies
- `GET /api/crypto/{symbol}` - Get specific crypto data
- `GET /api/crypto/price/{symbol}` - Get real-time price (langsung dari CoinGecko)
- `GET /api/crypto/trending` - Get trending cryptos
- `GET /api/crypto/search?q={query}` - Search cryptocurrencies

### Protected Endpoints (memerlukan authentication)
- `GET /api/portfolio` - Get user portfolio
- `POST /api/portfolio/buy` - Buy cryptocurrency
- `POST /api/portfolio/sell` - Sell cryptocurrency

## 🎨 Customization

### Colors & Themes
- Edit `tailwind.config.js` untuk custom colors
- Dark mode otomatis tersedia
- Responsive breakpoints sudah dikonfigurasi

### Adding New Cryptocurrencies
- Edit `CryptocurrencySeeder.php`
- Run `php artisan db:seed --class=CryptocurrencySeeder`

### Custom Charts
- Edit chart options di `resources/js/app.js`
- Tambahkan new chart types dengan ApexCharts

## 🔒 Keamanan

- CSRF protection
- Input validation
- SQL injection prevention
- XSS protection
- Secure session management

## 📱 Mobile Support

Platform ini fully responsive dan bekerja dengan baik di:
- Desktop (1920px+)
- Tablet (768px - 1023px)
- Mobile (320px - 767px)

## 🚀 Performance Optimization

- Lazy loading untuk charts
- Optimized database queries
- Asset minification dengan Vite
- Efficient caching strategies

## 🤝 Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 License

Project ini dilisensikan under MIT License.

## 🆘 Support

Jika mengalami masalah:
1. Check documentation ini
2. Review error logs
3. Create issue di repository

## 🔄 Updates & Roadmap

### Versi 1.0 (Current)
- ✅ Basic authentication
- ✅ Portfolio management
- ✅ Real-time prices
- ✅ Trading functionality
- ✅ Responsive design

### Versi 1.1 (Planned)
- 🔄 Price alerts
- 🔄 Advanced charting
- 🔄 Export features
- 🔄 Mobile app

### Versi 2.0 (Future)
- 📋 Social trading
- 📋 Advanced analytics
- 📋 API integrations
- 📋 Multi-language support

---

**Happy Trading! 🚀📈**