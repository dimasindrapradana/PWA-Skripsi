<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke model Test (satu material dapat memiliki banyak kuis).
     */
    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }
    protected $guarded=[];
}
