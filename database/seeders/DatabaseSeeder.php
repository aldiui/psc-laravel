<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Seed Kategori data
        $kategoriData = [
            ['nama' => 'Rak 1', 'deskripsi' => 'Deskripsi untuk Rak 1'],
            ['nama' => 'Rak 2', 'deskripsi' => 'Deskripsi untuk Rak 2'],
            ['nama' => 'Rak 3', 'deskripsi' => 'Deskripsi untuk Rak 3'],
            ['nama' => 'Rak 4', 'deskripsi' => 'Deskripsi untuk Rak 4'],
            ['nama' => 'Rak 5', 'deskripsi' => 'Deskripsi untuk Rak 5'],
            ['nama' => 'Rak 6', 'deskripsi' => 'Deskripsi untuk Rak 6'],
        ];

        DB::table('kategoris')->insert($kategoriData);

        $userData = [
            [
                'nama' => 'Aldi Jaya Mulyana',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('11221122'),
                'role' => 'admin',
                'jabatan' => 'admin',
                "no_hp" => '08123456789'
            ],
            [
                'nama' => 'Dimas Taqbir Ramdani',
                'email' => 'adminkeren@gmail.com',
                'password' => bcrypt('adminkeren'),
                'role' => 'admin',
                'jabatan' => 'admin',
                "no_hp" => '08123456789'
            ],
        ];

        DB::table('users')->insert($userData);
    }
}