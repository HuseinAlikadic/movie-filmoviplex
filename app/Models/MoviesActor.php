<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoviesActor extends Model
{
    use HasFactory;

    protected $fillable =[
        'movie_id',
        'actor_id'
    ];
}