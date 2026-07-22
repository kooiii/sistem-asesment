<?php

namespace App\Http\Controllers;

use App\Models\Pts;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Http\Request;

class PtsController extends Controller
{
    public function index()
    {
    if(session('role') == 'admin'){

        $data = Pts::with(['siswa.kelas','mapel'])
                    ->latest()
                    ->get();

    }else{

        $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

        $kelasIds = $guru->kelas->pluck('id');

        $mapelIds = $guru->mapel->pluck('id');

        $data = Pts::with(['siswa.kelas','mapel'])
                    ->whereIn('mapel_id',$mapelIds)
                    ->whereHas('siswa', function($q) use ($kelasIds){
                        $q->whereIn('kelas_id',$kelasIds);
                    })
                    ->latest()
                    ->get();
    }

    return view('pts.index', compact('data'));
}

    public function create()
    {
        $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));
        $kelasDipilih = request('kelas');
        
        if ($kelasDipilih) {
            $siswas = Siswa::where('kelas_id',$kelasDipilih)->get();
        } else {
            $siswas = collect();
        }

        return view('pts.create', [
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
        'nm' => 'required|numeric|min:0|max:100',
        'nr' => 'nullable|numeric|min:0|max:100',
    ]);

    // Guru yang login
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    // Data siswa
    $siswa = Siswa::findOrFail($request->siswa_id);

    // Validasi kelas
    if (!$guru->kelas->pluck('id')->contains($siswa->kelas_id)) {
        abort(403,'Anda tidak berhak menginput nilai pada kelas ini.');
    }

    // Validasi mapel
    if (!$guru->mapel->pluck('id')->contains($request->mapel_id)) {
        abort(403,'Anda tidak berhak menginput nilai pada mata pelajaran ini.');
    }

    // Nilai akhir
    $nilaiAkhir = $request->filled('nr')
        ? $request->nr
        : $request->nm;

    Pts::create([
        'siswa_id' => $request->siswa_id,
        'mapel_id' => $request->mapel_id,
        'nm' => $request->nm,
        'nr' => $request->nr,
        'n' => $nilaiAkhir,
    ]);

    return redirect()
        ->route('pts.index')
        ->with('success','Data berhasil disimpan');
}

    public function edit($id)
{
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    $kelasIds = $guru->kelas->pluck('id');

    $mapelIds = $guru->mapel->pluck('id');

    $data = Pts::with('siswa')->findOrFail($id);

    if(
        !$kelasIds->contains($data->siswa->kelas_id) ||
        !$mapelIds->contains($data->mapel_id)
    ){
        abort(403);
    }

    $siswas = Siswa::whereIn('kelas_id',$kelasIds)->get();

    $mapels = Mapel::whereIn('id',$mapelIds)->get();

    return view('pts.edit', compact(
        'data',
        'siswas',
        'mapels'
    ));
}

public function update(Request $request, $id)
{
    $data = Pts::findOrFail($id);
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

        $siswa = Siswa::findOrFail($request->siswa_id);

        if(!$guru->kelas->pluck('id')->contains($siswa->kelas_id)){
        abort(403);
    }

        if(!$guru->mapel->pluck('id')->contains($request->mapel_id)){
        abort(403);
    }

    $data->update([
        'siswa_id' => $request->siswa_id,
        'mapel_id' => $request->mapel_id,
        'nm' => $request->nm,
        'nr' => $request->nr,
        'n' => $request->filled('nr') ? $request->nr : $request->nm,
    ]);

    return redirect()
        ->route('pts.index')
        ->with('success','Data berhasil diperbarui');
}

public function destroy($id)
{
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    $data = Pts::with('siswa')->findOrFail($id);

    if(
        !$guru->kelas->pluck('id')->contains($data->siswa->kelas_id) ||
        !$guru->mapel->pluck('id')->contains($data->mapel_id)
    ){
        abort(403);
    }

    $data->delete();

    return redirect()
        ->route('pts.index')
        ->with('success','Data berhasil dihapus');
}
}