<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\NilaiSumatif;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class NilaiSumatifController extends Controller
{
    public function index(Request $request)
    {
        $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

        $jenis = $request->jenis ?? 'STS';

        $data = NilaiSumatif::with([
            'siswa.kelas',
            'mapel',
            'tahunAjaran'
        ])
        ->where('jenis',$jenis)
        ->whereIn('mapel_id',$guru->mapel->pluck('id'))
        ->whereHas('siswa',function($q) use($guru){

            $q->whereIn(
                'kelas_id',
                $guru->kelas->pluck('id')
            );

        })
        ->latest()
        ->get();

        return view(
            'nilai_sumatif.index',
            compact(
                'data',
                'jenis'
            )
        );
    }

    public function create(Request $request)
{
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    $kelasDipilih = $request->kelas;

    $mapelDipilih = $request->mapel_id;

    $jenis = $request->jenis ?? 'STS';

    $tahun = TahunAjaran::where('aktif', true)->first();

    if($kelasDipilih){

        $siswas = Siswa::where('kelas_id',$kelasDipilih)
            ->with(['nilaiSumatif'=>function($q) use($mapelDipilih,$jenis,$tahun){

                if($tahun){

                    $q->where('mapel_id',$mapelDipilih)
                      ->where('jenis',$jenis)
                      ->where('tahun_ajaran_id',$tahun->id);

                }

            }])
            ->orderBy('nama')
            ->get();

    }else{

        $siswas = collect();

    }

    return view(
        'nilai_sumatif.create',
        compact(
            'guru',
            'siswas',
            'jenis',
            'kelasDipilih',
            'mapelDipilih'
        )
    );
}

    public function store(Request $request)
{
    $request->validate([
        'mapel_id' => 'required|exists:mapels,id',
        'jenis' => 'required|in:STS,SAS',
        'siswa_id' => 'required|array',
        'nilai' => 'required|array'
    ]);

    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    if(!$guru->mapel->pluck('id')->contains($request->mapel_id)){
        abort(403);
    }

    $tahun = TahunAjaran::where('aktif', true)->first();

    if(!$tahun){
        return back()->with('error','Tahun ajaran aktif belum tersedia.');
    }

    foreach($request->siswa_id as $i => $siswaId){

        $siswa = Siswa::findOrFail($siswaId);

        if(!$guru->kelas->pluck('id')->contains($siswa->kelas_id)){
            continue;
        }

        NilaiSumatif::updateOrCreate(
            [
                'siswa_id'=>$siswaId,
                'mapel_id'=>$request->mapel_id,
                'jenis'=>$request->jenis,
                'tahun_ajaran_id'=>$tahun->id
            ],

            [
                'nilai'=>$request->nilai[$i]
            ]

        );

    }

    return redirect()
            ->route('nilai-sumatif.index',[
                'jenis'=>$request->jenis
            ])
            ->with('success','Nilai berhasil disimpan.');
}

public function destroy($id)
{
    $data = NilaiSumatif::findOrFail($id);

    $jenis = $data->jenis;

    $data->delete();

    return redirect()
            ->route(
                'nilai-sumatif.index',
                [
                    'jenis'=>$jenis
                ]
            )
            ->with(
                'success',
                'Data berhasil dihapus.'
            );
}
}