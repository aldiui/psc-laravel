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
            ['nama' => 'Kosong']
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

        $barangData = [
            [
                'nama' => 'Oropharingeal Airway Dewasa',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Oropharingeal Airway Anak',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Oropharingeal Airway Bayi',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Laringoscope Handle',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Laringoscope Blade Nomor 2',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Laringoscope Blade Nomor 3',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Laringoscope Blade Nomor 4',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Endotracheal Tube Nomor 5',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Endotracheal Tube Nomor 6',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Endotracheal Tube Nomor 7',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Endotracheal Tube Nomor 8',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'LMA No. 3',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'LMA No. 4',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'LMA No. 5',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Xillocaine Jelly 2%',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Mandrin/ Stylet',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Tongue Spatel',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Magill Forcep Dewasa & Anak',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Suction Catheter Bayi',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Suction Catheter Anak',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Suction Catheter Dewasa',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Neck Collar',
                'unit_id' => '1',
                'kategori_id' => '1',
            ],
            [
                'nama' => 'Bag Valve Dewasa / Anak',
                'unit_id' => '2',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Mask Dewasa',
                'unit_id' => '1',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Mask Anak ',
                'unit_id' => '1',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Mask Bayi',
                'unit_id' => '1',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Kanul Oksigen Dewasa',
                'unit_id' => '1',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Kanul Oksigen Anak % Bayi',
                'unit_id' => '1',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Simpel Mask Dewasa&Anak',
                'unit_id' => '1',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Rebreathing Mask Dewasa&Anak',
                'unit_id' => '1',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Non Rebreathing Mask Dewasa&Anak',
                'unit_id' => '1',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Nasoparingeal',
                'unit_id' => '13',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'No. 6',
                'unit_id' => '13',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'No. 7',
                'unit_id' => '13',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'No. 7.5',
                'unit_id' => '13',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'N0. 8',
                'unit_id' => '13',
                'kategori_id' => '2',
            ],
            [
                'nama' => 'Infus Set Dewasa& Anak',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Tegaderm/IV Dressing',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'IV Catheter No. 14',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'IV Catheter No. 16',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'IV Catheter No. 18',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'IV Catheter No. 20',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'IV Catheter No. 22',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'IV Catheter No. 24',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Ringer Lactate',
                'unit_id' => '3',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'NaCl 0 9%',
                'unit_id' => '3',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Spuit 3 cc',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Spuit 5 cc',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Spuit 10 cc',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Spuit 20 cc',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Spuit 1 cc',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Folley Catheter Nomor 16',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Folley Catheter Nomor 18',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Urine Bag',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Tensimeter Digital',
                'unit_id' => '4',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Termogun',
                'unit_id' => '4',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Kassa Steril',
                'unit_id' => '5',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Verband Gulung   5 cm',
                'unit_id' => '6',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Verband Gulung 10 cm',
                'unit_id' => '7',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Balut Cepat No. 01 ',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Balut Cepat No. 02 ',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Balut Cepat No. 03',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Balut Cepat No. 04',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Mitella',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Elastis Verband',
                'unit_id' => '1',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Plastik Wrapping',
                'unit_id' => '7',
                'kategori_id' => '3',
            ],
            [
                'nama' => 'Adrenalin / Epineprin',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Amiodaron 150mg/3ml',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Sulfas Atropin 0 25 mg',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Buscopan',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Dexamethason 5 mg',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Dextrose 40 %',
                'unit_id' => '10',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Lasix',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Lidocaine 2 %',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Diazepam',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Dopamin HCL 200mg/5ml',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Dobutamin 250mg/5ml',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Tramadol 100mg/2ml',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Ondansetron 4mg/2ml',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Aminofilin 24mg/10ml',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Flixotide 5mg/2ml',
                'unit_id' => '8',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Aspilet tab 80 mg',
                'unit_id' => '9',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Isosorbitdinitrate(ISDN) 5mg',
                'unit_id' => '9',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Clopidogrel (CPG) tab 75 mg',
                'unit_id' => '9',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Oxymetre',
                'unit_id' => '1',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Oxycan',
                'unit_id' => '1',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'D 10%',
                'unit_id' => '13',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Katerolac',
                'unit_id' => '13',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Ranitidine',
                'unit_id' => '13',
                'kategori_id' => '4',
            ],
            [
                'nama' => 'Gunting Operasi ',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Pincet Anatomis',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Pincet Chirurgis',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Arteri Klem Lurus',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Arteri Klem Bengkok',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Nalpuder Hecting',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Gagang Pisau ( Scapel )',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Pisau Bedah Steril',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Jarum Hecting Steril',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Benang Hecting Silk No 2.0',
                'unit_id' => '13',
                'kategori_id' => '5',
            ],
            [
                'nama' => 'Alkohol Swabs',
                'unit_id' => '5',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Bethadine',
                'unit_id' => '11',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Gunting Verband',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Plester/Micropore',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Naso Gastrik Tube ( NGT ) Bayi',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Naso Gastrik Tube ( NGT ) Anak',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Naso Gastrik Tube ( NGT ) Dewasa',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Handscoon',
                'unit_id' => '5',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Masker',
                'unit_id' => '5',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Kartu Triage',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Stetoskop Dewasa&Anak',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Termometer',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Pen Light',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Torniquet',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Tabung O2 Oxyviva ',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Tabung O2 Sedang',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Regulator/ Flowmeter',
                'unit_id' => '2',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Safety Belt',
                'unit_id' => '2',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Spalk/ Fracture Kit/ Air Splin',
                'unit_id' => '2',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Head Immobilizer',
                'unit_id' => '2',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Kunci Inggris',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Laken',
                'unit_id' => '4',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Selimut',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Scoop Stretcher',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Long Spine Board',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'KED',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Roll In Coart (Brankard)',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Tablet',
                'unit_id' => '2',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Payung',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Plastik tutup brankard',
                'unit_id' => '1',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Jas Hujan',
                'unit_id' => '2',
                'kategori_id' => '6',
            ],
            [
                'nama' => 'Suction Pump Unit',
                'unit_id' => '12',
                'kategori_id' => '7',
            ],
            [
                'nama' => 'Infus Pump Unit',
                'unit_id' => '12',
                'kategori_id' => '7',
            ],
            [
                'nama' => 'Ventilator',
                'unit_id' => '12',
                'kategori_id' => '7',
            ],
            [
                'nama' => 'Suction Manual',
                'unit_id' => '1',
                'kategori_id' => '7',
            ],
            [
                'nama' => 'AED',
                'unit_id' => '12',
                'kategori_id' => '7',
            ],
            [
                'nama' => 'Syringe Pump',
                'unit_id' => '12',
                'kategori_id' => '7',
            ],
            [
                'nama' => 'Patient Monitor',
                'unit_id' => '12',
                'kategori_id' => '7',
            ],
            [
                'nama' => 'Blood pressure monitor',
                'unit_id' => '12',
                'kategori_id' => '7',
            ],
            [
                'nama' => 'Glukometer',
                'unit_id' => '2',
                'kategori_id' => '7',
            ]
        ];
        
        DB::table('barangs')->insert($barangData);

        $timData = [
            ['nama' => 'Unit 1', 'deskripsi' => '-'],
            ['nama' => 'Unit 2', 'deskripsi' => '-'],
            ['nama' => 'Unit 3', 'deskripsi' => '-'],
            ['nama' => 'Unit 4', 'deskripsi' => '-'],
        ];

        DB::table('tims')->insert($timData);

        $pengaturanData = [
            'nama' => 'PSC 119',
            'longitude' => '7.3072588',
            'latitude' => '108.2004862',
            'radius' => '100',
        ];

        DB::table('pengaturans')->insert($pengaturanData);
    }
}