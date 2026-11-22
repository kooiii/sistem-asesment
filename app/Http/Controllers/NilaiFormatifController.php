<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\NilaiFormatif;
use App\Models\TujuanPembelajaran;
use App\Models\TahunAjaran;

class NilaiFormatifController extends Controller
{
    /**
     * Daftar TP.
     */
    public function index()
    {
        return redirect()->route('tujuan-pembelajaran.index');
    }

    /**
     * Halaman input dan edit nilai formatif.
     */
    public function create(Request $request)
    {
        $guru = Guru::with(['kelas', 'mapel'])
            ->findOrFail(session('id'));

        $request->validate([
            'tp' => 'required|exists:tujuan_pembelajarans,id',
        ]);

        $tp = TujuanPembelajaran::with(['kelas', 'mapel'])
            ->findOrFail($request->tp);

        // Validasi kepemilikan TP dan konteks mengajar guru.
        if (
            $tp->guru_id != $guru->id ||
            $tp->kelas_id != session('kelas_aktif') ||
            $tp->mapel_id != session('mapel_aktif')
        ) {
            abort(403);
        }

        // Tahun ajaran aktif.
        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return redirect()
                ->route('tujuan-pembelajaran.index')
                ->with('error', 'Tahun ajaran aktif belum tersedia.');
        }

        // Ambil seluruh siswa pada kelas aktif.
        $siswas = Siswa::where('kelas_id', session('kelas_aktif'))
            ->orderBy('nama')
            ->get();

        // Ambil nilai yang sudah tersimpan agar tetap tampil
        // ketika halaman dibuka kembali setelah penyimpanan.
        foreach ($siswas as $siswa) {
            $nilai = NilaiFormatif::where('tp_id', $tp->id)
                ->where('siswa_id', $siswa->id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->get()
                ->keyBy('teknik');

            $siswa->tugas = optional($nilai->get('Tugas'))->nilai;
            $siswa->kuis = optional($nilai->get('Kuis'))->nilai;
            $siswa->praktik = optional($nilai->get('Praktik'))->nilai;
            $siswa->presentasi = optional($nilai->get('Presentasi'))->nilai;

            $daftarNilai = array_filter([
                $siswa->tugas,
                $siswa->kuis,
                $siswa->praktik,
                $siswa->presentasi,
            ], function ($value) {
                return $value !== null;
            });

            $siswa->rata = count($daftarNilai)
                ? round(array_sum($daftarNilai) / count($daftarNilai), 2)
                : null;
        }

        return view('nilai_formatif.create', compact(
            'guru',
            'tp',
            'siswas',
            'tahun'
        ));
    }

    /**
     * Simpan atau perbarui nilai formatif.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tp_id' => 'required|exists:tujuan_pembelajarans,id',

            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|exists:siswas,id',

            'tugas' => 'nullable|array',
            'tugas.*' => 'nullable|numeric|min:0|max:100',

            'kuis' => 'nullable|array',
            'kuis.*' => 'nullable|numeric|min:0|max:100',

            'praktik' => 'nullable|array',
            'praktik.*' => 'nullable|numeric|min:0|max:100',

            'presentasi' => 'nullable|array',
            'presentasi.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $guru = Guru::findOrFail(session('id'));
        $tp = TujuanPembelajaran::findOrFail($request->tp_id);

        // Validasi kepemilikan TP dan konteks mengajar guru.
        if (
            $tp->guru_id != $guru->id ||
            $tp->kelas_id != session('kelas_aktif') ||
            $tp->mapel_id != session('mapel_aktif')
        ) {
            abort(403);
        }

        $tahun = TahunAjaran::where('aktif', true)->first();

        if (!$tahun) {
            return back()
                ->withInput()
                ->with('error', 'Tahun ajaran aktif belum tersedia.');
        }

        // Simpan atau perbarui nilai setiap siswa.
        foreach ($request->siswa_id as $i => $siswaId) {
            $siswa = Siswa::findOrFail($siswaId);

            // Pastikan siswa memang berasal dari kelas aktif.
            if ($siswa->kelas_id != session('kelas_aktif')) {
                abort(403);
            }

            $nilaiArray = [
                'Tugas' => $request->input("tugas.$i"),
                'Kuis' => $request->input("kuis.$i"),
                'Praktik' => $request->input("praktik.$i"),
                'Presentasi' => $request->input("presentasi.$i"),
            ];

            foreach ($nilaiArray as $teknik => $nilai) {
                $kondisi = [
                    'tp_id' => $tp->id,
                    'siswa_id' => $siswaId,
                    'teknik' => $teknik,
                    'tahun_ajaran_id' => $tahun->id,
                ];

                if ($nilai === null || $nilai === '') {
                    // Jika kolom dikosongkan, hapus nilai lama untuk teknik tersebut.
                    NilaiFormatif::where($kondisi)->delete();
                    continue;
                }

                // Jika sudah ada, perbarui. Jika belum ada, buat data baru.
                NilaiFormatif::updateOrCreate(
                    $kondisi,
                    ['nilai' => $nilai]
                );
            }
        }

        // Kembali ke halaman input TP yang sama, bukan ke daftar TP.
        return redirect()
            ->route('nilai-formatif.create', ['tp' => $tp->id])
            ->with('success', 'Nilai Formatif berhasil disimpan.');
    }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit(string $id)
    {
        abort(404);
    }

    public function update(Request $request, string $id)
    {
        abort(404);
    }

    public function destroy(string $id)
    {
        abort(404);
    }
}
