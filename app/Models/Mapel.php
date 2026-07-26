<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = ['nama_mapel'];

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function guru()
    {
        return $this->belongsToMany(Guru::class,'guru_mapels');
    }

    public function tujuanPembelajarans()
    {
        return $this->hasMany(TujuanPembelajaran::class);
    }

    public function nilaiSumatifs()
    {
        return $this->hasMany(NilaiSumatif::class);
    }
    use HasFactory;
}
