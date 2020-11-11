import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import auth from "./auth/authStore";
import team from "./team";
import process from "./process";
import tag from "./tag";
import task from "./task";

export default new Vuex.Store({
    state: {},
    mutations: {},
    actions: {},
    getters: {},
    modules: {
        auth,
        team,
        process,
        tag,
        task
    }
});
