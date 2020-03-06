import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'

Vue.use(VueRouter)

const routes = [
  {
    path:'*',
    redirect: '/login'
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta:{
      auth: undefined
    }
  },
  {
    path: '/',
    name: 'home',
    component: Home,
    meta:{
      auth: { redirect: {name: 'login'}, forbiddenRedirect: '/403'}
    }
  },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
