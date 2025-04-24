<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    protected $guarded=[];
}
