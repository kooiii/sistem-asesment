<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index()
    {
        $nilais = Nilai::with(['siswa.kelas', 'mapel'])->get();
        return view('nilai.index', compact('nilais'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $siswas = Siswa::all();
        $mapels = Mapel::all();
        $jenis = 'formatif';

        return view('nilai.create', compact('kelas', 'mapels', 'jenis','siswas'));
    }

    public function createByJenis($jenis)
    {
        $kelas = \App\Models\Kelas::all();
        $siswas = Siswa::all();
        $mapels = \App\Models\Mapel::all();

        return view('nilai.create', compact('siswas', 'mapels', 'jenis','kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'nilai' => 'required|numeric|min:0|max:100',
            'jenis' => 'required|in:formatif,sumatif'
        ]);

        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'mapel_id' => $request->mapel_id,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'bobot' => $request->bobot,
            'nilai' => $request->nilai,
        ]);

        $route = $request->jenis == 'formatif'
        ? 'formatif.index'
        : 'sumatif.index';
        return redirect()->route($route)->with('success', 'Data berhasil disimpan');
    }

    public function formatif()
    {
        $nilais = Nilai::with(['siswa.kelas','mapel'])
            ->where('jenis','formatif')
            ->get();

        return view('formatif.index', compact('nilais'));
    }

    public function createFormatif()
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();

        return view('formatif.create', compact('kelas','mapels'));
    }

    public function sumatif()
    {
        $nilais = Nilai::with(['siswa.kelas','mapel'])
        ->where('jenis','sumatif')->get();

        return view('sumatif.index', compact('nilais'));
    }

    public function createSumatif()
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();

        return view('sumatif.create', compact('kelas','mapels'));
    }
    
    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $kelas = \App\Models\Kelas::all();
        $mapels = \App\Models\Mapel::all();

        return view('nilai.edit', compact('nilai','kelas','mapels'));
    }

    public function laporan()
    {
        $laporan = Nilai::select(
            'siswa_id',
            'mapel_id',
            'jenis'
        )
        ->groupBy('siswa_id', 'mapel_id', 'jenis')
        ->get();

        foreach($laporan as $l){
            $nilaiAkhir = Nilai::where('siswa_id', $l->siswa_id)
            ->where('mapel_id', $l->mapel_id)
            ->where('jenis', $l->jenis)
            ->sum(DB::raw('nilai * bobot / 100'));

            $l->nilai_akhir = $nilaiAkhir;
        }
        return view('laporan.index', compact('laporan'));
    }

    public function cetak(Request $request)
    {
        $query = Nilai::with(['siswa.kelas','mapel']);

        if($request->jenis){
        $query->where('jenis', $request->jenis);
    }

    if($request->kelas_id){
        $query->whereHas('siswa', function($q) use ($request){
            $q->where('kelas_id', $request->kelas_id);
        });
    }

    $nilais = $query->get();

    return view('laporan.cetak', compact('nilais'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'nilai' => 'required|numeric|min:0|max:100',
            'jenis'=> 'required|in:formatif,sumatif'
        ]);

        $nilai = Nilai::findOrFail($id);

        $nilai->update([
            'siswa_id' => $request->siswa_id,
            'mapel_id' => $request->mapel_id,
            'nilai' => $request->nilai,
        ]);

        return redirect()->route('nilai.' . $nilai->jenis)->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilai.' . $nilai->jenis)->with('success', 'Data berhasil dihapus');
    }
}