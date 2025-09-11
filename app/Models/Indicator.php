<?php

namespace App\Models;

use App\Models\IndicatorLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $primaryKey = 'var_id';
    protected $fillable = [
       'var_id','title', 'sub_id', 'subcsa_id', 'def', 'notes', 'unit','total_views','id_dashboard'
    ];

    protected $appends = ['is_liked', 'likes_count'];


    public function likes()
    {
        return $this->hasMany(IndicatorLike::class, 'indicator_id', 'var_id');
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

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'sub_id');
    }

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class, 'subcsa_id');
    }
}