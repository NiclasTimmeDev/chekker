import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import auth from "./auth/authStore";

export default new Vuex.Store({
  state: {
    count: 0
  },
  mutations: {},
  actions: {},
  getters: {},
  modules: {
    auth
  }
});
