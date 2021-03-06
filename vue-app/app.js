/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap'

import Vue from 'vue'
import vuetify from './plugins/vuetify'
import App from './App.vue'
import store from "./store";

import router from "./router";

require("./plugins/index.js");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*import CssBase from "css-loader/lib/css-base";
import AddStyles from "style-loader/lib/addStyles";*/
/*new Vue({
    vuetify,
    store,
    router,
  el: '#app',
  render: (h) => h(App)
});*/

new Vue({
    router,
    store,
    vuetify,
    render: h => h(App)
}).$mount('#soradius_app')
