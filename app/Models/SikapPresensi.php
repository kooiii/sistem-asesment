<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SikapPresensi extends Model
{
    protected $table = 'sikap_presensis';

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
        return $this->belongsTo(
            TahunAjaran::class,
            'tahun_ajaran_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Predikat Sikap
    |--------------------------------------------------------------------------
    */

    public function getPredikatAttribute()
    {
        if($this->sikap >= 90) return 'SB';

        if($this->sikap >= 80) return 'B';

        if($this->sikap >= 70) return 'C';

        return 'K';
    }

    /*
    |--------------------------------------------------------------------------
    | Persentase Kehadiran
    |--------------------------------------------------------------------------
    */

    public function getPersenPresensiAttribute()
    {
        return number_format($this->presensi,2);
    }
}