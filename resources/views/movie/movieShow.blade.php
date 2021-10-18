@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row"  >
    <div class="col-sm-4"  >
                <img   :src="'{{ URL::to('/') }}/categoryImages/' +movieDetail.img"  alt="Image"   height="100%" width="100%" />
    </div>
    <div class="col-sm-8">
      <h3>@{{ movieDetail.name }} (@{{ movieDetail.dateOfRealiseMovie }})
        <i class="fas fa-trash-alt float-right deleteMovieDetailIcon" data-toggle="modal" data-target="#confirmeDeleteMovie"></i>
        <i class="fas fa-edit float-right editMovieDetailIcon"   @click="editMovieDetail()"></i>
        </h3>
      <hr>
      <h4>@{{ movieDetail.description }}</h4>
      <br>
      <h5>@{{ movieDetail.category_name }}</h5>
      <br>
      <h5>  Year of film release: @{{ movieDetail.dateOfRealiseMovie}}, IMBD  <star-rating  :inline="true"  :read-only="true" :rating=" movieDetail.rated_value" :star-size="15" :show-rating="false" /> </h5>
        <h5>Actors: <span v-for="(actor,index) in actorDetail" :key="index">@{{ nameOfActors(index)}} </span> </h5>
        <h5>Directors: <span v-for="(director,index) in directorsDetail"> @{{nameOfDirectors(index)}}</span></h5>
      <h5>Country: @{{ movieDetail.country }}</h5>
    </div>

  </div>
  <br>
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-8">
      <div v-for="comment in commentsOfMovie">
        <div class="card card-white post">
          <div class="post-heading">
              <div class="float-left meta">
                  <div class="title h5">
                     <p> @{{comment.name  }}  @{{ comment.dateCreated }}</p>
                    {{-- <p>@{{ timeOfRealise(comment.dateCreated) }}</p> --}}
                  </div>

              </div>
          </div>
          <div class="post-description">
              <p>@{{ comment.comment_value }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <br>
      <comments-movie :comments_of_movie="commentsOfMovie" :movie_id="movieDetail.id" :user_id="userLog"></comments-movie>
    </div>
  </div>
   {{-- Delete movie --}}
   <div class="modal" id="confirmeDeleteMovie">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form action="/api/delete-movie" method="POST">
          @csrf
          <div class="modal-body">
            <button type="button" class="btn btn-success" style="min-width: 49%;" data-dismiss="modal">Close</button>
            <input type="hidden" v-model="movieDetail.id" name="idOfMovie">
            <button type="submit" class="btn btn-danger " style="min-width: 49%;" @click="deleteMovie()">Delete</button>
          </div>
        </form>
        <!-- Modal footer -->
        <div class="modal-footer">

        </div>

      </div>
    </div>
  </div>
   {{-- Edit movie detail --}}
  <div class="modal" id="editMovieDetailId">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="/api/edit-movie" method="POST" enctype="multipart/form-data">
          @csrf
          <!-- Modal body -->
          <div class="modal-body">
            <input type="hidden" class="form-control" v-model="movieDetail.id" name="id">
            <div class="form-group">
                <label for="usr">Title of movie:</label>
                <input type="text" class="form-control" v-model.lazy="movieDetail.name" name="name">
            </div>
            <div class="form-group">
              <label for="sel1">Select Category:</label>
              <select class="form-control" name="category_id" v-model="movieDetail.category_id " >
                  <option value="">Select</option>
                  <option :value="category.id"  v-for="category in categoryOfMovie">@{{category.name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="sel1">Choose image:</label>
              <br>
              <input type="file" name="img"  >
            </div>
            <div class="form-group">
              <label for="sel1">Choose date of realise movie:</label>
              <br>
              <input type="date" class="form-control" name="realise_date" v-model="movieDetail.realise_date" required >
            </div>
            <div class="form-group">
            <input type="number" class="form-control" name="rated_value" min="1" max="5" placeholder="Rate between 1 and 5"  v-model="movieDetail.rated_value"required>
            </div>
            <div class="form-group">
              <label for="usr">Country in which the film was released:</label>
              <input type="text" class="form-control" name="country" v-model="movieDetail.country" required >
            </div>
            <div class="form-group">
              <label for="usr"> Movie description:</label>
              <input type="text" class="form-control" name="description" v-model="movieDetail.description" required>
            </div>
              {{--repeater uraditi TODO --}}

              <reapiter-movie-actors :movie_actors="actorDetail" :actors="actors"></reapiter-movie-actors>

              <reapiter-movie-directors :movie_directors="directorsDetail" :directors="directors"></reapiter-movie-directors>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary"  >Save</button>
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
    name: 'MovieShowOne',
    data() {
        return {
            movieDetail:<?=$movieDetail?>,
            categoryOfMovie:<?=$categoryOfMovie?>,
            actorDetail:<?=$actorDetail?>,
            directorsDetail:<?=$directorsDetail?>,
            actors:<?=$actors?>,
            directors:<?=$directors?>,
            commentsOfMovie:<?=$commentsOfMovie?>,
            userLog:"<?=$userLog?>"

        }
    },
    methods: {
        editMovieDetail: function(){
          $('#editMovieDetailId').modal('toggle');
        },
        nameOfActors(index){
          if(index!==this.actorDetail.length-1){
            return `${this.actorDetail[index].name},`;
          }else{
            return `${ this.actorDetail[index].name}.`;
          }
       },
       nameOfDirectors(index){
        if(index!==this.directorsDetail.length-1){
            return `${this.directorsDetail[index].name},`;
          }else{
            return `${ this.directorsDetail[index].name}.`;
          }
       },
       deleteMovie:function(){
         $('#confirmeDeleteMovie').modal('hide');
        // console.log(this.movieDetail);
       },

    //    timeOfRealise:function(created_at){
    //     //    console.log(created_at);
    //    return created_at;
    //    }
    },

});

</script>
@endsection
