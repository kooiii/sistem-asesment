<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $data = Guru::all();

        return view('guru_admin.index', compact('data'));
    }

    public function create()
    {
        return view('guru_admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:30|unique:gurus,nip',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:gurus,email',
            'password' => 'required|string|min:6',
        ], [
            'nama.required' => 'Nama Guru wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP tersebut sudah terdaftar. Gunakan NIP lain.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan Guru lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'guru',
        ]);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);

        return view('guru_admin.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => [
                'required',
                'string',
                'max:30',
                Rule::unique('gurus', 'nip')->ignore($guru->id),
            ],
            'telepon' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('gurus', 'email')->ignore($guru->id),
            ],
            'password' => 'nullable|string|min:6',
        ], [
            'nama.required' => 'Nama Guru wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP tersebut sudah digunakan Guru lain.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan Guru lain.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $guru->nama = $request->nama;
        $guru->nip = $request->nip;
        $guru->telepon = $request->telepon;
        $guru->email = $request->email;

        if ($request->filled('password')) {
            $guru->password = bcrypt($request->password);
        }

        $guru->save();

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Guru::destroy($id);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data Guru berhasil dihapus.');
    }

    public function penugasan($id)
    {
        $guru = Guru::with(['kelas', 'mapel'])->findOrFail($id);
        $kelas = Kelas::all();
        $mapel = Mapel::all();

        return view(
            'guru_admin.penugasan',
            compact('guru', 'kelas', 'mapel')
        );
    }

    public function simpanPenugasan(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $guru->kelas()->sync($request->kelas ?? []);
        $guru->mapel()->sync($request->mapel ?? []);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Penugasan Guru berhasil disimpan.');
    }
}
