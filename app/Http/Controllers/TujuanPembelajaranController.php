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
    $kelasAktif = session('kelas_aktif');

    $mapelAktif = session('mapel_aktif');

    $guru = Guru::with([
        'kelas',
        'mapel'
    ])->findOrFail(session('id'));

    $data = TujuanPembelajaran::where(
            'kelas_id',
            $kelasAktif
        )
        ->where(
            'mapel_id',
            $mapelAktif
        )
        ->orderBy('nomor_tp')
        ->get();

    $nomorTP = $data->count() + 1;

    return view(
        'tujuan_pembelajaran.create',
        compact(
            'guru',
            'data',
            'nomorTP'
        )
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tujuan_pembelajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([

        'nomor_tp'=>'required|integer|min:1',

        'judul_tp'=>'required'

    ]);

    $guru = Guru::with([
        'kelas',
        'mapel'
    ])->findOrFail(session('id'));

    $kelasAktif = session('kelas_aktif');

    $mapelAktif = session('mapel_aktif');

    if(!$guru->kelas->pluck('id')->contains($kelasAktif)){
        abort(403);
    }

    if(!$guru->mapel->pluck('id')->contains($mapelAktif)){
        abort(403);
    }

    TujuanPembelajaran::create([

        'kelas_id'=>$kelasAktif,

        'mapel_id'=>$mapelAktif,

        'nomor_tp'=>$request->nomor_tp,

        'judul_tp'=>$request->judul_tp

    ]);

    return back()->with(
        'success',
        'TP berhasil ditambahkan.'
    );
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
