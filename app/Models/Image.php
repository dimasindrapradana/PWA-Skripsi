<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected static function booted()
    {
        static::deleting(function ($image) {

        });
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected $guarded =[];
}
