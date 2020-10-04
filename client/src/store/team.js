import axios from "axios";
import localStorageService from "./../services/localStorageService";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            teams: [],
            members: [],
            membersLoaded: false,
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
        storeTeam(state, team) {
            state.loading = false;

            let isNewTeam;
            // Replace in state if team already exists.
            state.teams.forEach((stateTeam, i) => {
                if (+stateTeam.id === +team.id) {
                    state.teams[i] = team;
                    isNewTeam = false;
                }
            });

            // Return if it's a new team.
            if (!isNewTeam) {
                return;
            }

            // Add to teams array if team is new.
            return (state.teams = [...state.teams, team]);
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
        },
        storeTeamMembers(state, members) {
            state.loading = false;
            state.membersLoaded = true;
            state.members = members;
            state.errors = "";
        },
        storeTeamMembersError(state) {
            state.loading = false;
            state.membersLoaded = false;
            members = [];
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
        /**
         * Load all teams of the user.
         *
         * @param {object} commit
         *   The commit object.
         */
        async loadTeams({ commit }) {
            // commit("startLoading");
            try {
                const res = await axios.get("/api/team");
                commit("loadAllTeams", res.data);
                return true;
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
        /**
         * Send request to join new team.
         *
         * @param {object} commit
         *   The commit object.
         * @param {string} accessCode
         *   The access code to the team.
         * @return boolean
         */
        async joinTeam({ commit }, accessCode) {
            try {
                const res = await axios.post("/api/team/join", {
                    code: accessCode
                });

                if (res.status === 200) {
                    localStorageService.add("current_team", res.data.id, true);
                    commit("storeTeam", res.data);
                    return true;
                }
            } catch (error) {
                commit("storeTeamError", error.response.data.error);
                return false;
            }
        },
        /**
         * Update the own team.
         *
         * @param {object} commit
         *   The commit object.
         * @param {string} newName
         *   The new name of the team.
         * @return boolean.
         */
        async updateTeam({ commit }, newName) {
            commit("startLoading");
            const currentTeam = localStorageService.get("current_team");

            try {
                const res = await axios.patch("/api/team", {
                    name: newName,
                    team_id: currentTeam
                });

                if (res.status === 200) {
                    commit("storeTeam", res.data);
                    return true;
                }
            } catch (error) {
                commit("storeTeamError", error.response.data.error);
                return false;
            }
        },
        async loadTeamMembers({ commit }) {
            commit("startLoading");
            const currentTeam = localStorageService.get("current_team");

            try {
                const res = await axios.get(`/api/team/members/${currentTeam}`);
                if (res.status === 200) {
                    commit("storeTeamMembers", res.data);
                }
            } catch (error) {
                commit("storeTeamMembersError", error.response.data.error);
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
        getTeams: state => {
            return state.teams;
        },
        /**
         * Retrieve members from state.
         *
         * @param state
         */
        getMembers: state => {
            return state.members;
        }
    }
};
