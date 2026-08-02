<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = [

            'X TKJ',
            'X MPLB',
            'X TKR',
            'X APHP',
            'X TSM',

            'XI TKJ',
            'XI MPLB',
            'XI TKR',
            'XI APHP',
            'XI TSM',

            'XII TKJ',
            'XII MPLB',
            'XII TKR',
            'XII APHP',
            'XII TSM',

        ];

        foreach ($kelas as $k) {

            Kelas::create([
                'nama_kelas' => $k
            ]);

        }
    }
}