<?php

namespace App\Models;


use App\Models\NilaiSumatif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use Hasfactory;
    protected $fillable = ['nis','nama','kelas_id'];    
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
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

    public function nilaiSumatif()
    {
        return $this->hasMany(NilaiSumatif::class);
    }
}
