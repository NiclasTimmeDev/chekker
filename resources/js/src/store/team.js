import axios from "axios";
import localStorageService from "./../services/localStorageService";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            teams: [],
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
         * @param {object} teams
         */
        storeTeam(state, teams) {
            state.loading = false;
            state.teams = [...state.teams, teams];
        },
        loadAllTeams(state, teams) {
            state.loading = false;
            state.teams = teams;
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
         * @param {object} teams
         */
        async createTeam({ commit, dispatch }, team) {
            commit("startLoading");
            try {
                const { name } = team;
                const res = await axios.post("/api/team", { name });

                if (res.status === 201) {
                    localStorageService.add("current_team", res.data.id, true);
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
                        "Sorry, etwas ist schief gelaufen."
                    );
                }
                return false;
            }
        },
        async loadTeams({ commit }) {
            // commit("startLoading");
            try {
                const res = await axios.get("/api/team");

                commit("loadAllTeams", res.data);
            } catch (error) {
                if (error.response.status === 401) {
                    commit(
                        "storeTeamError",
                        "Sie haben nicht die passende Berechtigung."
                    );
                } else {
                    console.log(error.response.data);
                    commit(
                        "storeTeamError",
                        "Sorry, etwas ist schief gelaufen."
                    );
                }
                return false;
            }
        },
        async joinTeam({ commit }, accessCode) {
            try {
                const res = await axios.post("/api/team/join", {
                    code: accessCode
                });
                console.log(res);
            } catch (error) {
                console.log(error.response.data);
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
        getTeams: state => {
            return state.teams;
        }
    }
};
