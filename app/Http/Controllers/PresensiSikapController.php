<?php

namespace App\Http\Controllers;

use App\Models\PresensiSikap;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class PresensiSikapController extends Controller
{
    public function index()
{
    if(session('role') == 'admin'){

        $data = PresensiSikap::with(['siswa.kelas'])
                    ->latest()
                    ->get();

    }else{

        $guru = Guru::with('kelas')->findOrFail(session('id'));

        $kelasIds = $guru->kelas->pluck('id');

        $data = PresensiSikap::with(['siswa.kelas'])
                    ->whereHas('siswa', function($q) use ($kelasIds){
                        $q->whereIn('kelas_id',$kelasIds);
                    })
                    ->latest()
                    ->get();
    }

    return view('presensi.index', compact('data'));
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

        return view('presensi.create', [
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
            'siswa_id'=>'required',
            'presensi'=>'required',
            'sikap'=>'required'
        ]);

        $guru = Guru::with('kelas')->findOrFail(session('id'));
        $siswa = Siswa::findOrFail($request->siswa_id);
        if(!$guru->kelas->pluck('id')->contains($siswa->kelas_id)){abort(403);}
        $nilaiAkhir = ($request->presensi + $request->sikap) / 2;

        PresensiSikap::create([
            'siswa_id'=>$request->siswa_id,
            'presensi'=>$request->presensi,
            'sikap'=>$request->sikap,
            'nm'=>$nilaiAkhir,
            'n'=>$nilaiAkhir,
        ]);

        return redirect()
        ->route('presensi.index')
        ->with('success','Data berhasil disimpan');
    }

    public function edit($id)
{
    $guru = Guru::with('kelas')->findOrFail(session('id'));

    $kelasIds = $guru->kelas->pluck('id');

    $data = PresensiSikap::with('siswa')->findOrFail($id);

    if(!$kelasIds->contains($data->siswa->kelas_id)){
        abort(403);
    }

    $siswas = Siswa::whereIn('kelas_id',$kelasIds)->get();

    return view('presensi.edit', compact(
        'data',
        'siswas'
    ));
}

public function update(Request $request, $id)
{
    $guru = Guru::with('kelas')->findOrFail(session('id'));

    $siswa = Siswa::findOrFail($request->siswa_id);

    if(!$guru->kelas->pluck('id')->contains($siswa->kelas_id)){
        abort(403);
    }

    $nilaiAkhir = ($request->presensi + $request->sikap) / 2;

    $data = PresensiSikap::findOrFail($id);

    $data->update([
        'siswa_id'=>$request->siswa_id,
        'presensi'=>$request->presensi,
        'sikap'=>$request->sikap,
        'nm'=>$nilaiAkhir,
        'n'=>$nilaiAkhir,
    ]);

    return redirect()
        ->route('presensi.index')
        ->with('success','Data berhasil diperbarui');
}

public function destroy($id)
{
    $guru = Guru::with('kelas')->findOrFail(session('id'));

    $data = PresensiSikap::with('siswa')->findOrFail($id);

    if(!$guru->kelas->pluck('id')->contains($data->siswa->kelas_id)){
        abort(403);
    }

    $data->delete();

    return redirect()
        ->route('presensi.index')
        ->with('success','Data berhasil dihapus');
}
}