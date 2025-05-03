<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected static function booted()
    {
        static::deleting(function ($question) {
            $question->options()->delete();
            $question->images()->delete();
            $question->videos()->delete();
        });
    }
        public function options()
        {
            return $this->hasMany(Option::class);
        }
        public function test()
        {
            return $this->belongsTo(Test::class);
        }

        public function images()
        {
            return $this->morphMany(Image::class, 'imageable');
        }
    
        public function videos()
        {
            return $this->morphMany(Video::class, 'videoable');
        }
    protected $guarded =[];
}
