/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

import Vue from 'vue';
import Vuex from 'vuex';
import main from './store/main';

window.Vue = Vue;
Vue.use(Vuex);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components/', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const el = document.getElementById('app');

if (el) {
    let user = JSON.parse(el.getAttribute('user'));
    let config = JSON.parse(el.getAttribute('config'));
    let routes = JSON.parse(el.getAttribute('routes'));

    main.state.user = user;
    main.state.config = config;
    main.state.routes = routes;

    const store = new Vuex.Store(main);
    const app = new Vue({
        store,
        el: '#app',
    });
}

