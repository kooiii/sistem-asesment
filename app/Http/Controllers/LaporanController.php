<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\NilaiFormatif;
use App\Models\NilaiSumatif;
use App\Models\SikapPresensi;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Menampilkan laporan nilai.
     */
    public function index()
    {
        $guru = Guru::with(['kelas', 'mapel'])
            ->findOrFail(session('id'));

        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil siswa sesuai hak akses
        |--------------------------------------------------------------------------
        */

        if (session('role') == 'admin') {

            $siswas = Siswa::with('kelas')
                ->orderBy('nama')
                ->get();

            $mapels = Mapel::orderBy('nama_mapel')->get();

        } else {

            $siswas = Siswa::with('kelas')
                ->whereIn(
                    'kelas_id',
                    $guru->kelas->pluck('id')
                )
                ->orderBy('nama')
                ->get();

            $mapels = $guru->mapel;
        }

        /*
        |--------------------------------------------------------------------------
        | Bentuk laporan
        |--------------------------------------------------------------------------
        */

        $laporan = [];

        foreach ($siswas as $siswa) {

            foreach ($mapels as $mapel) {

                /*
                |--------------------------------------------------------------------------
                | Pastikan siswa memiliki data yang relevan dengan mapel
                |--------------------------------------------------------------------------
                */

                $adaFormatif = NilaiFormatif::where(
                    'siswa_id',
                    $siswa->id
                )
                ->where(
                    'tahun_ajaran_id',
                    $tahun->id
                )
                ->whereHas('tp', function ($q) use ($mapel, $siswa) {

                    $q->where('mapel_id', $mapel->id)
                      ->where('kelas_id', $siswa->kelas_id);

                })
                ->exists();

                $adaSumatif = NilaiSumatif::where([
                    'siswa_id' => $siswa->id,
                    'mapel_id' => $mapel->id,
                    'tahun_ajaran_id' => $tahun->id
                ])->exists();

                /*
                |--------------------------------------------------------------------------
                | Jika belum ada data nilai pada mapel tersebut,
                | jangan tampilkan baris laporan
                |--------------------------------------------------------------------------
                */

                if (!$adaFormatif && !$adaSumatif) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | NILAI FORMATIF
                |--------------------------------------------------------------------------
                */

                $formatif = NilaiFormatif::where(
                    'siswa_id',
                    $siswa->id
                )
                ->where(
                    'tahun_ajaran_id',
                    $tahun->id
                )
                ->whereHas('tp', function ($q) use ($mapel, $siswa) {

                    $q->where('mapel_id', $mapel->id)
                      ->where('kelas_id', $siswa->kelas_id);

                })
                ->avg('nilai');

                $formatif = round(
                    $formatif ?? 0,
                    2
                );

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
                ])->avg('nilai');

                $sts = round(
                    $sts ?? 0,
                    2
                );

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
                ])->avg('nilai');

                $sas = round(
                    $sas ?? 0,
                    2
                );

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
                | SIMPAN DATA LAPORAN
                |--------------------------------------------------------------------------
                */

                $laporan[] = [

                    'nama' => $siswa->nama,

                    'kelas' => optional(
                        $siswa->kelas
                    )->nama_kelas,

                    'mapel' => $mapel->nama_mapel,

                    'formatif' => $formatif,

                    'sts' => $sts,

                    'sas' => $sas,

                    'sikap' => $nilaiSikap,

                    'presensi' => $nilaiPresensi,

                    'nilai_sikap_presensi' =>
                        $nilaiSikapPresensi,

                    'akhir' => $nilaiAkhir,

                    'predikat' => $predikat
                ];
            }
        }

        return view(
            'laporan.index',
            compact(
                'laporan',
                'tahun'
            )
        );
    }

    /**
     * Export laporan ke PDF.
     */
    public function exportPdf()
    {
        $guru = Guru::with(['kelas', 'mapel'])
            ->findOrFail(session('id'));

        $tahun = TahunAjaran::where(
            'aktif',
            true
        )->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil siswa dan mapel
        |--------------------------------------------------------------------------
        */

        if (session('role') == 'admin') {

            $siswas = Siswa::with('kelas')
                ->orderBy('nama')
                ->get();

            $mapels = Mapel::orderBy('nama_mapel')->get();

        } else {

            $siswas = Siswa::with('kelas')
                ->whereIn(
                    'kelas_id',
                    $guru->kelas->pluck('id')
                )
                ->orderBy('nama')
                ->get();

            $mapels = $guru->mapel;
        }

        /*
        |--------------------------------------------------------------------------
        | Bentuk laporan
        |--------------------------------------------------------------------------
        */

        $laporan = [];

        foreach ($siswas as $siswa) {

            foreach ($mapels as $mapel) {

                $adaFormatif = NilaiFormatif::where(
                    'siswa_id',
                    $siswa->id
                )
                ->where(
                    'tahun_ajaran_id',
                    $tahun->id
                )
                ->whereHas('tp', function ($q) use ($mapel, $siswa) {

                    $q->where('mapel_id', $mapel->id)
                      ->where('kelas_id', $siswa->kelas_id);

                })
                ->exists();

                $adaSumatif = NilaiSumatif::where([
                    'siswa_id' => $siswa->id,
                    'mapel_id' => $mapel->id,
                    'tahun_ajaran_id' => $tahun->id
                ])->exists();

                if (!$adaFormatif && !$adaSumatif) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | NILAI FORMATIF
                |--------------------------------------------------------------------------
                */

                $formatif = NilaiFormatif::where(
                    'siswa_id',
                    $siswa->id
                )
                ->where(
                    'tahun_ajaran_id',
                    $tahun->id
                )
                ->whereHas('tp', function ($q) use ($mapel, $siswa) {

                    $q->where('mapel_id', $mapel->id)
                      ->where('kelas_id', $siswa->kelas_id);

                })
                ->avg('nilai');

                $formatif = round(
                    $formatif ?? 0,
                    2
                );

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
                ])->avg('nilai');

                $sts = round(
                    $sts ?? 0,
                    2
                );

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
                ])->avg('nilai');

                $sas = round(
                    $sas ?? 0,
                    2
                );

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

                $laporan[] = [

                    'nama' => $siswa->nama,

                    'kelas' => optional(
                        $siswa->kelas
                    )->nama_kelas,

                    'mapel' => $mapel->nama_mapel,

                    'formatif' => $formatif,

                    'sts' => $sts,

                    'sas' => $sas,

                    'sikap' => $nilaiSikap,

                    'presensi' => $nilaiPresensi,

                    'nilai_sikap_presensi' =>
                        $nilaiSikapPresensi,

                    'akhir' => $nilaiAkhir,

                    'predikat' => $predikat
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'laporan.pdf',
            compact(
                'laporan',
                'tahun'
            )
        );

        return $pdf->download(
            'Laporan Nilai.pdf'
        );
    }
}