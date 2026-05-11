<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Posyandu::insert([
            ['nama_posyandu' => 'Posyandu Cendrawasih', 'alamat' => 'Jl. Merdeka No. 1', 'kelurahan' => '-', 'kecamatan' => '-', 'created_at' => now(), 'updated_at' => now()],
            ['nama_posyandu' => 'Posyandu Melati',      'alamat' => 'Jl. Bunga No. 10',   'kelurahan' => '-', 'kecamatan' => '-', 'created_at' => now(), 'updated_at' => now()],
            ['nama_posyandu' => 'Posyandu Mawar',        'alamat' => 'Jl. Kebon Sirih No. 5', 'kelurahan' => '-', 'kecamatan' => '-', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
