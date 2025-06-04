<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class Result extends Model
{
    protected $fillable = [
        'test_id',
        'user_id',
        'score',
        'slug',
        'submitted_at',
    ];
     protected static function booted()
{
    static::creating(function ($result) {
        $titleSlug = Str::slug($result->test->title);
        $userId = $result->user_id ?? Auth::id();
        $result->slug = "{$titleSlug}-{$userId}";
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
}
