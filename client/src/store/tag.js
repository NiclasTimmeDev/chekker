import axios from "axios";
import localStorageService from "./../services/localStorageService";
import { identity } from "lodash";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            tags: [],
            loading: false,
            errors: ""
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
        startLoading(state) {
            state.loading = true;
        },
        stopLoading(state) {
            state.loading = false;
        },
        /**
         *
         * @param {object} state
         *   The state.
         * @param {array} tags
         *   All tags of the current team.
         */
        loadAllTags(state, tags) {
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
        storeError(state, msg) {
            state.loading = false;
            state.error = msg;
        }
    },
    // ============================
    // ACTIONS
    // ============================
    actions: {
        async createTag({ commit }, tag) {
            try {
                const { title, background, text } = tag;
                const currentTeam = localStorageService.get("current_team");
                // Check if fields exist.
                if (!title || !background || !text) {
                    commit("storeError", "Bitte füllen Sie alle Felder aus.");
                    return;
                }

                // Check if a team is selected.
                if (!currentTeam) {
                    commit("storeError", "Sie müssen ein Team wählen.");
                    return;
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
                }
            } catch (error) {
                console.log(error);
                commit("storeError", error.response);
            }
        }
    }
};
