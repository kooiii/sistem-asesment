<?php

namespace App\Http\Controllers;

use App\Models\NilaiFormatif;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;

class NilaiFormatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $tp = TujuanPembelajaran::with([
        'kelas',
        'mapel'
    ])->findOrFail($request->tp);

    $siswas = Siswa::where(
        'kelas_id',
        $tp->kelas_id
    )
    ->orderBy('nama')
    ->get();

    foreach($siswas as $siswa){

        $nilai = NilaiFormatif::where('tp_id',$tp->id)
                    ->where('siswa_id',$siswa->id)
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
        ], function($v){
            return $v !== null;
        });

        $siswa->rata = count($array)
            ? round(array_sum($array)/count($array),2)
            : null;

    }

    return view(
        'nilai_formatif.create',
        compact(
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
        'tp_id' => 'required',
        'siswa_id' => 'required|array'
    ]);

    $tp = TujuanPembelajaran::findOrFail($request->tp_id);

    $guru = Guru::with(['kelas','mapel'])
                ->findOrFail(session('id'));

    // Validasi hak akses guru
    if(!$guru->kelas->pluck('id')->contains($tp->kelas_id)){
        abort(403);
    }

    if(!$guru->mapel->pluck('id')->contains($tp->mapel_id)){
        abort(403);
    }

    foreach($request->siswa_id as $i => $siswaId){

        $data = [

            'Tugas'      => $request->tugas[$i] ?? null,
            'Kuis'       => $request->kuis[$i] ?? null,
            'Praktik'    => $request->praktik[$i] ?? null,
            'Presentasi' => $request->presentasi[$i] ?? null,

        ];

        foreach($data as $teknik => $nilai){

            if($nilai === null || $nilai === ''){
                continue;
            }

            NilaiFormatif::updateOrCreate([
                'tp_id' => $tp->id,
                'siswa_id' => $siswaId,
                'teknik' => $teknik,
                ],
                [
                    'nilai' => $nilai,
                ]
            );
        }
    }

    return redirect()
            ->route('tujuan-pembelajaran.index')
            ->with('success','Nilai berhasil disimpan.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
