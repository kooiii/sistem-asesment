<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\NilaiFormatif;
use App\Models\TujuanPembelajaran;
use App\Models\TahunAjaran;

class NilaiFormatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('tujuan-pembelajaran.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $guru = Guru::with([
        'kelas',
        'mapel'
    ])->findOrFail(session('id'));

    $tp = TujuanPembelajaran::with([
        'kelas',
        'mapel'
    ])->findOrFail($request->tp);

    /*
    |--------------------------------------------------------------------------
    | Validasi Context Guru
    |--------------------------------------------------------------------------
    */

    if($tp->kelas_id != session('kelas_aktif')){
        abort(403);
    }

    if($tp->mapel_id != session('mapel_aktif')){
        abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | Ambil siswa sesuai kelas aktif
    |--------------------------------------------------------------------------
    */

    $siswas = Siswa::where(
        'kelas_id',
        session('kelas_aktif')
    )

    ->orderBy('nama')

    ->get();

    foreach($siswas as $siswa){

        $nilai = NilaiFormatif::where(

            'tp_id',

            $tp->id

        )

        ->where(

            'siswa_id',

            $siswa->id

        )

        ->get()

        ->keyBy('teknik');

        $siswa->tugas = optional($nilai->get('Tugas'))->nilai;

        $siswa->kuis = optional($nilai->get('Kuis'))->nilai;

        $siswa->praktik = optional($nilai->get('Praktik'))->nilai;

        $siswa->presentasi = optional($nilai->get('Presentasi'))->nilai;

        $array = array_filter([

            $siswa->tugas,

            $siswa->kuis,

            $siswa->praktik,

            $siswa->presentasi

        ],function($v){

            return $v !== null;

        });

        $siswa->rata = count($array)

            ? round(array_sum($array)/count($array),2)

            : null;
    }

    return view(

        'nilai_formatif.create',

        compact(

            'guru',

            'tp',

            'siswas'

        )

    );
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([

        'tp_id' => 'required|exists:tujuan_pembelajarans,id',

        'siswa_id' => 'required|array',

        'siswa_id.*' => 'exists:siswas,id'

    ]);

    $guru = Guru::with([
        'kelas',
        'mapel'
    ])->findOrFail(session('id'));

    $tp = TujuanPembelajaran::findOrFail($request->tp_id);

    /*
    |--------------------------------------------------------------------------
    | Validasi Context Guru
    |--------------------------------------------------------------------------
    */

    if($tp->kelas_id != session('kelas_aktif')){
        abort(403);
    }

    if($tp->mapel_id != session('mapel_aktif')){
        abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | Tahun Ajaran Aktif
    |--------------------------------------------------------------------------
    */

    $tahun = TahunAjaran::where('aktif',true)->first();

    if(!$tahun){

        return back()->with(

            'error',

            'Tahun ajaran aktif belum tersedia.'

        );

    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Nilai
    |--------------------------------------------------------------------------
    */

    foreach($request->siswa_id as $i => $siswaId){

        $siswa = Siswa::findOrFail($siswaId);

        if($siswa->kelas_id != session('kelas_aktif')){
            continue;
        }

        $nilaiArray = [

            'Tugas'      => $request->tugas[$i] ?? null,

            'Kuis'       => $request->kuis[$i] ?? null,

            'Praktik'    => $request->praktik[$i] ?? null,

            'Presentasi' => $request->presentasi[$i] ?? null,

        ];

        foreach($nilaiArray as $teknik => $nilai){

            if($nilai === '' || $nilai === null){
                continue;
            }

            NilaiFormatif::updateOrCreate(

                [

                    'tp_id' => $tp->id,

                    'siswa_id' => $siswaId,

                    'teknik' => $teknik,

                    'tahun_ajaran_id' => $tahun->id

                ],

                [

                    'nilai' => $nilai

                ]

            );

        }

    }

    return redirect()

        ->route('tujuan-pembelajaran.index')

        ->with(

            'success',

            'Nilai Formatif berhasil disimpan.'

        );
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}