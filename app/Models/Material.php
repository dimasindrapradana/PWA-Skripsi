<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
{


       protected static function boot()
    {
        parent::boot();

        static::creating(function ($material) {
            $material->slug = Str::slug($material->title);
        });
    }

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
        return $this->hasMany(Video::class); 
    }

    public function users()
    {
    return $this->belongsToMany(User::class)
        ->withPivot(['has_read', 'submitted_task', 'completed_quiz'])
        ->withTimestamps();
    }

    public function submissions()
    {
    return $this->hasMany(\App\Models\Submission::class);
    }

    protected $guarded=[];
}
