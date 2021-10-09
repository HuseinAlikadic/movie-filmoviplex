<template>
    <div class="form-group">
        <button
            type="button"
            class="btn btn-secondary"
            @click="addMovieDirectors()"
        >
            Add directors
        </button>
        <br />
        <br />
        <div
            v-for="(item, index) in movie_directors"
            :key="'movieDirectors' + index"
        >
            <div class="input-group mb-3">
                <input
                    type="hidden"
                    :name="'movieDirectors[' + index + '][movie_directors_id]'"
                    :value="item.id"
                />
                <select
                    class="form-control"
                    :name="'movieDirectors[' + index + '][director_id]'"
                    required
                    v-model="item.director_id"
                >
                    <option value="">Select</option>
                    <option
                        :value="director.id"
                        v-for="(director, index) in directors"
                        :key="'director' + index"
                        >{{ director.name }}</option
                    >
                </select>
                <div class="input-group-append">
                    <button
                        class="btn btn-success "
                        type="button"
                        @click="removeDirector(index)"
                    >
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ReapiterMovieDirectors",
    props: ["movie_directors", "directors"],
    data() {
        return {};
    },
    methods: {
        addMovieDirectors: function() {
            this.movie_directors.push({ director_id: "" });
        },

        removeDirector: function(index) {
            this.movie_directors.splice(index, 1);
        }
    }
};
</script>

<style></style>
