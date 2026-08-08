<?php

namespace App\Http\Controllers;

use App\Models\TujuanPembelajaran;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TujuanPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::with([
            'kelas',
            'mapel'
        ])->findOrFail(session('id'));

        $kelasAktifId = session('kelas_aktif');
        $mapelAktifId = session('mapel_aktif');

        if (!$guru->kelas->pluck('id')->contains($kelasAktifId)) {
            abort(403);
        }

        if (!$guru->mapel->pluck('id')->contains($mapelAktifId)) {
            abort(403);
        }

        $kelasAktif = $guru->kelas
            ->where('id', $kelasAktifId)
            ->first();

        $data = TujuanPembelajaran::where('guru_id', $guru->id)
            ->where('kelas_id', $kelasAktifId)
            ->where('mapel_id', $mapelAktifId)
            ->orderBy('nomor_tp')
            ->get();

        $nomorTP = $data->count() + 1;

        return view(
            'tujuan_pembelajaran.create',
            compact(
                'guru',
                'kelasAktif',
                'data',
                'nomorTP'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tujuan_pembelajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_tp' => 'required|integer|min:1',
            'judul_tp' => 'required|string|max:255'
        ]);

        $guru = Guru::with([
            'kelas',
            'mapel'
        ])->findOrFail(session('id'));

        $kelasAktif = session('kelas_aktif');
        $mapelAktif = session('mapel_aktif');

        if (!$guru->kelas->pluck('id')->contains($kelasAktif)) {
            abort(403);
        }

        if (!$guru->mapel->pluck('id')->contains($mapelAktif)) {
            abort(403);
        }

        $tahunAjaran = TahunAjaran::where('aktif', true)->first();

        if (!$tahunAjaran) {
            return back()->with(
                'error',
                'Belum ada Tahun Ajaran yang aktif.'
            );
        }

        TujuanPembelajaran::create([

            'guru_id'   => $guru->id,
            'kelas_id'  => $kelasAktif,
            'mapel_id'  => $mapelAktif,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'nomor_tp'  => $request->nomor_tp,
            'judul_tp'  => $request->judul_tp

        ]);

        return redirect()
            ->route('tujuan-pembelajaran.index')
            ->with(
                'success',
                'Tujuan Pembelajaran berhasil ditambahkan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guru = Guru::with([
            'kelas',
            'mapel'
        ])->findOrFail(session('id'));

        $tp = TujuanPembelajaran::findOrFail($id);

        if ($tp->guru_id != $guru->id) {
            abort(403);
        }

        return view(
            'tujuan_pembelajaran.edit',
            compact(
                'tp',
                'guru'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nomor_tp' => 'required|integer|min:1',
            'judul_tp' => 'required|string|max:255'
        ]);

        $guru = Guru::findOrFail(session('id'));

        $tp = TujuanPembelajaran::findOrFail($id);

        if ($tp->guru_id != $guru->id) {
            abort(403);
        }

        $tp->update([

            'nomor_tp' => $request->nomor_tp,

            'judul_tp' => $request->judul_tp

        ]);

        return redirect()
            ->route('tujuan-pembelajaran.index')
            ->with(
                'success',
                'Tujuan Pembelajaran berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = Guru::findOrFail(session('id'));

        $tp = TujuanPembelajaran::findOrFail($id);

        if ($tp->guru_id != $guru->id) {
            abort(403);
        }

        $tp->delete();

        return redirect()
            ->route('tujuan-pembelajaran.index')
            ->with(
                'success',
                'Tujuan Pembelajaran berhasil dihapus.'
            );
    }
}
