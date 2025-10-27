<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barangList = [
            [
                'nama_barang' => 'Beras Premium 5kg',
                'kategori' => 'Sembako',
                'ukuran' => '5 kg',
                'harga_beli' => 60000,
                'harga_jual' => 75000,
                'stok' => 50,
                'deskripsi' => 'Beras premium kualitas terbaik',
                'expired_at' => now()->addMonths(6),
            ],
            [
                'nama_barang' => 'Minyak Goreng 2L',
                'kategori' => 'Sembako',
                'ukuran' => '2 Liter',
                'harga_beli' => 28000,
                'harga_jual' => 35000,
                'stok' => 100,
                'deskripsi' => 'Minyak goreng kemasan 2 liter',
                'expired_at' => now()->addYear(),
            ],
            [
                'nama_barang' => 'Gula Pasir 1kg',
                'kategori' => 'Sembako',
                'ukuran' => '1 kg',
                'harga_beli' => 13000,
                'harga_jual' => 16000,
                'stok' => 75,
                'deskripsi' => 'Gula pasir putih berkualitas',
                'expired_at' => now()->addMonths(8),
            ],
            [
                'nama_barang' => 'Indomie Goreng',
                'kategori' => 'Makanan Instant',
                'ukuran' => '85 gram',
                'harga_beli' => 2500,
                'harga_jual' => 3000,
                'stok' => 200,
                'deskripsi' => 'Mie instant rasa goreng',
                'expired_at' => now()->addMonths(4),
            ],
            [
                'nama_barang' => 'Susu UHT Kotak 1L',
                'kategori' => 'Minuman',
                'ukuran' => '1 Liter',
                'harga_beli' => 15000,
                'harga_jual' => 19000,
                'stok' => 60,
                'deskripsi' => 'Susu UHT rasa plain',
                'expired_at' => now()->addMonths(3),
            ],
            [
                'nama_barang' => 'Telur Ayam 1kg',
                'kategori' => 'Protein',
                'ukuran' => '1 kg',
                'harga_beli' => 25000,
                'harga_jual' => 30000,
                'stok' => 40,
                'deskripsi' => 'Telur ayam segar',
                'expired_at' => now()->addDays(14),
            ],
            [
                'nama_barang' => 'Kopi Kapal Api',
                'kategori' => 'Minuman',
                'ukuran' => '165 gram',
                'harga_beli' => 12000,
                'harga_jual' => 15000,
                'stok' => 80,
                'deskripsi' => 'Kopi bubuk kemasan sachet',
                'expired_at' => now()->addYear(),
            ],
            [
                'nama_barang' => 'Teh Celup Sosro',
                'kategori' => 'Minuman',
                'ukuran' => '50 sachet',
                'harga_beli' => 8000,
                'harga_jual' => 10000,
                'stok' => 90,
                'deskripsi' => 'Teh celup isi 50 sachet',
                'expired_at' => now()->addMonths(10),
            ],
            [
                'nama_barang' => 'Sabun Mandi Lifebuoy',
                'kategori' => 'Toiletries',
                'ukuran' => '80 gram',
                'harga_beli' => 3500,
                'harga_jual' => 5000,
                'stok' => 120,
                'deskripsi' => 'Sabun mandi batangan',
                'expired_at' => now()->addYears(2),
            ],
            [
                'nama_barang' => 'Pasta Gigi Pepsodent',
                'kategori' => 'Toiletries',
                'ukuran' => '150 gram',
                'harga_beli' => 8000,
                'harga_jual' => 11000,
                'stok' => 85,
                'deskripsi' => 'Pasta gigi keluarga',
                'expired_at' => now()->addYears(2),
            ],
            [
                'nama_barang' => 'Tissue Paseo',
                'kategori' => 'Toiletries',
                'ukuran' => '250 sheets',
                'harga_beli' => 10000,
                'harga_jual' => 13000,
                'stok' => 70,
                'deskripsi' => 'Tissue facial isi 250 lembar',
                'expired_at' => null,
            ],
            [
                'nama_barang' => 'Detergen Rinso',
                'kategori' => 'Pembersih',
                'ukuran' => '800 gram',
                'harga_beli' => 15000,
                'harga_jual' => 19000,
                'stok' => 55,
                'deskripsi' => 'Detergen bubuk untuk mencuci',
                'expired_at' => now()->addYears(2),
            ],
            [
                'nama_barang' => 'Air Mineral Aqua 1500ml',
                'kategori' => 'Minuman',
                'ukuran' => '1500 ml',
                'harga_beli' => 3000,
                'harga_jual' => 4000,
                'stok' => 150,
                'deskripsi' => 'Air mineral kemasan botol',
                'expired_at' => now()->addYear(),
            ],
            [
                'nama_barang' => 'Roti Tawar Sari Roti',
                'kategori' => 'Makanan',
                'ukuran' => '400 gram',
                'harga_beli' => 10000,
                'harga_jual' => 13000,
                'stok' => 30,
                'deskripsi' => 'Roti tawar kemasan',
                'expired_at' => now()->addDays(7),
            ],
            [
                'nama_barang' => 'Keju Kraft Cheddar',
                'kategori' => 'Makanan',
                'ukuran' => '180 gram',
                'harga_beli' => 18000,
                'harga_jual' => 23000,
                'stok' => 45,
                'deskripsi' => 'Keju cheddar slice',
                'expired_at' => now()->addMonths(2),
                'diskon' => 10,
            ],
        ];

        foreach ($barangList as $barang) {
            Barang::create($barang);
        }
    }
}
