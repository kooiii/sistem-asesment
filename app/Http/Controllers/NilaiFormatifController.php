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

    $teknik = $request->teknik ?? 'Tugas';

    $siswas = Siswa::where(
        'kelas_id',
        $tp->kelas_id
    )->orderBy('nama')->get();

    $nilaiLama = NilaiFormatif::where('tp_id',$tp->id)
                    ->where('teknik',$teknik)
                    ->pluck('nilai','siswa_id');

    return view(
        'nilai_formatif.create',
        compact(
            'tp',
            'siswas',
            'teknik',
            'nilaiLama'
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
        'teknik' => 'required',
        'siswa_id' => 'required|array',
        'nilai' => 'required|array',
    ]);

    $tp = TujuanPembelajaran::findOrFail($request->tp_id);

    $guru = Guru::with(['kelas','mapel'])
                ->findOrFail(session('id'));

    if(!$guru->kelas->pluck('id')->contains($tp->kelas_id)){
        abort(403);
    }

    if(!$guru->mapel->pluck('id')->contains($tp->mapel_id)){
        abort(403);
    }

    foreach($request->siswa_id as $i => $siswaId){

        if($request->nilai[$i] === null || $request->nilai[$i] === ''){
            continue;
        }

        NilaiFormatif::updateOrCreate(

            [
                'tp_id' => $tp->id,
                'siswa_id' => $siswaId,
                'teknik' => $request->teknik,
            ],

            [
                'nilai' => $request->nilai[$i],
            ]

        );

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
