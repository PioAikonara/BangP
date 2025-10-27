# Market - Sistem Manajemen Penjualan

Aplikasi web sistem manajemen penjualan berbasis Laravel 12 dengan 3 role: Admin, Kasir, dan Pembeli.

## ?? Fitur Utama

### ????? Admin
- ? Kelola Pegawai/Kasir (CRUD lengkap)
- ? Kelola Stok Barang (CRUD, gambar, kategori, expired date, diskon)
- ? Laporan Penjualan (harian, filter tanggal)
- ? Dashboard analytics (total penjualan, keuntungan, stok menipis, barang expired)

### ?? Kasir
- ? Transaksi Penjualan (multi-item, auto-calculate, diskon)
- ? Kelola Member Pembeli (CRUD)
- ? Lihat Stok Barang Real-time
- ? Hapus Produk Expired otomatis
- ? Riwayat Transaksi Pribadi

### ?? Pembeli (Online Order - Take-in)
- ? Member Card Digital dengan kode unik
- ? Katalog Barang dengan pencarian
- ? Keranjang Belanja
- ? Pesan Online, Ambil di Tempat

## ??? Instalasi & Jalankan

\\\powershell
# 1. Install dependencies
composer install
npm install

# 2. Setup database di .env
DB_DATABASE=market_db

# 3. Migrate & Seed
php artisan migrate:fresh --seed

# 4. Build assets
npm run build

# 5. Jalankan server
php artisan serve
\\\

## ?? Akun Demo

- Admin: admin@market.com / password
- Kasir: kasir1@market.com / password  
- Pembeli: pembeli@market.com / password

## ?? Tech Stack

Laravel 12 | TailwindCSS | MySQL | Breeze Auth

Buka: http://localhost:8000
