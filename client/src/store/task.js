// The task store.
import axios from "axios";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            loading: false,
            tasks: [],
            errors: []
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
        storeTasks(state, tasks) {
            state.loading = false;
            state.tasks = tasks
        },
        storeTasksError(state, msg) {
            state.errors = msg;
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
        async storeTasks({ commit }, data) {
            commit("startTaskSubmitLoading");
            try {
                const { processID, tasks } = data;
                // Check processID
                if (!parseInt(processID)) {
                    commit("storeTasksError", "Fehler im Prozess.");
                    return;
                }

                // Check format of task array
                if (!Array.isArray(tasks) || tasks.length === 0) {
                    commit("storeTasksError", "Fehler bei den Tasks.");
                    return;
                }

                // Check if every task has title and rank
                const areTasksValid = tasks.every(task => {
                    // Check validity of rank. 0 must also be valid.
                    const hasValidRank = task.rank === 0 || !!task.rank;
                    return !!task.title && hasValidRank;
                });
                if (!areTasksValid) {
                    commit("storeTasksError", "Fehler bei den Tasks.");
                    return;
                }
                // Query API
                const res = await axios.post("/api/task", {
                    process_id: processID,
                    tasks: tasks
                });



                // Store new tasks if req was sucessful.
                if (res.status === 200) {
                    commit("stopTaskSubmiLoading");
                    commit("storeTasks", res.data);
                    return res.data;
                }
            } catch (error) {
                commit("storeTasksError", error);
                console.log(error);
                return false;
            }
        }
    }
};
