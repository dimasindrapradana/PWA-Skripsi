<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    protected $guarded =[];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
    public function tests()
{
    return $this->hasManyThrough(
        \App\Models\Test::class,         // Model tujuan
        \App\Models\Material::class,     // Model perantara
        'category_id',                   // FK di Material
        'material_id',                   // FK di Test
        'id',                            // PK Category
        'id'                             // PK Material
    );
}
}

