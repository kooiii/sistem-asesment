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
     * Daftar siswa untuk melihat rapor.
     */
    public function index()
    {
        $role = session('role');

        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return back()->with('error', 'Tahun ajaran aktif belum tersedia.');
        }

        $guru = null;

        if ($role === 'admin') {

            // Admin dapat melihat seluruh siswa dan mata pelajaran.
            $siswas = Siswa::with('kelas')
                ->orderBy('nama')
                ->get();

            $mapels = Mapel::orderBy('nama_mapel')->get();

        } elseif ($role === 'guru') {

            $guru = Guru::with(['kelas', 'mapel'])
                ->findOrFail(session('id'));

            $kelasIds = $guru->kelas->pluck('id');

            $siswas = Siswa::with('kelas')
                ->whereIn('kelas_id', $kelasIds)
                ->orderBy('nama')
                ->get();

            $mapels = $guru->mapel
                ->sortBy('nama_mapel')
                ->values();

        } else {
            abort(403);
        }

        return view('rapor.index', compact(
            'guru',
            'tahun',
            'siswas',
            'mapels'
        ));
    }


    /**
     * Menampilkan rapor siswa.
     */
    public function show(Request $request, $id)
    {
        $data = $this->getDataRapor($request, $id);

        return view('rapor.show', $data);
    }


    /**
     * Menghasilkan PDF rapor.
     */
    public function pdf(Request $request, $id)
    {
        $data = $this->getDataRapor($request, $id);

        $pdf = Pdf::loadView('rapor.pdf', $data);

        return $pdf->download(
            'Rapor_' . $data['siswa']->nama . '.pdf'
        );
    }


    /**
     * Mengambil dan menghitung data rapor.
     */
    private function getDataRapor(Request $request, $id)
    {
        $role = session('role');

        $tahun = TahunAjaran::where('aktif', true)->firstOrFail();

        $siswa = Siswa::with('kelas')->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN MATA PELAJARAN DAN GURU
        |--------------------------------------------------------------------------
        */

        if ($role === 'admin') {

            // Admin memilih mapel melalui parameter URL.
            $mapelId = $request->input('mapel_id');

            if (!$mapelId) {
                abort(400, 'Mata pelajaran harus dipilih.');
            }

            $mapel = Mapel::findOrFail($mapelId);

            // Cari guru yang mengampu kelas dan mata pelajaran tersebut.
            $guru = Guru::with(['kelas', 'mapel'])
                ->whereHas('kelas', function ($query) use ($siswa) {
                    $query->where('kelas.id', $siswa->kelas_id);
                })
                ->whereHas('mapel', function ($query) use ($mapel) {
                    $query->where('mapel.id', $mapel->id);
                })
                ->first();

            if (!$guru) {
                abort(404, 'Guru pengampu mata pelajaran tidak ditemukan.');
            }

        } elseif ($role === 'guru') {

            $guru = Guru::with(['kelas', 'mapel'])
                ->findOrFail(session('id'));

            // Pastikan siswa termasuk kelas yang diampu Guru.
            if (!$guru->kelas->pluck('id')->contains($siswa->kelas_id)) {
                abort(403);
            }

            // Gunakan mapel yang dipilih, atau konteks aktif Guru.
            $mapelId = $request->input(
                'mapel_id',
                session('mapel_aktif')
            );

            if (!$mapelId) {
                abort(400, 'Mata pelajaran belum dipilih.');
            }

            $mapel = Mapel::findOrFail($mapelId);

            // Pastikan Guru mengampu mata pelajaran tersebut.
            if (!$guru->mapel->pluck('id')->contains($mapel->id)) {
                abort(403);
            }

        } else {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | NILAI FORMATIF
        |--------------------------------------------------------------------------
        */

        $formatif = NilaiFormatif::whereHas('tp', function ($query) use ($mapel, $siswa) {
            $query->where('mapel_id', $mapel->id)
                ->where('kelas_id', $siswa->kelas_id);
        })
            ->where('siswa_id', $siswa->id)
            ->where('tahun_ajaran_id', $tahun->id)
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
            ($formatif * 0.50) +
            ($sts * 0.15) +
            ($sas * 0.20) +
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


        return compact(
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
        );
    }
}
