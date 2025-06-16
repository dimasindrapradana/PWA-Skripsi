<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Test extends Model
{

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($test) {
            $test->slug = Str::slug($test->title);
        });
    }
    protected static function booted()
    {
        static::deleting(function ($test) {

             $test->results()->delete();
            // Hapus seluruh pertanyaan satu per satu untuk memicu event deleting pada model Question
            foreach ($test->questions as $question) {
                $question->delete();
            }

            // Jika test punya 1 gambar (bukan repeater), hapus juga
            if ($test->image) {
                $test->image->delete();
            }
        });
    }
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
    public function videos()
    {
         return $this->morphMany(Video::class, 'videoable');
    }
    public function results()
    {
    return $this->hasMany(Result::class);
    }
    protected $guarded=[];
}
