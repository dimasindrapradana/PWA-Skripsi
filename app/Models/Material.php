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
    protected $guarded=[];
}
