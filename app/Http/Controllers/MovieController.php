<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actor;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Director;
use App\Models\Movie;
use App\Models\MovieDirector;
use App\Models\MoviesActor;
use App\Models\User;




class MovieController extends Controller
{
    public function show(){

       $arrayMovieAll['basicMovieInformation'] =Movie::selectRaw('YEAR(realise_date) as dateOfRealiseMovie, movies.id,movies.name,movies.img')
       ->get();

       $arrayMovieAll['user']= Auth::user();

       $arrayMovieAll['categoryOfMovie']=Category::get();

       $arrayMovieAll['actors']=Actor::get();

       $arrayMovieAll['directors']=Director::get();
    
        return view ('movie/movie')->with($arrayMovieAll);
    }

    public function showOneMovieData($id){
 
       
        $arrayOneMovieShow['movieDetail']=Movie::leftJoin('categories', 'categories.id', '=', 'movies.category_id')
            ->selectRaw( 'YEAR(realise_date) as dateOfRealiseMovie, movies.id,movies.name,movies.category_id,movies.img,                       
                    movies.realise_date,movies.rated_value, movies.country,movies.description,categories.name as category_name')
            ->where('movies.id',$id)        
            ->first();
       
        $arrayOneMovieShow['categoryOfMovie']=Category::get();
        
        $arrayOneMovieShow['actorDetail']=Actor::leftJoin('movies_actors','actors.id', '=','movies_actors.actor_id')  
            ->select('movies_actors.id as id','actors.id as actor_id','actors.name') 
            ->where('movies_actors.movie_id',$id)
            ->get();
        
        $arrayOneMovieShow['directorsDetail']=Director::leftJoin('movie_directors','directors.id','=','movie_directors.director_id')
            ->select('movie_directors.id as id','directors.id as director_id','directors.name')
            ->where('movie_directors.movie_id',$id)
            ->get();

        $arrayOneMovieShow['actors']=Actor::get();

        $arrayOneMovieShow['directors']=Director::get();    

        return view('movie/movieShow')->with($arrayOneMovieShow);
    }

    public function add_new_movie (Request $request ){
        //  dd($request);

        $movieActors=$request->get('movieActors');
        $movieDirectors=$request->get('movieDirectors');
        // dd($movieDirectors);
           
        $vallidation=$request->validate([
            'name'=>'required',
            'category_id'=>'required',
            'img'=>'required|mimes:jpg,png,jpeg|max:5048',
            'realise_date'=>'required',
            'rated_value'=>'required|numeric|min:1|max:5',
            'country'=>'required',
            'description'=>'required'
        ]);

        $nameOfImage=$request->img->getClientOriginalName();
        $newimageName= time() . '-' . $nameOfImage;

        $request->img->move(public_path('categoryImages'), $newimageName);
        
        $newMovie= new Movie();
        $newMovie->fill($vallidation);
        $newMovie->img=$newimageName;
        $newMovie->save();

        foreach($movieActors as $oneActor){
            $newMovieActor= new MoviesActor();
            $newMovieActor->movie_id=$newMovie->id;
            $newMovieActor->actor_id=$oneActor['actor_id'];      
            $newMovieActor->save();
        }
        
        foreach($movieDirectors as $oneDirector){
            $newMovieDirector= new MovieDirector();
            $newMovieDirector->movie_id=$newMovie->id;
            $newMovieDirector->director_id=$oneDirector['director_id'];
            $newMovieDirector->save();
        } 
            
        return redirect('/home');
    }

    public function edit_movie( Request $request){
        // dd($request);
        $editMovieActors=$request->get('movieActors');
        $editMovieDirectors=$request->get('movieDirectors');
         
        $validation=$request->validate([
            'name'=>'required',
            'category_id'=>'required',
            'img'=>'nullable',
            'realise_date'=>'required',
            'rated_value'=>'required|numeric|min:1|max:5',
            'country'=>'required',
            'description'=>'required'
        ]);
        
        $idOfRequest=$request->id;
        $editMovie=Movie::find($idOfRequest);
        $editMovie->fill($validation);
        $editMovie->save();

        // edit or delete actors
        $movieActorsIds=[];

        foreach($editMovieActors as $editOneActor){

            $allActors=MoviesActor::updateOrCreate(
            ['id'=>$editOneActor['movie_actor_id']],          
            ['actor_id'=>$editOneActor['actor_id'], 
             'movie_id'=>$editMovie->id]); 

            $movieActorsIds[]=$allActors->id;         
        }
        MoviesActor::where('movie_id',$editMovie->id)->whereNotIn('id',$movieActorsIds)->delete();
        //    edit or delete directors
        $movieDirectorsIds=[];   
           
        foreach($editMovieDirectors as $editOneDiector){

            $allDirectors=MovieDirector::updateOrCreate(
                ['id'=>$editOneDiector['movie_directors_id']],
                ['director_id'=>$editOneDiector['director_id'],
                 'movie_id'=>$editMovie->id]);
                 
            $movieDirectorsIds[]=$allDirectors->id;     
            
        }
        MovieDirector::where('movie_id',$editMovie->id)->whereNotIn('id',$movieDirectorsIds)->delete();

       
        return redirect()->back( );
    }

}