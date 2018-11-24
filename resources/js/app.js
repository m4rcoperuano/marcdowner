
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VuePrism from 'vue-prism'
import 'prismjs/themes/prism.css'
import VueTextareaAutosize from 'vue-textarea-autosize';
import VueShortkey from 'vue-shortkey';
import VueClipboard from 'vue-clipboard2'

window.Vue = require('vue');
Vue.use(VuePrism);
Vue.use(VueTextareaAutosize);
Vue.use(VueShortkey);
Vue.use(VueClipboard);

Vue.component('markdown-editor', require('./components/editor/index.vue'));

const app = new Vue({
    el: '#app'
});
