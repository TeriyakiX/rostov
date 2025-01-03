import Vue from 'vue';
import VueRouter from 'vue-router';
import Toast from "vue-toastification";
import VueGoodTablePlugin from 'vue-good-table';

Vue.use(VueRouter);
Vue.use(VueGoodTablePlugin);
Vue.use(Toast, {});

import initAxios from './../general/services/axios';
initAxios(Vue);

import components from "./components";

if(document.getElementById('app')) {
    const app = new Vue({
        el: '#app',
        components: {
            ...components
        }
    });
}

