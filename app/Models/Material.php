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
        return $this->morphMany(Video::class, 'videoable');
    }
    public function show($slug)
    {
        $material = Material::with(['category.materials'])->where('slug', $slug)->firstOrFail();

        $materials = $material->category->materials;

        $currentIndex = $materials->search(function ($m) use ($material) {
            return $m->id === $material->id;
        });

        $previous = $materials[$currentIndex - 1] ?? null;
        $next = $materials[$currentIndex + 1] ?? null;

        return view('materi.show', compact('material', 'materials', 'previous', 'next'));
    }
    protected $guarded=[];
}
