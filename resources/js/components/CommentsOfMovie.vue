<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <button
                    type="button"
                    class="btn btn-light"
                    @click="showCommentArea()"
                >
                    Add comment &rarr;
                </button>
            </div>
            <div class="col-md-8" v-show="showTextarea == true">
                <form>
                    <div class="form-group">
                        <textarea
                            style="min-width: 100%"
                            rows="4"
                            v-model="movieComment"
                        ></textarea>
                    </div>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="addNewComment()"
                    >
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["comments_of_movie", "movie_id", "user_id"],
    data() {
        return {
            showTextarea: false,
            movieComment: ""
        };
    },
    methods: {
        showCommentArea: function() {
            this.showTextarea = true;
        },
        addNewComment: function() {
            axios
                .post("/api/add-comment", {
                    params: {
                        movieComment: this.movieComment,
                        movie_id: this.movie_id,
                        user_id: this.user_id
                    }
                })
                .then(response => {
                    this.$parent.commentsOfMovie = response.data;
                    this.showTextarea = false;
                    this.movieComment = "";
                });
        }
    },
    mounted() {}
};
</script>

<style scoped></style>
