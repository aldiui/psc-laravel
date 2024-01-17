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
            ['nama' => 'Airway', 'deskripsi' => '-'],
            ['nama' => 'Breathing', 'deskripsi' => '-'],
            ['nama' => 'Cirkulasi', 'deskripsi' => '-'],
            ['nama' => 'Obat - Obatan', 'deskripsi' => '-'],
            ['nama' => 'Minor Set', 'deskripsi' => '-'],
            ['nama' => 'Lain - lain', 'deskripsi' => '-'],
            ['nama' => 'Alkes Elektronik', 'deskripsi' => '-'],
        ];

        DB::table('kategoris')->insert($kategoriData);

        $unitData = [
            ['nama' => 'Buah'],
            ['nama' => 'Set'],
            ['nama' => 'Kolf'],
            ['nama' => 'Bh'],
            ['nama' => 'Box'],
            ['nama' => 'Pcs'],
            ['nama' => 'Roll'],
            ['nama' => 'Amp'],
            ['nama' => 'Tab'],
            ['nama' => 'Flk'],
            ['nama' => 'Botol'],
            ['nama' => 'Unit'],
        ];

        DB::table('units')->insert($unitData);

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