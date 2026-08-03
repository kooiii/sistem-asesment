<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\TahunAjaran;
use App\Models\NilaiFormatif;
use App\Models\NilaiSumatif;
use App\Models\SikapPresensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RaporController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::with(['kelas', 'mapel'])
                    ->findOrFail(session('id'));

        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return back()->with('error', 'Tahun ajaran aktif belum tersedia.');
        }

        $kelasIds = $guru->kelas->pluck('id');

        $mapelIds = $guru->mapel->pluck('id');

        $siswas = Siswa::with('kelas')
                        ->whereIn('kelas_id', $kelasIds)
                        ->orderBy('nama')
                        ->get();

        return view('rapor.index', compact(
            'guru',
            'tahun',
            'siswas',
            'mapelIds'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

        $tahun = TahunAjaran::where('aktif', true)->firstOrFail();

        $siswa = Siswa::with('kelas')->findOrFail($id);

        if (!$guru->kelas->pluck('id')->contains($siswa->kelas_id)) {
            abort(403);
        }

        $mapel = Mapel::findOrFail(session('mapel_aktif'));

        if (!$guru->mapel->pluck('id')->contains($mapel->id)) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | NILAI FORMATIF
        |--------------------------------------------------------------------------
        */

        $formatif = NilaiFormatif::whereHas('tp', function ($q) use ($mapel, $siswa) {

            $q->where('mapel_id', $mapel->id)
            ->where('kelas_id', $siswa->kelas_id);

        })
        ->where('siswa_id', $siswa->id)
        ->avg('nilai') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | NILAI STS
        |--------------------------------------------------------------------------
        */

        $sts = NilaiSumatif::where([
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'tahun_ajaran_id' => $tahun->id,
            'jenis' => 'STS'
        ])->value('nilai') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | NILAI SAS
        |--------------------------------------------------------------------------
        */

        $sas = NilaiSumatif::where([
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'tahun_ajaran_id' => $tahun->id,
            'jenis' => 'SAS'
        ])->value('nilai') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | SIKAP DAN PRESENSI
        |--------------------------------------------------------------------------
        */

        $sikap = SikapPresensi::where([
            'siswa_id' => $siswa->id,
            'tahun_ajaran_id' => $tahun->id
        ])->first();

        $nilaiSikap = $sikap->sikap ?? 0;
        $nilaiPresensi = $sikap->presensi ?? 0;

        $nilaiSikapPresensi = round(
            ($nilaiSikap + $nilaiPresensi) / 2,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | PERHITUNGAN NILAI AKHIR
        |--------------------------------------------------------------------------
        */

        $nilaiAkhir = round(

            ($formatif * 0.50)

            +

            ($sts * 0.15)

            +

            ($sas * 0.20)

            +

            ($nilaiSikapPresensi * 0.15),

        2);

        /*
        |--------------------------------------------------------------------------
        | PREDIKAT
        |--------------------------------------------------------------------------
        */

        if ($nilaiAkhir >= 90) {

            $predikat = 'A';

        } elseif ($nilaiAkhir >= 80) {

            $predikat = 'B';

        } elseif ($nilaiAkhir >= 70) {

            $predikat = 'C';

        } else {

            $predikat = 'D';

        }

        /*
        |--------------------------------------------------------------------------
        | DESKRIPSI
        |--------------------------------------------------------------------------
        */

        switch ($predikat) {

            case 'A':
                $deskripsi = 'Sangat Baik';
                break;

            case 'B':
                $deskripsi = 'Baik';
                break;

            case 'C':
                $deskripsi = 'Cukup';
                break;

            default:
                $deskripsi = 'Perlu Bimbingan';

        }

        return view(
            'rapor.show',
            compact(
                'guru',
                'tahun',
                'siswa',
                'mapel',
                'formatif',
                'sts',
                'sas',
                'sikap',
                'nilaiSikapPresensi',
                'nilaiAkhir',
                'predikat',
                'deskripsi'
            )
        );
    }

    public function pdf($id)
    {
        $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

        $tahun = TahunAjaran::where('aktif', true)->firstOrFail();

        $siswa = Siswa::with('kelas')->findOrFail($id);

        if (!$guru->kelas->pluck('id')->contains($siswa->kelas_id)) {
            abort(403);
        }

        $mapel = Mapel::findOrFail(session('mapel_aktif'));

        if (!$guru->mapel->pluck('id')->contains($mapel->id)) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | NILAI FORMATIF
        |--------------------------------------------------------------------------
        */

        $formatif = NilaiFormatif::whereHas('tp', function ($q) use ($mapel, $siswa) {

            $q->where('mapel_id', $mapel->id)
            ->where('kelas_id', $siswa->kelas_id);

        })
        ->where('siswa_id', $siswa->id)
        ->avg('nilai') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | NILAI STS
        |--------------------------------------------------------------------------
        */

        $sts = NilaiSumatif::where([
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'tahun_ajaran_id' => $tahun->id,
            'jenis' => 'STS'
        ])->value('nilai') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | NILAI SAS
        |--------------------------------------------------------------------------
        */

        $sas = NilaiSumatif::where([
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'tahun_ajaran_id' => $tahun->id,
            'jenis' => 'SAS'
        ])->value('nilai') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | SIKAP DAN PRESENSI
        |--------------------------------------------------------------------------
        */

        $sikap = SikapPresensi::where([
            'siswa_id' => $siswa->id,
            'tahun_ajaran_id' => $tahun->id
        ])->first();

        $nilaiSikap = $sikap->sikap ?? 0;

        $nilaiPresensi = $sikap->presensi ?? 0;

        $nilaiSikapPresensi = round(

            ($nilaiSikap + $nilaiPresensi) / 2,

            2

        );

        /*
        |--------------------------------------------------------------------------
        | NILAI AKHIR
        |--------------------------------------------------------------------------
        */

        $nilaiAkhir = round(

            ($formatif * 0.50)

            +

            ($sts * 0.15)

            +

            ($sas * 0.20)

            +

            ($nilaiSikapPresensi * 0.15),

            2

        );

        /*
        |--------------------------------------------------------------------------
        | PREDIKAT
        |--------------------------------------------------------------------------
        */

        if ($nilaiAkhir >= 90) {

            $predikat = 'A';

        } elseif ($nilaiAkhir >= 80) {

            $predikat = 'B';

        } elseif ($nilaiAkhir >= 70) {

            $predikat = 'C';

        } else {

            $predikat = 'D';

        }

        /*
        |--------------------------------------------------------------------------
        | DESKRIPSI
        |--------------------------------------------------------------------------
        */

        switch ($predikat) {

            case 'A':
                $deskripsi = 'Sangat Baik';
                break;

            case 'B':
                $deskripsi = 'Baik';
                break;

            case 'C':
                $deskripsi = 'Cukup';
                break;

            default:
                $deskripsi = 'Perlu Bimbingan';
                break;

        }

        $pdf = Pdf::loadView(
            'rapor.pdf',
            compact(
                'guru',
                'tahun',
                'siswa',
                'mapel',
                'formatif',
                'sts',
                'sas',
                'sikap',
                'nilaiSikapPresensi',
                'nilaiAkhir',
                'predikat',
                'deskripsi'
            )
        );

        return $pdf->download(
            'Rapor_'.$siswa->nama.'.pdf'
        );
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
