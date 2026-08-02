<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardGuruController extends Controller
{
    public function ubahContext(Request $request)
    {
        session([

            'kelas_aktif'=>$request->kelas_id,

            'mapel_aktif'=>$request->mapel_id

        ]);

        return back();
    }
}