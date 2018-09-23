
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('babel-polyfill');
require('promise.prototype.finally');
require('./bootstrap');
window.Vue = require('vue');
import './pages/movies';
import './pages/moviesShow';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('app-header', require('./components/AppHeader.vue'));
Vue.component('file-upload-modal', require('./components/FileUploadModal.vue'));
Vue.component('download-steps', require('./components/DownloadSteps.vue'));
Vue.component('form-feedback', require('./components/forms/Feedback.vue'));
Vue.component('photosets', require('./components/Photosets.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('page-videos', require('./pages/Videos.vue'));

Vue.prototype.isMobile = () => {
    return window.innerWidth < 768;
}

import authorizations from './authorizations';

Vue.prototype.authorize = (...params) => {
    if( !window.App.signedIn ) return false;
    // console.log(authorizations['isAdmin'])
    return authorizations[params[0]]();
};

Vue.prototype.isMobile = _ => {
    return window.innerWidth < 768;
}

export const eventBus = new Vue();

const app = new Vue({
    el: '#app'
});

window.getResponseCode = (token) => {
    eventBus.$emit('receivedResCode', token);
};

window.flash = (msg) => {
    eventBus.$emit('flash', msg);
}

const navMobilePanel = document.querySelector('.js-nav-mobile');

document.querySelector('.js-icon-burger').onclick = function() {    
    this.classList.toggle('active');
    navMobilePanel.classList.toggle('active');
}