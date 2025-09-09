<?php

namespace App\Models;

use App\Models\Indicator;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['name', 'id'];

    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'sub_id');
    }
}
