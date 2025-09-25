<?php

namespace App\Models;

use App\Models\IndicatorLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Indicator extends Model
{
    use Sluggable;
    protected $primaryKey = 'var_id';
    protected $fillable = [
        'var_id',
        'slug',
        'title',
        'sub_id',
        'subcsa_id',
        'def',
        'notes',
        'unit',
        'total_views',
        'id_dashboard',
        'id_indikator'
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

    public function standarData()
    {
        return $this->belongsTo(StandarData::class, 'id_standar','id_standar');
    }

    public function metadataIndikator()
    {
        return $this->belongsTo(MetadataIndikator::class,'id_indikator','id_indikator');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function metadataKegiatan()
    {
        return $this->hasMany(MetadataKegiatan::class, 'id_indikator', 'var_id');
    }
}