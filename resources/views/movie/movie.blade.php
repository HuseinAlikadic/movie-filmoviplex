@extends('layouts.app')

@section('content')
<div class="container-fluid">
   
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search movie by name"  v-model="searchMovie">
        <div class="input-group-append">
        <button class="btn btn-secondary" type="button" @click="search_movie()">
            <i class="fa fa-search"></i>
        </button>
        </div>
    </div>
    <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewMovie">
        Add movie
    </button>
    <br>
    <br>
    <div class="row">
        <div class="column"v-for="movie in basicMovieInformation">
          <div class="card h-100">              
            <img   :src="'{{ URL::to('/') }}/categoryImages/' +movie.img"  alt="Image"   height="100%" width="100%" />
          </div>
        
          <a :href="path"  @click="showMowieDetails(movie.id)" >   <h3>@{{ movie.name }} (@{{ movie.dateOfRealiseMovie }}) </h3>  </a>
        
        </div>
    </div> 
    {{-- Add movie --}}
    <div class="modal" id="addNewMovie">
        <div class="modal-dialog">
            <div class="modal-content">  
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add movie</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="/api/add-movie" method="POST" enctype="multipart/form-data" >
                    @csrf     
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="usr">Title of movie:</label>
                            <input type="text" class="form-control" name="name"  required>
                        </div>
                        <div class="form-group">
                            <label for="sel1">Select Category:</label>
                            <select class="form-control" name="category_id" required >
                                <option value="">Select</option>
                                <option :value="category.id" v-for="category in categoryOfMovie">@{{category.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sel1">Choose image:</label>
                            <br>
                            <input type="file" name="img" required >
                        </div>
                        <div class="form-group">
                            <label for="sel1">Choose date of realise movie:</label>
                            <br>                      
                            <input type="date" class="form-control" name="realise_date" required >
                        </div>
                        <div class="form-group">   
                            <input type="number" class="form-control" name="rated_value" min="1" max="5" placeholder="Rate between 1 and 5" required>
                        </div>
                        <div class="form-group">
                            <label for="usr">Country in which the film was released:</label>
                            <input type="text" class="form-control" name="country" required >
                        </div>
                        <div class="form-group">
                            <label for="usr"> Movie description:</label>
                            <input type="text" class="form-control" name="description"  required>
                        </div>                                                              
                        
                        <reapiter-movie-actors :movie_actors="movie_actors" :actors="actors"></reapiter-movie-actors>
                       
                        <reapiter-movie-directors :movie_directors="movie_directors" :directors="directors"></reapiter-movie-directors> 

                    </div>                   
                    <!-- Modal footer -->
                    <div class="modal-footer">             
                    <button type="submit" class="btn btn-primary">Add Movie</button>   
                    
                    </div>

                </form> 
            </div>
        </div> 
    </div>               
   
</div>
@endsection
 
@section('vue-section')
<script>  
const app = new Vue({
    el: '#app',
    name: 'Movie',
     
    data() {
        return {          
            basicMovieInformation: <?=$basicMovieInformation?>,
            user:'<?=$user?>' ,
            path:'/',
            categoryOfMovie: <?=$categoryOfMovie?>,
            actors:<?=$actors?>,
            directors:<?=$directors?>,
            movie_actors:[],
            movie_directors:[],
            searchMovie:"",                              
        }
    },
    methods: {
        showMowieDetails: function(id){            
            let self=this;
            // console.log(this.user);
            if(this.user==""){
                self.path="/register"             
            }else{
                this.path="/movie/"+id
            }
            // console.log(this.path);
        },    
        search_movie:function(){
           axios.post('/api/search',{
               params:{
                searchMovie:this.searchMovie,             
               }
           })
          .then(response=>{
              this.basicMovieInformation=response.data   
            //   console.log(response.data);        
          })        
           
        }
    },
   
   

});

</script>
@endsection

