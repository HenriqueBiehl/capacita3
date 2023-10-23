<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Director;

class Movie extends Model
{
    protected $with = ['director'];

    protected $fillable = [
        'title',
        'movie_poster',
        'year',
        'producer',
        'run_time',
        'director_id'
    ];

   public function director(){
        return $this->belongsTo(Director::Class);
   }

   public function actors(){
        return $this->hasMany(Actor::Class);
   }
}
