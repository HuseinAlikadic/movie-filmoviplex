<template>
    <div class="form-group">
        <button
            type="button"
            class="btn btn-secondary"
            @click="addMovieActors()"
        >
            Add actor
        </button>
        <br />
        <br />
        <div v-for="(element, index) in movie_actors" :key="'actor' + index">
            <div class="input-group mb-3 ">
                <input
                    type="hidden"
                    :name="'movieActors[' + index + '][movie_actor_id]'"
                    :value="element.id"
                />
                <select
                    class="form-control"
                    :name="'movieActors[' + index + '][actor_id]'"
                    required
                    v-model="element.actor_id"
                >
                    <option value="">Select</option>
                    <option
                        :value="item.id"
                        v-for="(item, index) in actors"
                        :key="'oneActor' + index"
                        >{{ item.name }}</option
                    >
                </select>
                <div class="input-group-append">
                    <button
                        class="btn btn-success "
                        type="button"
                        @click="removeActor(index)"
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
    name: "ReapiterForActors",

    props: ["movie_actors", "actors"],
    data() {
        return {};
    },
    methods: {
        addMovieActors: function() {
            this.movie_actors.push({ actor_id: "" });
        },

        removeActor: function(index) {
            this.movie_actors.splice(index, 1);
        }
    }
};
</script>

<style></style>
