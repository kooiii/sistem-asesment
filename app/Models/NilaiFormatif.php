<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiFormatif extends Model
{
    protected $fillable = [
        'siswa_id',
        'tp_id',
        'tahun_ajaran_id',
        'teknik',
        'nilai'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Siswa
    |--------------------------------------------------------------------------
    */

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Tujuan Pembelajaran
    |--------------------------------------------------------------------------
    */

    public function tp()
    {
        return $this->belongsTo(
            TujuanPembelajaran::class,
            'tp_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Tahun Ajaran
    |--------------------------------------------------------------------------
    */

    public function tahunAjaran()
    {
        return $this->belongsTo(
            TahunAjaran::class,
            'tahun_ajaran_id'
        );
    }
}