<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandarData extends Model
{
    protected $table = 'standar_data';
    protected $primaryKey = 'id_standar';

    protected $fillable = [
        'nama_data',
        'konsep_kode',
        'definisi',
        'klasifikasi_penyajian',
        'klasifikasi_isian',
        'is_klasifikasi',
        'ukuran',
        'satuan',
    ];

    protected $casts = [
        'konsep_kode' => 'array',
        'klasifikasi_penyajian' => 'array',
        'klasifikasi_isian' => 'array',
        'is_klasifikasi' => 'boolean',
    ];

    public function konsep()
    {
        return $this->belongsToMany(
            Konsep::class,
            'standar_data_konsep',
            'id_standar',          
            'id_konsep'            
        )->withTimestamps();
    }


    public function metadataKegiatan()
    {
        return $this->hasMany(
            MetadataKegiatan::class,
            'id_standar', 
            'id_standar'  
        );
    }

    public function indicator()
    {
        return $this->hasOne(
            Indicator::class,
            'id_standar', 
            'id_standar'   
        );
    }
}
