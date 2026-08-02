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

        $guru = Guru::with([
                'kelas',
                'mapel'
            ])->find(session('id'));
            if(!$guru){
                abort(403);
            }

            /*
            |--------------------------------------------------------------------------
            | Context Guru
            |--------------------------------------------------------------------------
            */

            if(!session()->has('kelas_aktif')){
                session([
                    'kelas_aktif' => optional($guru->kelas->first())->id
                ]);
            }

            if(!session()->has('mapel_aktif')){
                session([
                    'mapel_aktif' => optional($guru->mapel->first())->id
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Data Dashboard
            |--------------------------------------------------------------------------
            */

            $totalSiswa = \App\Models\Siswa::where(
                'kelas_id',
                session('kelas_aktif')
            )->count();

            $totalTP = \App\Models\TujuanPembelajaran::where(
                'kelas_id',
                session('kelas_aktif')

            )->where(
                'mapel_id',
                session('mapel_aktif')

            )->count();

            $totalFormatif = \App\Models\NilaiFormatif::count();
            $totalSumatif = \App\Models\NilaiSumatif::count();

            return view('guru.dashboard',
                compact(
                    'guru',
                    'totalSiswa',
                    'totalTP',
                    'totalFormatif',
                    'totalSumatif'
                )

            );
    }

    public function gantiContext(Request $request)
    {
        session([
            'kelas_aktif'=>$request->kelas_id,
            'mapel_aktif'=>$request->mapel_id
        ]);
        return back();
    }

    // LOGOUT
    public function logout()
    {
        session()->flush();

        return redirect('/login')->with('success', 'Berhasil logout');
    }
}