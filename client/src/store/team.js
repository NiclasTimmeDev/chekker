import axios from "axios";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            team: {},
            loading: false,
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
         * StoreTeam.
         *
         * @param {object} state
         * @param {object} team
         */
        storeTeam(state, team) {
            state.loading = false;
            state.team = team;
        },
        /**
         * Store Team Error.
         *
         * @param {object} state
         * @param {object} error
         */
        storeTeamError(state, error) {
            state.loading = false;
            state.errors = error;
        }
    },
    // ============================
    // ACTIONS
    // ============================
    actions: {
        /**
         * Create a team.
         *
         * @param {object} commit
         * @param {object} team
         */
        async createTeam({ commit, dispatch }, team) {
            commit("startLoading");
            try {
                const { name } = team;
                const res = await axios.post("/api/team", { name });

                if (res.status === 201) {
                    commit("storeTeam", res.data);
                    return true;
                }
            } catch (error) {
                if (error.response.status === 401) {
                    commit(
                        "storeTeamError",
                        "Sie haben nicht die passende Berechtigung."
                    );
                } else {
                    commit(
                        "storeTeamError",
                        "Sorrz, etwas ist schief gelaufen."
                    );
                }
                return false;
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
        getTeam: state => {
            return state;
        }
    }
};
