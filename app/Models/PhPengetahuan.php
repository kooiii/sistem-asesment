<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhPengetahuan extends Model
{
    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'tp1',
        'tp2',
        'tp3',
        'tp4',
        'tp5',
        'tp6',
        'tp7',
        'tp8',
        'tp9',
        'tp10',
        'tp11',
        'tp12',

        'r2',
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
    use HasFactory;
}
