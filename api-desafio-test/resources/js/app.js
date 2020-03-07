require('./bootstrap');
import Vue from 'vue'
import router from './vue/src/router'
import Index from './vue/src/index.vue'

window.vue = Vue

Vue.component('index', Index)
const app = new Vue({
    router,
    render: h => h(Index)
}).$mount('#app')