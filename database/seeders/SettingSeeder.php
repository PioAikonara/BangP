<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'key' => 'nama_toko',
            'value' => 'Market',
            'deskripsi' => 'Nama toko yang ditampilkan di struk',
        ]);

        Setting::create([
            'key' => 'alamat_toko',
            'value' => 'Jl. Raya Pasar No. 123, Jakarta Pusat',
            'deskripsi' => 'Alamat toko',
        ]);

        Setting::create([
            'key' => 'no_telp_toko',
            'value' => '021-1234567',
            'deskripsi' => 'Nomor telepon toko',
        ]);

        Setting::create([
            'key' => 'persentase_keuntungan',
            'value' => '20',
            'deskripsi' => 'Persentase keuntungan default (dalam persen)',
        ]);

        Setting::create([
            'key' => 'minimal_stok',
            'value' => '10',
            'deskripsi' => 'Minimal stok untuk peringatan stok menipis',
        ]);
    }
}
