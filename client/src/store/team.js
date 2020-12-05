import axios from "axios";
import localStorageService from "./../services/localStorageService";
import validator from "validator";

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
            errors: "",
            externalPersons: {
                loading: false,
                persons: [],
                error: ""
            }
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
        startTeamLoading(state) {
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
        },
        startLoadingExternalPerson(state) {
            state.externalPersons.loading = false;
        },
        storeExternalPersons(state, externalPersons) {
            state.externalPersons.loading = false;
            state.externalPersons.error = "";
            state.externalPersons.persons = externalPersons;
        },
        storeSinglePerson(state, externalPerson) {
            state.externalPersons.loading = false;
            state.externalPersons.error = "";
            state.externalPersons.persons = {
                ...state.externalPersons.persons,
                externalPerson
            };
        },
        storeExternalPersonsError(state, msg) {
            state.externalPersons.loading = false;
            state.externalPersons.error = msg;
            state.externalPersons.persons = [];
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
            commit("startTeamLoading");
            try {
                const { name } = team;
                const res = await axios.post("/api/team", { name });
                console.log(res);
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
            commit("startTeamLoading");
            try {
                const res = await axios.get("/api/team");
                commit("loadAllTeams", res.data);
                return true;
            } catch (error) {
                console.log(error);
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
            commit("startTeamLoading");
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
        /**
         * Load all external persons of the current team.
         *
         * @param {object} commit
         *   The commit object.
         *
         * @return {object || Boolean}
         *   New person if successful. Else false.
         */
        async loadAllExternalPersons({ commit }) {
            try {
                const currentTeam = localStorageService.get("current_team");
                if (!currentTeam) {
                    commit(
                        "storeExternalPersonsError",
                        "Kein Team ausgewählt."
                    );
                    return false;
                }

                // Make api request.
                const res = await axios.get(
                    `/api/external_person/${currentTeam}`
                );
                console.log(res.status);
                if (res.status === 200) {
                    commit("storeExternalPersons", res.data);
                    return true;
                }
            } catch (error) {
                console.log(error);
                commit("storeExternalPersonsError", error.response.data.error);
                return false;
            }
        },
        /**
         * Create a new external person.
         *
         * @param {object} commit
         *   The commit object.
         * @param {object} person
         *   The person that shall be created.
         *
         * @return {object || Boolean}
         *   New person if successful. Else false.
         */
        async createExternalPerson({ commit }, person) {
            commit("startLoadingExternalPerson");
            try {
                // Check if all data is sufficient.
                const { name, email, organization } = person;
                if (!name || !validator.isEmail(email)) {
                    commit(
                        "storeExternalPersonsError",
                        "Bitte geben Sie alle Felder korrekt ein."
                    );
                    return false;
                }

                // Get the current team.
                const currentTeam = localStorageService.get("current_team");
                if (!currentTeam) {
                    commit(
                        "storeExternalPersonsError",
                        "Es ist kein Team ausgewählt."
                    );
                    return false;
                }

                // Make api request.
                const res = await axios.post("/api/external_person", {
                    ...person,
                    team_id: currentTeam
                });

                // Store new person if request was successful.
                if (res.status === 201) {
                    commit("storeSinglePerson", res.data);
                    return res.data;
                }
            } catch (error) {
                console.log(error);
                commit("storeExternalPersonsError", error.response.data.error);
                return false;
            }
        },
        /**
         * Load all members of the current team.
         *
         * @param {object} commit
         *   The commit object.
         * @return {Boolean}
         *  True if api call was successful.
         */
        async loadTeamMembers({ commit }) {
            commit("startTeamLoading");
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
