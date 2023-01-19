import { createRouter, createWebHistory } from 'vue-router'
import LogInView from '../views/LogInView.vue'
import { useAuthStore } from "@/store/auth.store";
const routes = [{
        path: '/',
        name: 'logIn',
        component: LogInView
    },
    {
        path: '/about',
        name: 'about',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        meta: { requiresAuth: true },
        component: () =>
            import ( /* webpackChunkName: "about" */ '../views/AboutView.vue')
    },
    {
        path: '/categoriesManager',
        name: 'categoriesManager',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        meta: { requiresAuth: true },
        component: () =>
            import ( /* webpackChunkName: "about" */ '../views/categoriesMangeView.vue')
    },
    {
        path: '/edittask/:id',
        name: 'edittask',
        props: true,
        meta: { requiresAuth: true },
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import ( /* webpackChunkName: "about" */ '../views/edittaskView.vue')
    },
    {
        path: '/signUp',
        name: 'signUp',
        props: true,
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import ( /* webpackChunkName: "about" */ '../views/signUpView.vue')
    },
    {
        path: '/home',
        name: 'home',
        meta: { requiresAuth: true },
        props: true,
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
            import ( /* webpackChunkName: "about" */ '../views/HomeView.vue')
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})
router.beforeEach((to, from) => {
    const isAuth = useAuthStore();
    if (isAuth.IsAuth) {
        if (to.name === "logIn") {
            return { name: "home" }
        }
    }
    if (to.meta.requiresAuth) {
        if (!isAuth.isAuth && to.name !== "login") {
            return { name: "logIn" };
        }
    }
});
export default router