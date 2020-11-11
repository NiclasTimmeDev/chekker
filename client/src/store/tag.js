import axios from "axios";
import localStorageService from "./../services/localStorageService";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            tags: [],
            loading: true,
            error: ""
        };
    },
    // ============================
    // STATE
    // ============================
    mutations: {
        /**
         * Start Loading.
         *
         * @param {object} state
         */
        startTagLoading(state) {
            state.loading = true;
        },
        /**
         * Start Loading.
         *
         * @param {object} state
         */
        stopTagLoading(state) {
            state.loading = false;
        },
        /**
         *
         * @param {object} state
         *   The state.
         * @param {array} tags
         *   All tags of the current team.
         */
        storeAllTags(state, tags) {
            state.loading = false;
            state.tags = tags;
            state.error = "";
        },
        /**
         *
         * @param {object} state
         *   The state.
         * @param {object} tag
         *   The tag.
         */
        addSingleTag(state, tag) {
            state.loading = false;
            state.tags = [...state.tags, tag];
            state.error = "";
        },
        storeTagError(state, msg) {
            state.loading = false;
            state.error = msg;
        }
    },
    // ============================
    // ACTIONS
    // ============================
    actions: {
        /**
         * Create a new tag.
         *
         * @param {object} commit
         *   The commit object.
         * @param {*} tag
         *   The tag object.
         *
         * @return Boolean
         */
        async createTag({ commit }, tag) {
            try {
                const { title, background, text } = tag;
                const currentTeam = localStorageService.get("current_team");
                // Check if fields exist.
                if (!title || !background || !text) {
                    commit(
                        "storeTagError",
                        "Bitte füllen Sie alle Felder aus."
                    );
                    return false;
                }

                // Check if a team is selected.
                if (!currentTeam) {
                    commit("storeTagError", "Sie müssen ein Team wählen.");
                    return false;
                }

                // Make Api req.
                const res = await axios.post("/api/tag", {
                    title: title,
                    background: background,
                    text: text,
                    team_id: currentTeam
                });

                // Store tag if req was successful.
                if (res.status === 201) {
                    commit("addSingleTag", res.data);
                    return true;
                }
            } catch (error) {
                commit("storeTagError", error.response.data.error);
                return false;
            }
        },
        /**
         * Get all tags of the current teams.
         *
         * @param {object} commit
         *   The commit object.
         */
        async getAllTags({ commit }) {
            try {
                // Get the current team id.
                const currentTeam = localStorageService.get("current_team");

                // Make api request.
                const res = await axios.get(`/api/tag/${currentTeam}`);

                // Store all teams if response status is not 200.
                if (res.status !== 200) {
                    commit("storeTagError", error.response.data.error);
                    return false;
                }

                // Store error if resonse code was 200;
                commit("storeAllTags", res.data);
                return true;
            } catch (error) {
                commit("storeTagError", error.response.data.error);
                return false;
            }
        }
    },
    // ============================
    // GETTERS
    // ============================
    getters: {
        /**
         * Retrieve tags from state.
         *
         * @param state
         */
        getTags: state => {
            return state.tags;
        }
    }
};
