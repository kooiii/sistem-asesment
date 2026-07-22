<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalSiswa' => Siswa::count(),
            'totalKelas' => Kelas::count(),
            'totalMapel' => Mapel::count(),
            'totalNilai' => Nilai::count(),
        ]);
    }
}
