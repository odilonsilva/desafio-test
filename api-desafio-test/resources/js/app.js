require('./bootstrap');
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import router from './vue/src/router'
import Index from './vue/src/index.vue'
import auth from './vue/src/auth'
import VueAxios from 'vue-axios';
import Axios from 'axios';
import VueRouter from 'vue-router';

window.vue = Vue
Vue.router = router
Vue.use(VueRouter)

axios.defaults.baseURL = `${process.env.APP_URL}/api`
Vue.use(VueAxios,Axios)
Vue.use(VueAuth,auth)

Vue.component('index',Index)
const app = new Vue({
    router,
    el:'#app'
})