<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index()
    {
        $data = Siswa::with('kelas')
            ->orderBy('nama')
            ->get();

        return view('admin.siswa.index', compact('data'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:30|unique:siswas,nis',
            'nama' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS tersebut sudah terdaftar. Gunakan NIS lain.',
            'nama.required' => 'Nama siswa wajib diisi.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => [
                'required',
                'string',
                'max:30',
                Rule::unique('siswas', 'nis')->ignore($siswa->id),
            ],
            'nama' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS tersebut sudah digunakan siswa lain.',
            'nama.required' => 'Nama siswa wajib diisi.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
