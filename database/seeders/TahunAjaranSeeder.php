<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        TahunAjaran::create([

            'tahun_ajaran' => '2026/2027',

            'semester' => 'Ganjil',

            'aktif' => true,

        ]);

        TahunAjaran::create([

            'tahun_ajaran' => '2026/2027',

            'semester' => 'Genap',

            'aktif' => false,

        ]);

        TahunAjaran::create([

            'tahun_ajaran' => '2027/2028',

            'semester' => 'Ganjil',

            'aktif' => false,

        ]);

        TahunAjaran::create([

            'tahun_ajaran' => '2027/2028',

            'semester' => 'Genap',

            'aktif' => false,

        ]);
    }
}