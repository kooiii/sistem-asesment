<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [

            'Informatika',
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Pendidikan Agama',
            'PPKn',
            'Sejarah',
            'PJOK',
            'Seni Budaya',

        ];

        foreach ($mapels as $mapel) {

            Mapel::create([

                'nama_mapel' => $mapel

            ]);

        }
    }
}