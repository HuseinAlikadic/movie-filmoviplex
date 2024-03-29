/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

import StarRating from "vue-star-rating";
window.Vue.component("star-rating", StarRating);

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "reapiter-movie-actors",
    require("./components/ReapiterMovieActors.vue").default
);
Vue.component(
    "reapiter-movie-directors",
    require("./components/ReapiterMovieDirectors.vue").default
);
Vue.component(
    "comments-movie",
    require("./components/CommentsOfMovie.vue").default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });
