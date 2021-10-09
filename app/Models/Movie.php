<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'category_id',
        'img',
        'realise_date',
        'rated_value',
        'country',
        'description',
        'created_at',
        'updated_at'
    ];

}