<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // HALAMAN LOGIN
    public function showLogin()
    {
        return view('login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $guru = Guru::where('nip', $request->nip)->first();

        if ($guru && Hash::check($request->password, $guru->password)) {

            session([
                'login' => true,
                'id' =>$guru->id,
                'nama' => $guru->nama,
                'nip' => $guru->nip,
                'role' => $guru->role,
            ]);

            return redirect('/dashboard');
        }

        return redirect('/login')->with('error', 'NIP atau Password salah');
    }

    // DASHBOARD
    public function dashboard()
    {
        if(session('role') == 'admin')
            {
                $totalGuru = \App\Models\Guru::count();
                $totalSiswa = \App\Models\Siswa::count();
                $totalKelas = \App\Models\Kelas::count();
                $totalMapel = \App\Models\Mapel::count();

                return view('admin.dashboard', compact(
                    'totalGuru',
                    'totalSiswa',
                    'totalKelas',
                    'totalMapel'
                ));
            }

        $guru = Guru::with(['kelas','mapel'])->find(session('id'));

        $totalSiswa = \App\Models\Siswa::count();
        $totalKelas = \App\Models\Kelas::count();
        $totalMapel = \App\Models\Mapel::count();

        $totalNilaiFormatif = \App\Models\NilaiFormatif::count();
        $totalNilaiSumatif  = \App\Models\NilaiSumatif::count();

        return view('guru.dashboard', compact(
            'guru',
            'totalSiswa',
            'totalKelas',
            'totalMapel',
            'totalNilaiFormatif',
            'totalNilaiSumatif'
        ));
    }

    // LOGOUT
    public function logout()
    {
        session()->flush();

        return redirect('/login')->with('success', 'Berhasil logout');
    }
}