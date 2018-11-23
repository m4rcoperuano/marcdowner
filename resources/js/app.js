
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VuePrism from 'vue-prism'
import Vuetify from 'vuetify'
import 'prismjs/themes/prism.css'
import VueTextareaAutosize from 'vue-textarea-autosize';

window.Vue = require('vue');

Vue.component('markdown-editor', require('./components/editor/index.vue'));
Vue.use(VuePrism);
Vue.use(Vuetify);
Vue.use(VueTextareaAutosize);

const app = new Vue({
    el: '#app'
});
