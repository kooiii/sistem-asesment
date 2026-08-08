<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa.
     */
    public function index()
    {
        $data = Siswa::with('kelas')
            ->orderBy('nama')
            ->get();

        return view(
            'admin.siswa.index',
            compact('data')
        );
    }

    /**
     * Menampilkan form tambah siswa.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')
            ->get();

        return view(
            'siswa.create',
            compact('kelas')
        );
    }

    /**
     * Menyimpan data siswa baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nama' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id
        ]);

        return redirect()
            ->route('siswa.index')
            ->with(
                'success',
                'Data siswa berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan form edit siswa.
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        $kelas = Kelas::orderBy('nama_kelas')
            ->get();

        return view(
            'siswa.edit',
            compact(
                'siswa',
                'kelas'
            )
        );
    }

    /**
     * Memperbarui data siswa.
     */
    public function update(
        Request $request,
        $id
    ) {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id
        ]);

        return redirect()
            ->route('siswa.index')
            ->with(
                'success',
                'Data siswa berhasil diperbarui.'
            );
    }

    /**
     * Menghapus data siswa.
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with(
                'success',
                'Data siswa berhasil dihapus.'
            );
    }
}