<?php

namespace App\Models;

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
public function nilai()
{
    return $this->hasMany(Nilai::class);
}
}
