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

    public function imageable()
    {
        return $this->morphTo(); 
    }

    protected $guarded =[];
}
