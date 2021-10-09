<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actor;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Director;
use App\Models\Movie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\MovieDirector;
use App\Models\MoviesActor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::insert([
            ['name'=>'Husein',
            'email'=>'husikaa_988@hotmail.com',
            
            'password'=>Hash::make(12345678)
             ],
            ['name'=>'Emina',
            
            'email'=>'emina_988@hotmail.com',
            
            'password'=>Hash::make(12345678)
            ]
        ]);

        Category::insert([
            ['name' => 'Akcija'],
            ['name' => 'Dokumentarni']
        ]);

        Actor::insert([
            ['name' => 'Husein Alikadić'],
            ['name' => 'Emina Alikadić']
        ]);

        Director::insert([
            ['name' => 'Kazafer Alikadić'],
            ['name' => 'Fadila Alikadić']
        ]);

        Movie::insert([
            ['name' => 'Potraga za blagom',
              'category_id'=>1,
              'img'=>'img',          
              'realise_date'=>Carbon::now(),
               'rated_value'=>3,
                'country'=>'BiH',
                'description'=>'Opis najzanimljivijih detalja vezanih za film'
            ],
            ['name' => 'Potraga za srecom',
            'category_id'=>1,
            'img'=>'img',          
            'realise_date'=>Carbon::now(),
             'rated_value'=>3,
              'country'=>'BiH',
              'description'=>'Opis najzanimljivijih detalja vezanih za film'
            ], 
            ['name' => 'Sretni život',
            'category_id'=>1,
            'img'=>'img',          
            'realise_date'=>Carbon::now(),
             'rated_value'=>3,
              'country'=>'BiH',
              'description'=>'Opis najzanimljivijih detalja vezanih za film'
            ],
            ['name' => 'Potraga',
            'category_id'=>1,
            'img'=>'img',          
            'realise_date'=>Carbon::now(),
             'rated_value'=>3,
              'country'=>'BiH',
              'description'=>'Opis najzanimljivijih detalja vezanih za film'
            ]     
        ]);
        Comment::insert([
            ['user_id' => 2,
              'movie_id'=>1,
              'comment_value'=>'Saržaj komantara ide ovdje'           
            ]         
        ]);

        MovieDirector::insert([
            ['movie_id' => 1,
              'director_id'=>1                      
            ]         
        ]);

        MoviesActor::insert([
            ['movie_id' => 1,
              'actor_id'=>1                      
            ]         
        ]);
    }
}