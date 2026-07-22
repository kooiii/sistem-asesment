<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pts extends Model
{
    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'nm',
        'nr',
        'n'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}