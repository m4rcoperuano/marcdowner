
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require( './bootstrap' );
import VuePrism from 'vue-prism';
import 'prismjs/themes/prism.css';
import VueShortkey from 'vue-shortkey';
import VueClipboard from 'vue-clipboard2';

let Vue = require( 'vue' );
window.Vue = Vue;

Vue.use( VuePrism );
Vue.use( VueShortkey );
Vue.use( VueClipboard );

Vue.component( 'markdown-editor', require( './components/editor/editor' ) );
Vue.component( 'markdown-viewer', require( './components/shareable/viewOnly' ) );
Vue.component( 'document-list', require( './components/home/documentList' ) );

new Vue( {
    el: '#app'
} );
