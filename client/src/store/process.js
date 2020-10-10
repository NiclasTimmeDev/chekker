import axios from "axios";
import localStorageService from "./../services/localStorageService";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            loading: false,
            processesOfUser: []
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
        }
    },
    // ============================
    // ACTIONS
    // ============================
    actions: {
        async createProcess({ commit }, form) {
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
                if (res.status === 200) {
                    commit("storeNewProcess", res.data);
                }
            } catch (error) {
                console.log(error.response.data);
            }
        }
    }
};
