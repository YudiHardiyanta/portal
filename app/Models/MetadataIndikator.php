<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetadataIndikator extends Model
{
    protected $table = 'metadata_indikator';
    protected $primaryKey = 'id_indikator';

    protected $fillable = [
        'nama_indikator',
        'konsep',
        'definisi',
        'interpretasi',
        'metode_perhitungan',
        'rumus',
        'ukuran',
        'satuan',
        'variabel_disagregasi',
        'indikator_komposit',
        'indikator_pembangunan',
        'id_variabel_pembangun',   // ganti dari variabel_pembangun
        'level_estimasi',
        'publik',
    ];

    protected $casts = [
        'variabel_disagregasi'   => 'array',
        'indikator_pembangunan'  => 'array',
        'id_variabel_pembangun'  => 'array', 
        'level_estimasi'         => 'array',
        'indikator_komposit'     => 'boolean',
        'publik'                 => 'boolean',
    ];

    public function variabel()
    {
        return $this->belongsToMany(
            MetadataVariabel::class,
            'metadata_indikator_variabel',
            'id_indikator',
            'id_variabel'
        )->withTimestamps();
    }

    public function indikator()
    {
        return $this->hasOne(
            Indicator::class,
            'id_indikator',
            'id_indikator'
        );
    }
}

