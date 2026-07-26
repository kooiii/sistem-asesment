<?php

namespace App\Http\Controllers;

use App\Models\TujuanPembelajaran;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TujuanPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

        $kelasIds = $guru->kelas->pluck('id');

        $mapelIds = $guru->mapel->pluck('id');

        $data = TujuanPembelajaran::with([
        'kelas',
        'mapel',
        'tahunAjaran'
        ])
        ->where('guru_id',$guru->id)
        ->whereIn('kelas_id',$kelasIds)
        ->whereIn('mapel_id',$mapelIds)
        ->orderBy('kelas_id')
        ->orderBy('nomor_tp')
        ->get();

        foreach ($data as $tp) {

        $tp->rata_tugas = \App\Models\NilaiFormatif::where('tp_id', $tp->id)
                        ->where('teknik','Tugas')
                        ->avg('nilai');

        $tp->rata_kuis = \App\Models\NilaiFormatif::where('tp_id', $tp->id)
                        ->where('teknik','Kuis')
                        ->avg('nilai');

        $tp->rata_praktik = \App\Models\NilaiFormatif::where('tp_id', $tp->id)
                        ->where('teknik','Praktik')
                        ->avg('nilai');

        $tp->rata_presentasi = \App\Models\NilaiFormatif::where('tp_id', $tp->id)
                        ->where('teknik','Presentasi')
                        ->avg('nilai');

        $tp->rata_tp = \App\Models\NilaiFormatif::where('tp_id', $tp->id)
                        ->avg('nilai');
    }

        return view(
        'tujuan_pembelajaran.index',
        compact('data')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $guru = Guru::with(['kelas','mapel'])
        ->findOrFail(session('id'));

    $tahun = TahunAjaran::where('aktif',true)->first();

    $nomorTP = TujuanPembelajaran::where('guru_id',$guru->id)
                    ->max('nomor_tp');

    $nomorTP = $nomorTP ? $nomorTP + 1 : 1;

    $data = TujuanPembelajaran::where('guru_id',$guru->id)
                ->orderBy('nomor_tp')
                ->get();

    return view(
        'tujuan_pembelajaran.create',
        compact(
            'guru',
            'tahun',
            'nomorTP',
            'data'
        )
    );
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

        'kelas_id'=>'required',

        'mapel_id'=>'required',

        'nomor_tp'=>'required',

        'judul_tp'=>'required'

        ]);

        $tahun = TahunAjaran::where('aktif',true)->first();

        TujuanPembelajaran::create([

        'guru_id'=>session('id'),

        'kelas_id'=>$request->kelas_id,

        'mapel_id'=>$request->mapel_id,

        'tahun_ajaran_id'=>$tahun->id,

        'nomor_tp'=>$request->nomor_tp,

        'judul_tp'=>$request->judul_tp

        ]);
        

        return redirect()
        ->route('tujuan-pembelajaran.create')
        ->with('success','TP berhasil ditambahkan');
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
