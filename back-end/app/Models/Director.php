<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = [
        'name',
        'biography',
        'age',
        'nacionality'
    ];

    public function movies(){
        return $this->hasMany(Movie::class);
    }
}
