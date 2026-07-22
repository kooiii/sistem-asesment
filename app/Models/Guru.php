<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'nama',
        'nip',
        'password',
        'role'
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class,'guru_kelas','guru_id','kelas_id');
    }

    public function mapel()
    {
        return $this->belongsToMany(Mapel::class,'guru_mapels','guru_id','mapel_id');
    }
}
