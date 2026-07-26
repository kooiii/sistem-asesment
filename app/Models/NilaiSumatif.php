<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiSumatif extends Model
{
    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'tahun_ajaran_id',
        'jenis',
        'nilai'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}