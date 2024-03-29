import { createRouter, createWebHistory } from "vue-router";
import WettbewerbView from "@/views/WettbewerbView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "wettbewerb",
            component: WettbewerbView,
            meta: { requiresAuth: false },
        },
        {
            path: "/customer",
            name: "customer",
            meta: { requiresAuth: false },
            component: () => import("../views/WettbewerbView.vue"),
        },
        {
            path: "/evaluation",
            name: "evaluation",
            meta: { requiresAuth: false },
            component: () => import("../views/BewertungView.vue"),
        },
        {
            path: "/user",
            name: "user",
            meta: { requiresAuth: false },
            component: () => import("../views/UserView.vue"),
        },
        {
            path: "/user-project",
            name: "user-project",
            meta: { requiresAuth: false },
            component: () => import("../views/UserProjectView.vue"),
        },
        {
            path: "/user-newproject",
            name: "user-newproject",
            meta: { requiresAuth: false },
            component: () => import("../views/UserNewProjectView.vue"),
        },
        {
            path: "/verwaltung",
            name: "verwaltung",
            meta: { requiresAuth: false },
            component: () => import("../views/VerwaltungView.vue"),
        },
        {
            path: "/project",
            name: "project",
            meta: { requiresAuth: false },
            component: () => import("../views/ProjectView.vue"),
        },
        {
            path: "/designe",
            name: "designe",
            meta: { requiresAuth: false },
            component: () => import("../views/DesigneView.vue"),
        },
        {
            path: "/analysis",
            name: "auswertung",
            meta: { requiresAuth: false },
            component: () => import("../views/AuswertungView.vue"),
        },
        {
            path: "/token/:value",
            name: "confirm",
            meta: { requiresAuth: false },
            component: () => import("../views/BestaetigungView.vue"),
        },
        {
            path: "/login",
            name: "login",
            meta: { requiresAuth: false },
            component: () => import("../views/LoginView.vue"),
        },
        {
            path: "/password-set",
            name: "password-set",
            meta: { requiresAuth: true },
            component: () => import("../views/PasswordView.vue"),
        },
        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            meta: { requiresAuth: false },
            component: () => import("../views/NotFound.vue"),
        },
    ],
});
// router.beforeEach(async to => {
//     const authStore = useAuthStore();
//     if (!authStore.isInitialized) {
//         await authStore.initialize();
//     }
//     if (to.meta.requiresAuth && !authStore.isAuthenticated)
//         return {
//             name: "login",
//             query: {
//                 redirectTo: to.fullPath,
//             },
//         };
// });

export default router;
