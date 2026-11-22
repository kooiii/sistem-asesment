<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\NilaiSumatif;
use App\Models\TahunAjaran;

class NilaiSumatifController extends Controller
{
    /**
     * Menampilkan daftar nilai STS atau SAS.
     */
    public function index(Request $request)
    {
        $guru = Guru::with(['kelas', 'mapel'])
            ->findOrFail(session('id'));

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

        return view('nilai_sumatif.index', compact(
            'data',
            'jenis'
        ));
    }

    /**
     * Halaman input dan edit nilai STS atau SAS.
     */
    public function create(Request $request)
    {
        $guru = Guru::with(['kelas', 'mapel'])
            ->findOrFail(session('id'));

        $kelasAktif = session('kelas_aktif');
        $mapelAktif = session('mapel_aktif');

        $jenis = $request->jenis ?? 'STS';

        if (!in_array($jenis, ['STS', 'SAS'])) {
            $jenis = 'STS';
        }

        // Pastikan kelas merupakan penugasan guru.
        if (!$guru->kelas->pluck('id')->contains($kelasAktif)) {
            abort(403);
        }

        // Pastikan mapel merupakan penugasan guru.
        if (!$guru->mapel->pluck('id')->contains($mapelAktif)) {
            abort(403);
        }

        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return redirect()
                ->route('nilai-sumatif.index', ['jenis' => $jenis])
                ->with('error', 'Tahun ajaran aktif belum tersedia.');
        }

        // Ambil siswa dan nilai sumatif yang sudah tersimpan.
        $siswas = Siswa::where('kelas_id', $kelasAktif)
            ->with([
                'nilaiSumatif' => function ($q) use (
                    $mapelAktif,
                    $jenis,
                    $tahun
                ) {
                    $q->where('mapel_id', $mapelAktif)
                        ->where('jenis', $jenis)
                        ->where('tahun_ajaran_id', $tahun->id);
                }
            ])
            ->orderBy('nama')
            ->get();

        return view('nilai_sumatif.create', compact(
            'guru',
            'siswas',
            'jenis',
            'tahun'
        ));
    }

    /**
     * Simpan atau perbarui nilai STS atau SAS.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:STS,SAS',

            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|exists:siswas,id',

            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $guru = Guru::with(['kelas', 'mapel'])
            ->findOrFail(session('id'));

        $kelasAktif = session('kelas_aktif');
        $mapelAktif = session('mapel_aktif');
        $jenis = $request->jenis;

        // Validasi penugasan kelas guru.
        if (!$guru->kelas->pluck('id')->contains($kelasAktif)) {
            abort(403);
        }

        // Validasi penugasan mata pelajaran guru.
        if (!$guru->mapel->pluck('id')->contains($mapelAktif)) {
            abort(403);
        }

        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return back()
                ->withInput()
                ->with('error', 'Tahun ajaran aktif belum tersedia.');
        }

        foreach ($request->siswa_id as $i => $siswaId) {

            $siswa = Siswa::findOrFail($siswaId);

            // Pastikan siswa berasal dari kelas aktif.
            if ($siswa->kelas_id != $kelasAktif) {
                abort(403);
            }

            $nilai = $request->input("nilai.$i");

            $kondisi = [
                'siswa_id' => $siswaId,
                'mapel_id' => $mapelAktif,
                'jenis' => $jenis,
                'tahun_ajaran_id' => $tahun->id,
            ];

            // Jika kolom dikosongkan, hapus nilai sebelumnya.
            if ($nilai === null || $nilai === '') {
                NilaiSumatif::where($kondisi)->delete();
                continue;
            }

            // Perbarui nilai jika sudah ada, atau buat data baru.
            NilaiSumatif::updateOrCreate(
                $kondisi,
                [
                    'nilai' => $nilai
                ]
            );
        }

        // Tetap berada di halaman input dengan jenis yang sama.
        return redirect()
            ->route('nilai-sumatif.create', [
                'jenis' => $jenis
            ])
            ->with(
                'success',
                'Nilai ' . $jenis . ' berhasil disimpan.'
            );
    }

    /**
     * Menghapus nilai sumatif.
     */
    public function destroy($id)
    {
        $guru = Guru::with(['kelas', 'mapel'])
            ->findOrFail(session('id'));

        $kelasAktif = session('kelas_aktif');
        $mapelAktif = session('mapel_aktif');

        if (!$guru->kelas->pluck('id')->contains($kelasAktif)) {
            abort(403);
        }

        if (!$guru->mapel->pluck('id')->contains($mapelAktif)) {
            abort(403);
        }

        $data = NilaiSumatif::with('siswa')
            ->findOrFail($id);

        if ($data->mapel_id != $mapelAktif) {
            abort(403);
        }

        if ($data->siswa->kelas_id != $kelasAktif) {
            abort(403);
        }

        $jenis = $data->jenis;

        $data->delete();

        return redirect()
            ->route('nilai-sumatif.index', [
                'jenis' => $jenis
            ])
            ->with('success', 'Data nilai berhasil dihapus.');
    }
}
