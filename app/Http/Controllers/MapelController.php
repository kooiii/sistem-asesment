<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $data = Mapel::all();
        return view('admin.mapel.index', compact('data'));
    }

    public function create()
    {
        return view('admin.mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required'
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel
        ]);

        return redirect()->route('mapel.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Mapel::findOrFail($id);

        return view('admin.mapel.edit', compact('data'));
    }

    public function update(Request $request,$id)
    {
        $request->validate(['nama_mapel'=>'required']);
        $mapel = Mapel::findOrFail($id);
        $mapel->update(['nama_mapel'=>$request->nama_mapel]);

        return redirect()->route('mapel.index')->with('success','Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Mapel::findOrFail($id)->delete();

        return redirect()->route('mapel.index')->with('success','Data berhasil dihapus');
    }
}