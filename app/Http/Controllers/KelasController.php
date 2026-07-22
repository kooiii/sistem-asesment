<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $data = Kelas::all();
        return view('admin.kelas.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas
        ]);

        return redirect()->route('kelas.index')->with('success','Data kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Kelas::findOrFail($id);

        return view('admin.kelas.edit', compact('data'));
    }

    public function update(Request $request,$id)
    {
        $request->validate(['nama_kelas'=>'required']);
        $kelas = Kelas::findOrFail($id);
        $kelas->update(['nama_kelas'=>$request->nama_kelas]);

        return redirect()->route('kelas.index')->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();

        return redirect()->route('kelas.index')->with('success','Data berhasil dihapus');
    }
}