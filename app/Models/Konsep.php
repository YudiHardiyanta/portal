<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsep extends Model
{
    use HasFactory;

    protected $table = 'konsep';
    protected $primaryKey = 'id_konsep';

    protected $fillable = [
        'kode_konsep',
        'konsep',
        'definisi',
        'id_standar',
    ];

    public function standarData()
    {
        return $this->belongsTo(StandarData::class, 'id_standar', 'id_standar');
    }
}
