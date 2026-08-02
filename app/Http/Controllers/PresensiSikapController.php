<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\SikapPresensi;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class PresensiSikapController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $guru = Guru::with([
            'kelas'
        ])->findOrFail(session('id'));

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        $data = SikapPresensi::with([
            'siswa.kelas',
            'tahunAjaran'
        ])
        ->whereHas('siswa', function($q){

            $q->where(
                'kelas_id',
                session('kelas_aktif')
            );

        });

        if($tahun){

            $data->where(
                'tahun_ajaran_id',
                $tahun->id
            );

        }

        $data = $data
            ->orderBy('id','desc')
            ->get();

        return view(
            'presensi.index',
            compact(
                'guru',
                'tahun',
                'data'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $guru = Guru::with([
            'kelas',
            'mapel'
        ])->findOrFail(session('id'));

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        $siswas = Siswa::where(
            'kelas_id',
            session('kelas_aktif')
        )
        ->orderBy('nama')
        ->get();

        foreach($siswas as $siswa){

            $nilai = SikapPresensi::where(
                'siswa_id',
                $siswa->id
            );

            if($tahun){

                $nilai->where(
                    'tahun_ajaran_id',
                    $tahun->id
                );

            }

            $nilai = $nilai->first();

            $siswa->sikap = optional($nilai)->sikap;

            $siswa->presensi = optional($nilai)->presensi;

        }

        return view(
            'presensi.create',
            compact(
                'guru',
                'tahun',
                'siswas'
            )
        );
    }

        /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'siswa_id' => 'required|array',

            'siswa_id.*' => 'exists:siswas,id',

            'sikap' => 'required|array',

            'presensi' => 'required|array'

        ]);

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        if(!$tahun){

            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );

        }

        foreach($request->siswa_id as $i => $siswaId){

            $siswa = Siswa::findOrFail($siswaId);

            if($siswa->kelas_id != session('kelas_aktif')){
                continue;
            }

            SikapPresensi::updateOrCreate(

                [

                    'siswa_id' => $siswaId,

                    'tahun_ajaran_id' => $tahun->id

                ],

                [

                    'sikap' => $request->sikap[$i],

                    'presensi' => $request->presensi[$i]

                ]

            );

        }

        return redirect()

            ->route('presensi.index')

            ->with(
                'success',
                'Data Sikap & Presensi berhasil disimpan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $guru = Guru::with([
            'kelas'
        ])->findOrFail(session('id'));

        $data = SikapPresensi::with([
            'siswa'
        ])->findOrFail($id);

        if(
            $data->siswa->kelas_id != session('kelas_aktif')
        ){
            abort(403);
        }

        return view(
            'presensi.edit',
            compact(
                'guru',
                'data'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([

            'sikap' => 'required|numeric|min:0|max:100',

            'presensi' => 'required|numeric|min:0|max:100'

        ]);

        $data = SikapPresensi::with(
            'siswa'
        )->findOrFail($id);

        if(
            $data->siswa->kelas_id != session('kelas_aktif')
        ){
            abort(403);
        }

        $data->update([

            'sikap' => $request->sikap,

            'presensi' => $request->presensi

        ]);

        return redirect()

            ->route('presensi.index')

            ->with(
                'success',
                'Data berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $data = SikapPresensi::with(
            'siswa'
        )->findOrFail($id);

        if(
            $data->siswa->kelas_id != session('kelas_aktif')
        ){
            abort(403);
        }

        $data->delete();

        return redirect()

            ->route('presensi.index')

            ->with(
                'success',
                'Data berhasil dihapus.'
            );
    }

}
