<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $fillable = [
        'satisfaction',
        'job',
        'improvements',
        'message',
    ];
    protected $casts = [
        'improvements' => 'array', 
    ];
    public function improvements()
    {
        return $this->belongsToMany(Improvement::class, 'feedback_improvement');
    }
}
