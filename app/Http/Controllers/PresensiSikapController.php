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

        /*
        |--------------------------------------------------------------------------
        | Tahun Ajaran Aktif
        |--------------------------------------------------------------------------
        */

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan Guru Mengampu Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            !$guru->kelas
                ->pluck('id')
                ->contains(session('kelas_aktif'))
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Data Sikap & Presensi
        |--------------------------------------------------------------------------
        */

        $data = SikapPresensi::with([
            'siswa.kelas',
            'tahunAjaran'
        ])
        ->where(
            'tahun_ajaran_id',
            $tahun->id
        )
        ->whereHas('siswa', function ($q) {

            $q->where(
                'kelas_id',
                session('kelas_aktif')
            );

        })
        ->orderBy('id', 'desc')
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

        /*
        |--------------------------------------------------------------------------
        | Tahun Ajaran Aktif
        |--------------------------------------------------------------------------
        */

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan Guru Mengampu Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            !$guru->kelas
                ->pluck('id')
                ->contains(session('kelas_aktif'))
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Siswa Kelas Aktif
        |--------------------------------------------------------------------------
        */

        $siswas = Siswa::where(
            'kelas_id',
            session('kelas_aktif')
        )
        ->orderBy('nama')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil Nilai Tahun Ajaran Aktif
        |--------------------------------------------------------------------------
        */

        foreach ($siswas as $siswa) {

            $nilai = SikapPresensi::where(
                'siswa_id',
                $siswa->id
            )
            ->where(
                'tahun_ajaran_id',
                $tahun->id
            )
            ->first();

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

            'siswa_id.*' => 'required|exists:siswas,id',

            'sikap' => 'required|array',

            'sikap.*' => 'required|numeric|min:0|max:100',

            'presensi' => 'required|array',

            'presensi.*' => 'required|numeric|min:0|max:100',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Guru
        |--------------------------------------------------------------------------
        */

        $guru = Guru::with([
            'kelas'
        ])->findOrFail(session('id'));


        /*
        |--------------------------------------------------------------------------
        | Tahun Ajaran Aktif
        |--------------------------------------------------------------------------
        */

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        if (!$tahun) {

            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan Guru Mengampu Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            !$guru->kelas
                ->pluck('id')
                ->contains(session('kelas_aktif'))
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Nilai
        |--------------------------------------------------------------------------
        */

        foreach (
            $request->siswa_id as $i => $siswaId
        ) {

            $siswa = Siswa::findOrFail(
                $siswaId
            );


            /*
            |--------------------------------------------------------------------------
            | Pastikan Siswa Berada di Kelas Aktif
            |--------------------------------------------------------------------------
            */

            if (
                $siswa->kelas_id !=
                session('kelas_aktif')
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Pastikan Index Nilai Tersedia
            |--------------------------------------------------------------------------
            */

            if (
                !isset($request->sikap[$i]) ||
                !isset($request->presensi[$i])
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan / Update
            |--------------------------------------------------------------------------
            */

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


        /*
        |--------------------------------------------------------------------------
        | Tahun Ajaran Aktif
        |--------------------------------------------------------------------------
        */

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan Guru Mengampu Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            !$guru->kelas
                ->pluck('id')
                ->contains(session('kelas_aktif'))
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Data Tahun Aktif
        |--------------------------------------------------------------------------
        */

        $data = SikapPresensi::with([
            'siswa'
        ])
        ->where(
            'tahun_ajaran_id',
            $tahun->id
        )
        ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Pastikan Siswa Berada di Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            $data->siswa->kelas_id !=
            session('kelas_aktif')
        ) {
            abort(403);
        }


        return view(
            'presensi.edit',
            compact(
                'guru',
                'tahun',
                'data'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $request->validate([

            'sikap' =>
                'required|numeric|min:0|max:100',

            'presensi' =>
                'required|numeric|min:0|max:100'

        ]);


        /*
        |--------------------------------------------------------------------------
        | Guru
        |--------------------------------------------------------------------------
        */

        $guru = Guru::with([
            'kelas'
        ])->findOrFail(session('id'));


        /*
        |--------------------------------------------------------------------------
        | Tahun Ajaran Aktif
        |--------------------------------------------------------------------------
        */

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan Guru Mengampu Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            !$guru->kelas
                ->pluck('id')
                ->contains(session('kelas_aktif'))
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Data Tahun Aktif
        |--------------------------------------------------------------------------
        */

        $data = SikapPresensi::with(
            'siswa'
        )
        ->where(
            'tahun_ajaran_id',
            $tahun->id
        )
        ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Pastikan Siswa Berada di Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            $data->siswa->kelas_id !=
            session('kelas_aktif')
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $data->update([

            'sikap' =>
                $request->sikap,

            'presensi' =>
                $request->presensi

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
        $guru = Guru::with([
            'kelas'
        ])->findOrFail(session('id'));


        /*
        |--------------------------------------------------------------------------
        | Tahun Ajaran Aktif
        |--------------------------------------------------------------------------
        */

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan Guru Mengampu Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            !$guru->kelas
                ->pluck('id')
                ->contains(session('kelas_aktif'))
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Data Tahun Aktif
        |--------------------------------------------------------------------------
        */

        $data = SikapPresensi::with(
            'siswa'
        )
        ->where(
            'tahun_ajaran_id',
            $tahun->id
        )
        ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Pastikan Siswa Berada di Kelas Aktif
        |--------------------------------------------------------------------------
        */

        if (
            $data->siswa->kelas_id !=
            session('kelas_aktif')
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Hapus
        |--------------------------------------------------------------------------
        */

        $data->delete();


        return redirect()
            ->route('presensi.index')
            ->with(
                'success',
                'Data berhasil dihapus.'
            );
    }
}