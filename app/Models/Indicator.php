<?php

namespace App\Models;

use App\Models\IndicatorLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'total_views',
    ];

    protected $appends = ['is_liked', 'likes_count'];

    public function likes()
    {
        return $this->hasMany(IndicatorLike::class);
    }

    public function getIsLikedAttribute()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
