
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('app-header', require('./components/AppHeader.vue'));
Vue.component('file-upload-modal', require('./components/FileUploadModal.vue'));
Vue.component('download-steps', require('./components/DownloadSteps.vue'));
Vue.component('form-feedback', require('./components/forms/Feedback.vue'));

export const eventBus = new Vue();

const app = new Vue({
    el: '#app'
});

window.getResponseCode = (token) => {
    eventBus.$emit('receivedResCode', token);
};

const navMobilePanel = document.querySelector('.js-nav-mobile');

document.querySelector('.js-icon-burger').onclick = function() {    
    this.classList.toggle('active');
    navMobilePanel.classList.toggle('active');
}