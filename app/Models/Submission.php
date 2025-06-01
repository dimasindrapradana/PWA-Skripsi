<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}

public function material()
{
    return $this->belongsTo(Material::class);
}

protected $fillable = [
    'user_id',
    'material_id',
    'link',
    'description',
    'slug',
    'submitted_at',
];

}
