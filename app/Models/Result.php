<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class Result extends Model
{
     protected static function booted()
    {
    static::creating(function ($result) {
        $result->slug = (string) \Illuminate\Support\Str::uuid();
    });
    }


    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $guarded =[];
}
