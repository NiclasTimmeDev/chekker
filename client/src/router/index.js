import Vue from "vue";
import VueRouter from "vue-router";

import Login from "./../views/Login.vue";
import Register from "./../views/Register.vue";
import Dashboard from "./../views/Dashboard.vue";
import CreateTeam from "./../views/Team/CreateTeam.vue";

Vue.use(VueRouter);

const routes = [
    /* ====================
    AUTH
    ==================== */
    {
        path: "/login",
        name: "Login",
        component: Login
    },
    {
        path: "/register",
        name: "Register",
        component: Register
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard
    },
    /* ====================
    TEAM
    ==================== */
    {
        path: "/team/create",
        name: "CreateTeam",
        component: CreateTeam
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;
