<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'aktif'
    ];

    public function tujuanPembelajarans()
    {
        return $this->hasMany(TujuanPembelajaran::class);
    }

    public function nilaiFormatifs()
    {
        return $this->hasMany(NilaiFormatif::class);
    }

    public function nilaiSumatifs()
    {
        return $this->hasMany(NilaiSumatif::class);
    }

    public function sikapPresensis()
    {
        return $this->hasMany(SikapPresensi::class);
    }
}