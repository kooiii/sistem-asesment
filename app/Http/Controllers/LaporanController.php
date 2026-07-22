<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Nilai;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        // ADMIN
        if(session('role') == 'admin'){

            $siswas = Siswa::with('kelas')->get();

            $laporan = [];

            foreach($siswas as $siswa){

                $formatif = Nilai::where('siswa_id',$siswa->id)
                    ->where('jenis','formatif')
                    ->avg('nilai');

                $sumatif = Nilai::where('siswa_id',$siswa->id)
                    ->where('jenis','sumatif')
                    ->avg('nilai');

                $nilaiAkhir = (($formatif ?? 0) * 0.4) + (($sumatif ?? 0) * 0.6);

                $laporan[] = [
                    'nama' => $siswa->nama,
                    'kelas' => $siswa->kelas->nama_kelas ?? '-',
                    'mapel' => 'Semua Mata Pelajaran',
                    'formatif' => round($formatif,2),
                    'sumatif' => round($sumatif,2),
                    'akhir' => round($nilaiAkhir,2),
                ];
            }

        }

        // GURU
        else{

            $guru = Guru::with(['kelas','mapel'])->find(session('id'));

            $kelasIds = $guru->kelas->pluck('id');

            $mapelIds = $guru->mapel->pluck('id');

            $siswas = Siswa::with('kelas')
                        ->whereIn('kelas_id',$kelasIds)
                        ->get();

            $laporan = [];

            foreach($siswas as $siswa){

                $formatif = Nilai::where('siswa_id',$siswa->id)
                    ->whereIn('mapel_id',$mapelIds)
                    ->where('jenis','formatif')
                    ->avg('nilai');

                $sumatif = Nilai::where('siswa_id',$siswa->id)
                    ->whereIn('mapel_id',$mapelIds)
                    ->where('jenis','sumatif')
                    ->avg('nilai');

                $nilaiAkhir = (($formatif ?? 0) * 0.4) + (($sumatif ?? 0) * 0.6);

                $laporan[] = [
                    'nama' => $siswa->nama,
                    'kelas' => $siswa->kelas->nama_kelas ?? '-',
                    'mapel' => $guru->mapel->pluck('nama_mapel')->implode(', '),
                    'formatif' => round($formatif,2),
                    'sumatif' => round($sumatif,2),
                    'akhir' => round($nilaiAkhir,2),
                ];
            }

        }

        return view('laporan.index', compact('laporan'));
    }

    public function exportPdf()
    {
        // ADMIN
        if(session('role') == 'admin'){

            $siswas = Siswa::with('kelas')->get();

            $laporan = [];

            foreach($siswas as $siswa){

                $formatif = Nilai::where('siswa_id',$siswa->id)
                    ->where('jenis','formatif')
                    ->avg('nilai');

                $sumatif = Nilai::where('siswa_id',$siswa->id)
                    ->where('jenis','sumatif')
                    ->avg('nilai');

                $nilaiAkhir = (($formatif ?? 0) * 0.4) + (($sumatif ?? 0) * 0.6);

                $laporan[] = [
                    'nama' => $siswa->nama,
                    'kelas' => $siswa->kelas->nama_kelas ?? '-',
                    'mapel' => 'Semua Mata Pelajaran',
                    'formatif' => round($formatif,2),
                    'sumatif' => round($sumatif,2),
                    'akhir' => round($nilaiAkhir,2),
                ];
            }

        }

        // GURU
        else{

            $guru = Guru::with(['kelas','mapel'])->find(session('id'));

            $kelasIds = $guru->kelas->pluck('id');

            $mapelIds = $guru->mapel->pluck('id');

            $siswas = Siswa::with('kelas')
                        ->whereIn('kelas_id',$kelasIds)
                        ->get();

            $laporan = [];

            foreach($siswas as $siswa){

                $formatif = Nilai::where('siswa_id',$siswa->id)
                    ->whereIn('mapel_id',$mapelIds)
                    ->where('jenis','formatif')
                    ->avg('nilai');

                $sumatif = Nilai::where('siswa_id',$siswa->id)
                    ->whereIn('mapel_id',$mapelIds)
                    ->where('jenis','sumatif')
                    ->avg('nilai');

                $nilaiAkhir = (($formatif ?? 0) * 0.4) + (($sumatif ?? 0) * 0.6);

                $laporan[] = [
                    'nama' => $siswa->nama,
                    'kelas' => $siswa->kelas->nama_kelas ?? '-',
                    'mapel' => $guru->mapel->pluck('nama_mapel')->implode(', '),
                    'formatif' => round($formatif,2),
                    'sumatif' => round($sumatif,2),
                    'akhir' => round($nilaiAkhir,2),
                ];
            }

        }

        $pdf = Pdf::loadView('laporan.pdf', compact('laporan'));

        return $pdf->download('laporan_nilai.pdf');
    }
}