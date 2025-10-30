<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@market.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kasir 1
        $kasir1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'kasir1@market.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        Pegawai::create([
            'user_id' => $kasir1->id,
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'no_telp' => '081234567890',
        ]);

        // Pembeli
        $pembeli = User::create([
            'name' => 'Ahmad Rizki',
            'email' => 'pembeli@market.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

        Member::create([
            'user_id' => $pembeli->id,
            'nama_member' => 'Ahmad Rizki',
            'no_hp' => '081345678901',
            'alamat' => 'Jl. Gatot Subroto No. 78, Jakarta',
        ]);

        // Member tanpa akun
        Member::create([
            'nama_member' => 'Dewi Lestari',
            'no_hp' => '082134567890',
            'alamat' => 'Jl. Thamrin No. 90, Jakarta',
        ]);

        Member::create([
            'nama_member' => 'Rudi Hartono',
            'no_hp' => '083123456789',
            'alamat' => 'Jl. Rasuna Said No. 12, Jakarta',
        ]);
    }
}
