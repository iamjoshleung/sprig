/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("../bootstrap");
window.Vue = require("vue");

Vue.component("app-files", require("./pages/Files.vue"));
Vue.component("app-sites", require("./pages/Sites.vue"));
Vue.component("app-movies", require("./pages/Movies.vue"));
Vue.component("app-movies-edit", require("./pages/MoviesEdit.vue"));
Vue.component("flash", require("vue-flash"));

window.events = new Vue();

/**
 * Our Flash function which will be used to add new flash events to our event handler
 *
 * @param  String message Our alert message
 * @param  String type    The type of alert we want to show
 */
window.flash = function(message, type) {
  window.events.$emit("flash", message, type);
};

const app = new Vue({
  el: "#app"
});
