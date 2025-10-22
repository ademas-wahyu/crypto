# Panduan Kontribusi

Terima kasih sudah tertarik berkontribusi pada proyek ini! Dokumen ini menjelaskan alur kerja umum ketika berkontribusi, termasuk bagaimana menggunakan workflow Vite, serta tips debugging untuk stack Laravel + Vite yang kami gunakan.

## Alur Kerja Umum

1. **Fork dan clone repo** sesuai prosedur standar GitHub atau sistem kontrol versi pilihan Anda.
2. **Buat branch baru** yang mendeskripsikan perubahan yang akan dilakukan, misalnya `feature/tambah-fitur-x`.
3. **Install dependensi** backend dan frontend:
   - Backend PHP/Laravel: `composer install`
   - Frontend Vite: `npm install`
4. **Siapkan environment**:
   - Duplikasi file `.env.example` menjadi `.env` dan sesuaikan variabelnya.
   - Jalankan `php artisan key:generate` untuk membuat application key.
   - Jika menggunakan database, jalankan migrasi: `php artisan migrate`.
5. **Jalankan test atau linter** yang relevan sebelum membuat commit.
6. **Buat commit** dengan pesan yang jelas, lalu buka pull request.

## Workflow Vite

Proyek ini menggunakan Vite sebagai bundler frontend. Berikut alur kerja standar ketika mengembangkan fitur terkait frontend:

- **Mode pengembangan**: Jalankan `npm run dev`. Perintah ini akan:
  - Menjalankan Vite dev server pada port yang ditentukan (default 5173).
  - Mengaktifkan hot module replacement (HMR) sehingga perubahan pada file JavaScript/TypeScript, Vue, React, dan asset lainnya langsung terlihat.
  - Untuk integrasi Laravel, pastikan juga menjalankan server backend (`php artisan serve`) atau menggunakan Valet/ Sail agar endpoint API tersedia selama pengembangan.

- **Build produksi**: Jalankan `npm run build`. Perintah ini akan:
  - Melakukan bundling dan minifikasi asset untuk produksi.
  - Menghasilkan file final di direktori `public/build` (atau sesuai konfigurasi `vite.config.js`).
  - Setelah build, jalankan `php artisan route:clear` dan `php artisan config:clear` bila perlu untuk memastikan konfigurasi terbaru digunakan.

- **Preview build** *(opsional)*: Setelah `npm run build`, Anda dapat menjalankan `npm run preview` untuk mensimulasikan server produksi Vite dan memverifikasi asset.

## Tips Debugging Laravel + Vite

Menggabungkan Laravel dan Vite menghadirkan beberapa tantangan umum. Berikut tips untuk mempercepat proses debugging:

1. **Periksa Log**
   - Laravel: Gunakan `storage/logs/laravel.log` atau jalankan `php artisan tail` untuk memantau error backend secara real-time.
   - Browser DevTools: Lihat tab Console dan Network untuk memeriksa error JavaScript atau request API yang gagal.

2. **Validasi Konfigurasi Vite**
   - Pastikan `vite.config.js` sudah mengandung plugin Laravel (misalnya `laravel-vite-plugin`) dan daftar entry file yang benar.
   - Jika asset tidak termuat, hapus folder `public/build` dan jalankan ulang `npm run dev` atau `npm run build` untuk regenerasi.

3. **Sinkronisasi Environment**
   - Pastikan variabel environment frontend (`.env`) dan backend (`.env`) konsisten, terutama untuk base URL API, port dev server, dan konfigurasi HTTPS.
   - Bila menggunakan HTTPS lokal, tambahkan `--host` atau sertifikat sesuai panduan Vite.

4. **Cache Laravel**
   - Laravel menyimpan cache konfigurasi, route, dan view. Jika terjadi perilaku aneh setelah mengubah file terkait, jalankan:
     - `php artisan config:clear`
     - `php artisan route:clear`
     - `php artisan view:clear`

5. **HMR Tidak Berfungsi**
   - Pastikan `npm run dev` masih aktif dan tidak menampilkan error.
   - Jika menggunakan Valet/Sail, cek apakah proxy atau port forwarding sudah benar.
   - Coba akses langsung `http://localhost:5173` untuk memastikan Vite dev server berjalan.

6. **Masalah Integrasi Inertia/Vue/React**
   - Gunakan `npm run lint` atau `npm run build` untuk mengidentifikasi error kompilasi.
   - Pastikan versi dependensi frontend kompatibel dengan plugin Laravel Vite.

7. **Hotfix Asset Produksi**
   - Jika file `manifest.json` tidak ditemukan atau cache CDN menyajikan asset lama, hapus folder `public/build` lalu jalankan `npm run build` ulang dan deploy ulang asset.

Dengan mengikuti panduan ini, kontribusi Anda akan lebih lancar dan mudah direview. Jangan ragu membuka issue atau berdiskusi lewat PR jika menemukan masalah.
