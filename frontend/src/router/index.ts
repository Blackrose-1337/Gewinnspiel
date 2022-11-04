import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import { useAuthStore } from "@/stores/auth";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: HomeView,
            meta: { requiresAuth: false },
        },
        // {
        //     path: "/helloworld",
        //     name: "helloworld",
        //     meta: { requiresAuth: true },
        //     // route level code-splitting
        //     // this generates a separate chunk (About.[hash].js) for this route
        //     // which is lazy-loaded when the route is visited.
        //     component: () => import("../components/HelloWorld.vue"),
        // },
        // {
        //     path: "/login",
        //     name: "login",
        //     meta: { requiresAuth: false },
        //     props: route => ({ redirectTo: route.query.redirectTo }),
        //     // route level code-splitting
        //     // this generates a separate chunk (About.[hash].js) for this route
        //     // which is lazy-loaded when the route is visited.
        //     component: () => import("../views/LoginView.vue"),
        // },
        {
            path: "/customer",
            name: "customer",
            meta: { requiresAuth: false },
            // route level code-splitting
            // this generates a separate chunk (About.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import("../views/WettbewerbView.vue"),
        },
        {
            path: "/evaluation",
            name: "evaluation",
            meta: { requiresAuth: false},
            component: () => import("../views/BewertungView.vue"),
        },
        {
            path: "/user",
            name: "user",
            meta: { requiresAuth: false},
            component: () => import("../views/UserView.vue")
        },
        {
            path: "/verwaltung",
            name: "verwaltung",
            meta: { requiresAuth: false },
            component: () => import("../views/VerwaltungView.vue")
        },
        {
            path: "/project",
            name: "project",
            meta: { requiresAuth: false },
            component: () => import("../views/ProjectView.vue")
        },
        {
            path: "/designe",
            name: "designe",
            meta: { requiresAuth: false },
            component: () => import("../views/DesigneView.vue")
        }
        // {
        //     path: "/admin-survey",
        //     name: "admin-survey",
        //     meta: { requiresAuth: false },
        //     // route level code-splitting
        //     // this generates a separate chunk (About.[hash].js) for this route
        //     // which is lazy-loaded when the route is visited.
        //     component: () => import("../views/AdminSurveyview.vue"),
        // },
    ],
});
router.beforeEach(async to => {
    const authStore = useAuthStore();
    if (!authStore.isInitialized) {
        await authStore.initialize();
    }
    if (to.meta.requiresAuth && !authStore.isAuthenticated)
        return {
            name: "login",
            query: {
                redirectTo: to.fullPath,
            },
        };
});

export default router;
