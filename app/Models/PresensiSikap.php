<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiSikap extends Model
{
    protected $fillable = [
        'siswa_id',
        'presensi',
        'sikap',
        'nm',
        'n'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
