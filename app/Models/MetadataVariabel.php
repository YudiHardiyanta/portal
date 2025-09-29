<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetadataVariabel extends Model
{
    protected $table = 'metadata_variabel';
    protected $primaryKey = 'id_variabel';
    public $incrementing = true;

    protected $fillable = [
        'id_variabel',
        'nama_variabel',
        'alias',
        'konsep',
        'definisi',
        'referensi_pemilihan',
        'referensi_waktu',
        'ukuran',
        'satuan',
        'tipe_data',
        'klasifikasi_isian',
        'aturan_validasi',
        'kalimat_pertanyaan',
        'is_publik',
    ];
    protected $casts = [
        'klasifikasi_isian' => 'array',
        'alias' => 'array',
        'is_publik' => 'boolean',
    ];

    public function indikator()
    {
        return $this->belongsToMany(MetadataIndikator::class, 'metadata_indikator_variabel', 'id_variabel', 'id_indikator')->withTimestamps();
    }
}
