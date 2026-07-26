<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SikapPresensi extends Model
{
    protected $fillable = [
        'siswa_id',
        'tahun_ajaran_id',
        'sikap',
        'presensi'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}