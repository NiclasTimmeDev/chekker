import Vue from "vue";
import VueRouter from "vue-router";

import Login from "./../views/Login.vue";
import Register from "./../views/Register.vue";
import Dashboard from "./../views/Dashboard.vue";
// TEAM
import CreateTeam from "./../views/Team/CreateTeam.vue";
import JoinTeam from "./../views/Team/JoinTeam.vue";
import UpdateTeam from "./../views/Team/UpdateTeam.vue";
import Team from "./../views/Team/Team.vue";
// PROCESSES
import CreateProcess from "./../views/Process/CreateProcess.vue";
// TAG
import CreateTag from "./../views/Tag/CreateTag.vue";

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
        path: "/team",
        name: "Team",
        component: Team
    },
    {
        path: "/team/create",
        name: "CreateTeam",
        component: CreateTeam
    },
    {
        path: "/team/join",
        name: "JoinTeam",
        component: JoinTeam
    },
    {
        path: "/team/update",
        name: "UpdateTeam",
        component: UpdateTeam
    },
    /* ====================
    PROCESSES
    ==================== */
    {
        path: "/process/create",
        name: "CreateProcess",
        component: CreateProcess
    },
    /* ====================
    TAG
    ==================== */
    {
        path: "/tag/create",
        name: "CreateTag",
        component: CreateTag
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

export default router;
