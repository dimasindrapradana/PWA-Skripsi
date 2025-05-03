<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected static function booted()
    {
        static::deleting(function ($video) {

        });
    }
    public function videoable()
    {
        return $this->morphTo();
    }

    protected $guarded=[];
}
