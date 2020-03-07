import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Create from '../views/Create.vue'
import Update from '../views/Update.vue'

Vue.use(VueRouter)

const routes = [{
        path: '*',
        redirect: '/login'
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: true
        }
    },
    {
        path: '/create',
        name: 'create',
        component: Create,
        meta: {
            auth: true
        }
    },
    {
        path: '/edit/:id',
        name: 'edit',
        component: Update,
        meta: {
            auth: true
        }
    },
]

const router = new VueRouter({
        mode: 'history',
        routes,
    })
    // base: process.env.APP_URL
router.beforeEach((to, from, next) => {
    const currUser = localStorage.getItem('token')
    const requeriAuth = to.matched.some(item => item.meta.auth)

    if (requeriAuth && !currUser) next('login')

    else if (!requeriAuth && currUser) next('home')

    else next()
})

export default router