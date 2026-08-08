<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\NilaiFormatif;
use App\Models\NilaiSumatif;
use App\Models\SikapPresensi;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
{
    $guru = Guru::with(['kelas','mapel'])->findOrFail(session('id'));

    $tahun = TahunAjaran::where('aktif',true)->first();

    if(!$tahun){

        return back()->with(
            'error',
            'Tahun ajaran aktif belum tersedia.'
        );

    }

    if(session('role') == 'admin'){

        $siswas = Siswa::with('kelas')
                    ->orderBy('nama')
                    ->get();

    }else{

        $siswas = Siswa::with('kelas')

                    ->whereIn(
                        'kelas_id',
                        $guru->kelas->pluck('id')
                    )

                    ->orderBy('nama')
                    ->get();

    }

    $laporan = [];

    foreach($siswas as $siswa){
        $formatif = NilaiFormatif::where(
        'siswa_id',
        $siswa->id
        )

        ->where(
        'tahun_ajaran_id',
        $tahun->id
        )

        ->avg('nilai');
        $formatif = round(
        $formatif ?? 0,2
        );

        $sts = NilaiSumatif::where(
        'siswa_id',
        $siswa->id
        )

        ->where(
        'tahun_ajaran_id',
        $tahun->id
        )

        ->where(
        'jenis',
        'STS'
        )

        ->avg('nilai');
        $sts = round(
        $sts ?? 0,2
        );

        $sas = NilaiSumatif::where(
        'siswa_id',
        $siswa->id
        )

        ->where(
        'tahun_ajaran_id',
        $tahun->id
        )

        ->where(
        'jenis',
        'SAS'
        )

        ->avg('nilai');
        $sas = round(
        $sas ?? 0,2
        );

        $sikap = SikapPresensi::where(
        'siswa_id',
        $siswa->id
        )
        ->where(
        'tahun_ajaran_id',
        $tahun->id
        )
        ->first();

        $nilaiSikap = $sikap ? $sikap->sikap : 0;
        $nilaiPresensi = $sikap ? $sikap->presensi : 0;

        $nilaiAkhir = round(
        ($formatif * 0.40)+($sts * 0.30)+($sas * 0.30),2);

        if($nilaiAkhir >= 90){
            $predikat = 'A';
            }
        elseif($nilaiAkhir >= 80){
            $predikat = 'B';
            }
        elseif($nilaiAkhir >= 70){
            $predikat = 'C';
            }
        else{
            $predikat = 'D';
            }

        $laporan[] = [

        'nama' => $siswa->nama,
        'kelas' => optional($siswa->kelas)->nama_kelas,
        'mapel' => session('role') == 'admin'
        ? '-'
        : $guru->mapel
                ->pluck('nama_mapel')
                ->implode(', '),

        'formatif' => $formatif,
        'sts' => $sts,
        'sas' => $sas,
        'akhir' => $nilaiAkhir,
        'predikat' => $predikat,
        'sikap' => $nilaiSikap,
        'presensi' => $nilaiPresensi
    ];
    }

    return view('laporan.index',
    compact(
        'laporan',
        'tahun'
    )
);
}

    public function exportPdf()
{
    $guru = Guru::with(['kelas','mapel'])->find(session('id'));

    $tahun = TahunAjaran::where('aktif', true)->first();

    if(!$tahun){
        return back()->with(
            'error',
            'Tahun ajaran aktif belum tersedia.'
        );
    }

    if(session('role') == 'admin'){

        $siswas = Siswa::with('kelas')
                    ->orderBy('nama')
                    ->get();

    }else{

        $siswas = Siswa::with('kelas')
                    ->whereIn(
                        'kelas_id',
                        $guru->kelas->pluck('id')
                    )
                    ->orderBy('nama')
                    ->get();

    }

    $laporan = [];

    foreach($siswas as $siswa){

        $formatif = round(
            NilaiFormatif::where('siswa_id',$siswa->id)
                ->where('tahun_ajaran_id',$tahun->id)
                ->avg('nilai') ?? 0,
            2
        );

        $sts = round(
            NilaiSumatif::where('siswa_id',$siswa->id)
                ->where('tahun_ajaran_id',$tahun->id)
                ->where('jenis','STS')
                ->avg('nilai') ?? 0,
            2
        );

        $sas = round(
            NilaiSumatif::where('siswa_id',$siswa->id)
                ->where('tahun_ajaran_id',$tahun->id)
                ->where('jenis','SAS')
                ->avg('nilai') ?? 0,
            2
        );

        $sp = SikapPresensi::where(
                'siswa_id',
                $siswa->id
            )
            ->where(
                'tahun_ajaran_id',
                $tahun->id
            )
            ->first();

        $nilaiSikap = $sp->sikap ?? 0;

        $nilaiPresensi = $sp->presensi ?? 0;

        $akhir = round(
            ($formatif * 0.40)
            +
            ($sts * 0.30)
            +
            ($sas * 0.30),
        2);

        if($akhir >= 90){
            $predikat = 'A';
        }
        elseif($akhir >= 80){
            $predikat = 'B';
        }
        elseif($akhir >= 70){
            $predikat = 'C';
        }
        else{
            $predikat = 'D';
        }

        $laporan[] = [

            'nama' => $siswa->nama,

            'kelas' => optional($siswa->kelas)->nama_kelas,

            'mapel' => session('role') == 'admin'
                ? '-'
                : $guru->mapel
                        ->pluck('nama_mapel')
                        ->implode(', '),

            'formatif' => $formatif,

            'sts' => $sts,

            'sas' => $sas,

            'akhir' => $akhir,

            'predikat' => $predikat,

            'sikap' => $nilaiSikap,

            'presensi' => $nilaiPresensi

        ];

    }

    $pdf = Pdf::loadView(
        'laporan.pdf',
        compact(
            'laporan',
            'tahun'
        )
    );

    return $pdf->download('Laporan Nilai.pdf');
}
};
