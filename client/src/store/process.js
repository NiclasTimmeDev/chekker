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
            singleProcess: {},
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
         * Store a single process.
         *
         * @param {object} state
         *   The state object.
         * @param {object} process
         *   The new process.
         */
        storeSingleProcess(state, process) {
            state.loading = false;
            (state.singleProcess = process), (state.error = "");
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
        /**
         * Store an error.
         *
         * @param {object} state
         *   The state Object
         * @param {string} msg
         *   The error message.
         */
        storeProcessError(state, msg) {
            state.loading = false;
            state.error = msg;
            state.processesOfUser = [];
            state.singleProcess = {};
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
            try {
                commit("startProcessLoading");
                // Get params from form.
                const name = form.title;

                // Get currently selected team from local storage.
                const currentTeam = localStorageService.get("current_team");

                // Return if no team is selected.
                if (!currentTeam) {
                    return commit(
                        "storeProcessError",
                        "Es ist kein Team ausgewählt."
                    );
                }

                // Send request.
                const res = await axios.post("/api/process", {
                    team_id: currentTeam,
                    name: name
                });

                // Store new team if request was successful.
                if (res.status === 201) {
                    commit("storeNewProcess", res.data);
                    return res.data;
                }
            } catch (error) {
                console.log(error);
                commit("storeProcessError", error.response.data.error);
                return false;
            }
        },
        /**
         * Get all processes of a user.
         *
         * @param {object} commit
         *   The commit object.
         *
         * @return boolean
         */
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
                const res = await axios.get(`/api/process/all/${currentTeam}`);
                // Store all processes if req was successful.
                if (res.status === 200) {
                    commit("storeAllProcesses", res.data);
                    return true;
                }
            } catch (error) {
                commit("storeProcessError", error.response.data.error);
                return false;
            }
        },
        /**
         * Get a single process by id.
         *
         * @param {object} commit
         *   The commit object.
         * @param {string} processID
         *   The id of the process of interest.
         */
        async getSingleProcess({ commit }, processID) {
            try {
                commit("startProcessLoading");
                // Make api request.
                const res = await axios.get(`/api/process/single/${processID}`);

                // Store  process if request was successful.
                if (res.status === 200) {
                    commit("storeSingleProcess", res.data);
                    return true;
                }
            } catch (error) {
                commit("storeProcessError", error.response.data.error);
                return false;
            }
        }
    }
};
