import Axios from "axios";

export default {
  // ============================
  // STATE
  // ============================
  state: () => {
    return {
      user: {},
      loading: true,
      errors: ""
    };
  },
  // ============================
  // MUTATIONS
  // ============================
  mutations: {
    /**
     * Start Loading.
     *
     * @param {object} state
     */
    startLoading(state) {
      state.loading = true;
    },
    /**
     * Put user into store.
     *
     * @param {object} state
     * @param {object} user
     */
    loadUser(state, user) {
      state.loading = false;
      state.user = user;
    },
    /**
     * Loading user failed.
     *
     * @param {object} state
     */
    loadUserError(state) {
      state.loading = false;
      state.user = {};
    },
    /**
     * Generate an error message.
     * @param {object} state
     * @param {object} payload
     */
    generateErrorMsg(state, payload) {
      state.loading = false;
      state.user = {};
      state.errors = payload.msg;
    }
  },
  // ============================
  // ACTIONS
  // ============================
  actions: {
    /**
     * Load authenticated user.
     *
     * @param {object} commit
     */
    async loadUser({ commit }) {
      try {
        await axios.get("/sanctum/csrf-cookie");
        const res = await axios.get("/api/user");
        if (res.status === 200) {
          commit("loadUser", res.data);
        } else {
        }
      } catch (error) {
        commit("loadUserError");
      }
    },
    /**
     * Login an user.
     *
     * @param {object} commit
     * @param {object} credentials
     */
    async login({ commit, dispatch }, credentials) {
      try {
        const { email, password } = credentials;
        await axios.get("/sanctum/csrf-cookie");
        const res = await axios.post("/login", {
          email,
          password
        });

        if (res.status === 204) {
          console.log("login successful");
          dispatch("loadUser");
        }
      } catch (error) {
        if (error.response.status === 422) {
          commit("generateErrorMsg", {
            msg: "Sorry, die Zugangsdaten sind nicht korrekt."
          });
        } else {
          commit("generateErrorMsg", {
            msg: "Sorry, etwas ist schiefgelaufen."
          });
        }
      }
    }
  },
  // ============================
  // GETTERS
  // ============================
  getters: {
    /**
     * Retrieve user from state.
     *
     * @param state
     */
    getAuth: state => {
      return state;
    },
    /**
     *
     */
    isUserAuthenticated: state => {
      return !state.loading && Object.keys(state.user).length !== 0;
    }
  }
};
