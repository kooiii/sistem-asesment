<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\NilaiSumatif;
use App\Models\TahunAjaran;

class NilaiSumatifController extends Controller
{
    public function index(Request $request)
    {
        $guru = Guru::with([
            'kelas',
            'mapel'
        ])->findOrFail(session('id'));

        $kelasAktif = session('kelas_aktif');
        $mapelAktif = session('mapel_aktif');

        $jenis = $request->jenis ?? 'STS';

        // Pastikan jenis hanya STS atau SAS
        if (!in_array($jenis, ['STS', 'SAS'])) {
            $jenis = 'STS';
        }

        // Tahun ajaran aktif
        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }

        $data = NilaiSumatif::with([
            'siswa',
            'mapel',
            'tahunAjaran'
        ])
            ->where('jenis', $jenis)
            ->where('mapel_id', $mapelAktif)
            ->where('tahun_ajaran_id', $tahun->id)
            ->whereHas('siswa', function ($q) use ($kelasAktif) {
                $q->where('kelas_id', $kelasAktif);
            })
            ->orderBy('siswa_id')
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
        $kelasAktif = session('kelas_aktif');
        $mapelAktif = session('mapel_aktif');

        $jenis = $request->jenis ?? 'STS';

        if (!in_array($jenis, ['STS', 'SAS'])) {
            $jenis = 'STS';
        }

        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return back()->with(
                'error',
                'Tahun ajaran aktif belum tersedia.'
            );
        }

        $siswas = Siswa::where(
            'kelas_id',
            $kelasAktif
        )
            ->with([
                'nilaiSumatif' => function ($q) use (
                    $mapelAktif,
                    $jenis,
                    $tahun
                ) {
                    $q->where('mapel_id', $mapelAktif)
                        ->where('jenis', $jenis)
                        ->where(
                            'tahun_ajaran_id',
                            $tahun->id
                        );
                }
            ])
            ->orderBy('nama')
            ->get();

        return view(
            'nilai_sumatif.create',
            compact(
                'siswas',
                'jenis'
            )
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:STS,SAS',

            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|exists:siswas,id',

            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $guru = Guru::with([
            'kelas',
            'mapel'
        ])->findOrFail(session('id'));

        $kelasAktif = session('kelas_aktif');
        $mapelAktif = session('mapel_aktif');

        // Pastikan guru memang mengajar kelas tersebut
        if (!$guru->kelas->pluck('id')->contains($kelasAktif)) {
            abort(403);
        }

        // Pastikan guru memang mengajar mapel tersebut
        if (!$guru->mapel->pluck('id')->contains($mapelAktif)) {
            abort(403);
        }

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

        foreach ($request->siswa_id as $i => $siswaId) {

            $siswa = Siswa::findOrFail($siswaId);

            // Pastikan siswa berasal dari kelas aktif
            if ($siswa->kelas_id != $kelasAktif) {
                continue;
            }

            $nilai = $request->nilai[$i] ?? null;

            // Jika nilai kosong, jangan simpan
            if ($nilai === '' || $nilai === null) {
                continue;
            }

            NilaiSumatif::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelAktif,
                    'jenis' => $request->jenis,
                    'tahun_ajaran_id' => $tahun->id
                ],
                [
                    'nilai' => $nilai
                ]
            );
        }

        return redirect()
            ->route(
                'nilai-sumatif.index',
                [
                    'jenis' => $request->jenis
                ]
            )
            ->with(
                'success',
                'Nilai ' .
                $request->jenis .
                ' berhasil disimpan.'
            );
    }


    public function destroy($id)
    {
        $guru = Guru::with([
            'kelas',
            'mapel'
        ])->findOrFail(session('id'));

        $kelasAktif = session('kelas_aktif');
        $mapelAktif = session('mapel_aktif');

        $data = NilaiSumatif::with('siswa')
            ->findOrFail($id);

        // Pastikan mapel sesuai
        if ($data->mapel_id != $mapelAktif) {
            abort(403);
        }

        // Pastikan siswa berasal dari kelas aktif
        if ($data->siswa->kelas_id != $kelasAktif) {
            abort(403);
        }

        $jenis = $data->jenis;

        $data->delete();

        return redirect()
            ->route(
                'nilai-sumatif.index',
                [
                    'jenis' => $jenis
                ]
            )
            ->with(
                'success',
                'Data nilai berhasil dihapus.'
            );
    }
}