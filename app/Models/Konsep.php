<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsep extends Model
{
    protected $table = 'konsep';
    protected $primaryKey = 'id_konsep';

    protected $fillable = [
        'kode_konsep',
        'konsep',
        'definisi',
    ];

    public function standarData()
    {
        return $this->belongsToMany(StandarData::class, 'standar_data_konsep', 'id_konsep', 'id_standar')->withTimestamps();
    }
}
