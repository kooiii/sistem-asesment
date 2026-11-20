<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'telepon',
        'email',
        'password',
        'role',
    ];

    public function kelas()
    {
        return $this->belongsToMany(
            Kelas::class,
            'guru_kelas',
            'guru_id',
            'kelas_id'
        );
    }

    public function mapel()
    {
        return $this->belongsToMany(
            Mapel::class,
            'guru_mapels',
            'guru_id',
            'mapel_id'
        );
    }

    public function tujuanPembelajarans()
    {
        return $this->hasMany(TujuanPembelajaran::class);
    }

    public function context()
    {
        return $this->hasOne(ContextGuru::class);
    }
}
