<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhKeterampilan;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;

class PhKeterampilanController extends Controller
{
    public function index()
    {
    if(session('role') == 'admin'){

        $data = PhKeterampilan::with(['siswa.kelas','mapel'])
                    ->latest()
                    ->get();

    }else{

        $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

        $kelasIds = $guru->kelas->pluck('id');

        $mapelIds = $guru->mapel->pluck('id');

        $data = PhKeterampilan::with(['siswa.kelas','mapel'])
                    ->whereIn('mapel_id',$mapelIds)
                    ->whereHas('siswa', function($q) use ($kelasIds){
                        $q->whereIn('kelas_id',$kelasIds);
                    })
                    ->latest()
                    ->get();
    }

    return view('ph_keterampilan.index', compact('data'));
}

    public function create()
    {
        $guru = Guru::with(['kelas','mapel'])->find(session('id'));
        $kelasDipilih = request('kelas');
        
        if ($kelasDipilih) {
            $siswas = Siswa::where('kelas_id',$kelasDipilih)->get();
        } else {
            $siswas = collect();
        }

        return view('ph_keterampilan.create', [
            'guru' => $guru,
            'kelasGuru' => $guru->kelas,
            'mapelGuru' => $guru->mapel,
            'siswas' => $siswas,
            'kelasDipilih' => $kelasDipilih
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'siswa_id' => 'required',
        'mapel_id' => 'required',
        'tp1' => 'required|numeric|min:0|max:100',
        'tp2' => 'required|numeric|min:0|max:100',
        'tp3' => 'required|numeric|min:0|max:100',
        'tp4' => 'required|numeric|min:0|max:100',
        'tp5' => 'required|numeric|min:0|max:100',
        'tp6' => 'required|numeric|min:0|max:100',
        'tp7' => 'required|numeric|min:0|max:100',
        'tp8' => 'required|numeric|min:0|max:100',
        'tp9' => 'required|numeric|min:0|max:100',
        'tp10' => 'required|numeric|min:0|max:100',
        'tp11' => 'required|numeric|min:0|max:100',
        'tp12' => 'required|numeric|min:0|max:100',
    ]);

    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    $siswa = Siswa::findOrFail($request->siswa_id);

    // Pastikan siswa berasal dari kelas yang diampu guru
    if (!$guru->kelas->pluck('id')->contains($siswa->kelas_id)) {
        abort(403, 'Anda tidak berhak menginput nilai untuk kelas ini.');
    }

    // Pastikan mapel memang diampu guru
    if (!$guru->mapel->pluck('id')->contains($request->mapel_id)) {
        abort(403, 'Anda tidak berhak menginput nilai untuk mata pelajaran ini.');
    }

    $r2 = (
        $request->tp1 +
        $request->tp2 +
        $request->tp3 +
        $request->tp4 +
        $request->tp5 +
        $request->tp6 +
        $request->tp7 +
        $request->tp8 +
        $request->tp9 +
        $request->tp10 +
        $request->tp11 +
        $request->tp12
    ) / 12;

    PhKeterampilan::create([
        'siswa_id' => $request->siswa_id,
        'mapel_id' => $request->mapel_id,

        'tp1' => $request->tp1,
        'tp2' => $request->tp2,
        'tp3' => $request->tp3,
        'tp4' => $request->tp4,
        'tp5' => $request->tp5,
        'tp6' => $request->tp6,
        'tp7' => $request->tp7,
        'tp8' => $request->tp8,
        'tp9' => $request->tp9,
        'tp10' => $request->tp10,
        'tp11' => $request->tp11,
        'tp12' => $request->tp12,

        'r2' => round($r2, 2),
        'n' => round($r2, 2),
    ]);

    return redirect()
        ->route('ph.keterampilan.index')
        ->with('success', 'Data berhasil disimpan');
}

    public function edit($id)
{
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    $kelasIds = $guru->kelas->pluck('id');

    $mapelIds = $guru->mapel->pluck('id');

    $data = PhKeterampilan::with('siswa')->findOrFail($id);

    if(
        !$kelasIds->contains($data->siswa->kelas_id) ||
        !$mapelIds->contains($data->mapel_id)
    ){
        abort(403);
    }

    $siswas = Siswa::whereIn('kelas_id',$kelasIds)->get();

    $mapels = Mapel::whereIn('id',$mapelIds)->get();

    return view('ph_keterampilan.edit', compact(
        'data',
        'siswas',
        'mapels'
    ));
}

public function update(Request $request, $id)
{
    $data = PhKeterampilan::findOrFail($id);
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

        $siswa = Siswa::findOrFail($request->siswa_id);

        if(!$guru->kelas->pluck('id')->contains($siswa->kelas_id)){
        abort(403);
    }

        if(!$guru->mapel->pluck('id')->contains($request->mapel_id)){
        abort(403);
    }

    $jumlah = 0;

    for($i=1; $i<=12; $i++){
        $jumlah += $request->input('tp'.$i);
    }

    $r2 = round($jumlah/12,2);

    $data->update([
        'siswa_id'=>$request->siswa_id,
        'mapel_id'=>$request->mapel_id,

        'tp1'=>$request->tp1,
        'tp2'=>$request->tp2,
        'tp3'=>$request->tp3,
        'tp4'=>$request->tp4,
        'tp5'=>$request->tp5,
        'tp6'=>$request->tp6,
        'tp7'=>$request->tp7,
        'tp8'=>$request->tp8,
        'tp9'=>$request->tp9,
        'tp10'=>$request->tp10,
        'tp11'=>$request->tp11,
        'tp12'=>$request->tp12,

        'r2'=>$r2
    ]);

    return redirect()
        ->route('ph.keterampilan.index')
        ->with('success','Data berhasil diperbarui');
}

public function destroy($id)
{
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    $data = PhKeterampilan::with('siswa')->findOrFail($id);

    if(
        !$guru->kelas->pluck('id')->contains($data->siswa->kelas_id) ||
        !$guru->mapel->pluck('id')->contains($data->mapel_id)
    ){
        abort(403);
    }

    $data->delete();

    return redirect()
        ->route('ph.keterampilan.index')
        ->with('success','Data berhasil dihapus');
}
}