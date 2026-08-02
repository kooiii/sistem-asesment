<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        Guru::create([

            'nip' => '123456',
            'nama' => 'Administrator',
            'password' => Hash::make('123456'),
            'role' => 'admin',

        ]);

        Guru::create([

            'nip' => '12345',
            'nama' => 'Guru Informatika',
            'password' => Hash::make('12345'),
            'role' => 'guru',

        ]);

        Guru::create([

            'nip' => '19801223',
            'nama' => 'Guru Matematika',
            'password' => Hash::make('12345'),
            'role' => 'guru',

        ]);
    }
}