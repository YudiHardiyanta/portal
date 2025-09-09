<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subkategori extends Model
{
    protected $table = 'subkategori';
    protected $fillable = ['name', 'id'];

    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'subcsa_id');
    }
}
