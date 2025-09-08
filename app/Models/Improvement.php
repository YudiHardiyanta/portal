<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Improvement extends Model
{
  protected $table = 'improvements';
  protected $fillable = ['name'];
  public function feedbacks()
  {
    return $this->belongsToMany(Feedback::class, 'feedback_improvement');
  }
}
