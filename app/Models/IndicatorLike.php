<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorLike extends Model
{
    protected $fillable = [
        'indicator_id',
        'user_id',
    ];

     public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id', 'var_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
