import axios from "axios";
import localStorageService from "./../services/localStorageService";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            loading: false,
            processesOfUser: [],
            error: ""
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
        startProcessLoading(state) {
            state.loading = true;
        },
        /**
         * Store one new process.
         *
         * @param {object} state
         *   The state object.
         * @param {object} process
         *   The new process.
         */
        storeNewProcess(state, process) {
            state.loading = false;
            state.processesOfUser = [...state.processesOfUser, process];
            state.error = "";
        },
        /**
         *
         * @param {object} state
         *   The state object.
         * @param {array} processes
         *   All processes of the user.
         */
        storeAllProcesses(state, processes) {
            state.loading = false;
            state.processesOfUser = processes;
            state.error = "";
        },
        storeProcessError(state, msg) {
            state.loading = false;
            state.error = msg;
        }
    },
    // ============================
    // ACTIONS
    // ============================
    actions: {
        /**
         * Create a new process.
         *
         * @param {object} commit
         *   The commit object
         * @param {object} form
         *   The form object.
         */
        async createProcess({ commit }, form) {
            commit("startProcessLoading");
            try {
                // Get params from form.
                let {
                    name,
                    description,
                    permission,
                    allowedMembers,
                    tags
                } = form;

                // Transform allowedMembers and tags from Vue observer obj to array.
                allowedMembers = JSON.parse(
                    JSON.stringify(form.allowedMembers)
                );
                tags = JSON.parse(JSON.stringify(form.tags));

                // Get currently selected team from local storage.
                const currentTeam = localStorageService.get("current_team");

                // Send request.
                const res = await axios.post("/api/process", {
                    team_id: currentTeam,
                    name: name,
                    description: description,
                    permission: permission,
                    allowed_members: allowedMembers,
                    tags: tags
                });

                // Store new team if request was successful.
                if (res.status === 201) {
                    commit("storeNewProcess", res.data);
                    return true;
                }
            } catch (error) {
                commit("storeProcessError", error.response.data.error);
                return false;
            }
        },
        async getAllProcessesOfUser({ commit }) {
            try {
                commit("startProcessLoading");
                // Get current team. Return errof if none is chosen.
                const currentTeam = localStorageService.get("current_team");
                if (!currentTeam) {
                    commit("storeProcessError", "Es ist kein Team ausgewählt.");
                    return false;
                }

                // Make API request.
                const res = await axios.get(`/api/process/${currentTeam}`);

                // Store all processes if req was successful.
                if (res.status === 200) {
                    commit("storeAllProcesses", res.data);
                    return true;
                }
            } catch (error) {
                commit("storeProcessError", error.response.data.error);
                return false;
            }
        }
    }
};
