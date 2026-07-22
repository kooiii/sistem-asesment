<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruKelas;
use App\Models\GuruMapel;
use Illuminate\Http\Request;

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
        Guru::create([
            'nama'=>$request->nama,
            'nip'=>$request->nip,
            'password'=>bcrypt($request->password),
            'role'=>'guru'
        ]);

        return redirect()->route('guru.index')
        ->with('success','Guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);

        return view('guru_admin.edit', compact('guru'));
    }

    public function update(Request $request,$id)
    {
        $guru = Guru::findOrFail($id);

        $guru->nama = $request->nama;
        $guru->nip = $request->nip;

        if($request->password!="")
        {
            $guru->password = bcrypt($request->password);
        }

        $guru->save();

        return redirect()->route('guru.index')
        ->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Guru::destroy($id);

        return redirect()->route('guru.index')
        ->with('success','Data berhasil dihapus');
    }

    public function penugasan($id)
    {
        $guru = Guru::with(['kelas','mapel'])->findOrFail($id);
        $kelas = Kelas::all();
        $mapel = Mapel::all();

        return view('guru_admin.penugasan', compact('guru','kelas','mapel'));
    }

    public function simpanPenugasan(Request $request,$id)
    {
        $guru = Guru::findOrFail($id);
        $guru->kelas()->sync($request->kelas ?? []);
        $guru->mapel()->sync($request->mapel ?? []);

        return redirect()->route('guru.index')->with('success','Penugasan guru berhasil disimpan');
    }
}