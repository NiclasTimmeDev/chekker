//  e task store.
import axios from "axios";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            loading: false,
            loadingAllTasks: false,
            tasks: [],
            errors: [],
            steps: [],
            loadingSteps: false,
            loadingStepsError: ""
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
        startTaskSubmitLoading(state) {
            state.loading = true;
        },
        /**
         * Start Loading.
         *
         * @param {object} state
         */
        stopTaskSubmiLoading(state) {
            state.loading = false;
        },
        storeSingleTask(state, task) {
            state.loading = false;
            state.tasks.push(task);
        },
        storeTasksError(state, msg) {
            state.errors = msg;
        },
        startLoadingAllTasks(state) {
            state.loadingAllTasks = true;
        },
        stopLoadingAllTasks(state) {
            state.loadingAllTasks = false;
        },
        storeAllTasks(state, tasks) {
            state.loadingAllTasks = false;
            state.tasks = tasks;
        },
        nonConsequentialError(state, msg) {
            state.loading = false;
            state.loadingAllTasks = false;
            state.errors = [...state.errors, msg];
        },
        updateTask(state, updatedTask) {
            state.loading = false;
            state.loadingAllTasks = false;
            state.tasks = state.tasks.map(task => {
                if (task.id === updatedTask.id) {
                    return updatedTask;
                } else {
                    return task;
                }
            });
        },
        startLoadingSteps(state) {
            state.loadingSteps = true;
        },
        loadingStepsError(state, msg) {
            state.loadingSteps = false;
            state.steps = [];
            state.loadingStepsError = msg;
        },
        loadingStepsSuccess(state, steps) {
            state.loadingSteps = false;
            state.steps = steps;
            state.loadingStepsError = "";
        }
    },
    // ============================
    // ACTIONS
    // ============================
    actions: {
        /**
         * Store one or moultiple tasks
         *
         * @param {object} commit
         *   The commit object
         * @param {string} processID
         *   The id of the process that the tasks belong to.
         * @param {array} tasks
         *   The tasks that shall be stored.
         * @return {array|boolean}
         *   tasks if successfull request, false if not.
         */
        async createTask({ commit }, data) {
            try {
                const { process_id, rank } = data;

                // Error if process id is messed up.
                if (!process_id) {
                    return commit(
                        "storeTasksError",
                        "Ein Fehler ist beim speichern aufgetreten."
                    );
                }
                // Send to create endpoint.
                const res = await axios.post("/api/task", { process_id, rank });
                if (res.status === 201) {
                    commit("storeSingleTask", res.data);
                    return res.data;
                }
            } catch (error) {
                commit("storeTasksError", error.response.data.error);
            }
        },
        /**
         * Get all tasks that belong to a process.
         *
         * @param {object} commit
         *   The commit object.
         * @param {string} process_id
         *   The process id.
         *
         * @return object|null
         *   The tasks or null.
         */
        async getAllProcessTasks({ commit }, process_id) {
            try {
                // Start loading.
                commit("startLoadingAllTasks");

                // Fetch from api.
                const res = await axios.get(`/api/task/${process_id}`);

                // Data successfully fetched.
                if (res.status === 200) {
                    commit("storeAllTasks", res.data);
                    return res.data;
                }
            } catch (error) {
                commit("stopLoadingAllTasks");
                commit("storeTasksError", error.response.data.error);
            }
        },
        /**
         * Get all steps that belong to a process.
         *
         * @param {object} commit
         *   The commit object.
         * @param {string} processID
         *   The process the steps belong to.
         */
        async getAllProcessSteps({ commit }, processID) {
            try {
                // Start loading.
                commit("startLoadingSteps");

                // Send data to api.
                const res = await axios.get(`/api/widget/${processID}`);

                // Success.
                if (res.status === 200) {
                    commit("loadingStepsSuccess", res.data);
                    return res.data;
                }
            } catch (error) {
                commit(
                    "loadingStepsError",
                    "Sorry, etwas ist schief gelaufen."
                );
            }
        },
        /**
         * Update a single new task.
         *
         * @param {object} commit
         *   The commit object.
         * @param {object} data
         *   The process id and the task to be updated.
         *
         * @return {object|null}
         *   The new task if successfull.
         */
        async updateTask({ commit }, data) {
            try {
                const { process_id, task } = data;

                // Check data.
                if (!task.id || !process_id) {
                    return commit(
                        "nonConsequentialError",
                        "Der Task ist nicht korrekt konfiguriert."
                    );
                }
                // Send data to api.
                const res = await axios.put("/api/task", data);

                // Success.
                if (res.status === 200) {
                    commit("updateTask", res.data);
                    return res.data;
                }
            } catch (error) {
                commit("nonConsequentialError", "Etwas ist schief gelaufen.");
            }
        },
        /**
         * Update the rankings of all tasks.
         *
         * @param {object} commit
         *   The commit object.
         * @param {object} data
         *   The process id and tasks.
         *
         * @return {array|null}
         *   The updated tasks or null.
         */
        async updateRankings({ commit }, data) {
            try {
                // Extract data from request.
                const { process_id, tasks } = data;

                // Exit if no process given.
                if (!process_id) {
                    return commit(
                        "nonConsequentialError",
                        "Keine Pozess-ID angegeben."
                    );
                }

                // Create 'leaner' tasks array to minimize transferred data.
                const tasksError = false;
                const newTasksArray = tasks.map((task, index) => {
                    if (!task.id) {
                        tasksError = true;
                        return;
                    }
                    return { id: task.id, rank: index };
                });

                // Exit if something is wrong with tasks.
                if (tasksError) {
                    return commit(
                        "nonConsequentialError",
                        "Bei den Tasks ist etwas schief gelaufen."
                    );
                }

                // Send data to api.
                const res = await axios.put("/api/task/rank", {
                    process_id: process_id,
                    tasks: newTasksArray
                });

                // Success.
                if (res.status === 200) {
                    commit("storeAllTasks", res.data);
                    return res.data;
                }
            } catch (error) {
                commit("nonConsequentialError", "Etwas ist schief gelaufen.");
            }
        }
    }
};
