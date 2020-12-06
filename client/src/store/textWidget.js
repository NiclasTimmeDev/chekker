import axios from "axios";

export default {
    // ============================
    // STATE
    // ============================
    state: () => {
        return {
            loading: false,
            loadingAllTextWidgets: false,
            widgets: [],
            errors: [],
            updateTextWidgetError: ""
        };
    },
    // ============================
    // MUTATIONS
    // ============================
    mutations: {
        storeNewTextWidget(state, widget) {
            state.loading = false;
            state.widgets = [...state.widgets, widget];
        },
        createTextWidgetError(state, msg) {
            state.loading = false;
            state.errors = [...state.errors, msg];
        },
        updateTextWidgetError(state, msg) {
            state.updateTextWidgetError = msg;
        },
        updateTextWidgetSuccess(state, widget) {
            state.updateTextWidgetError = "";
            state.widgets = state.widgets.map((stateWidget, index) => {
                if (parseInt(widget.id) === parseInt(stateWidget.id)) {
                    return widget;
                }
                return stateWidget;
            });
        }
    },
    // ============================
    // ACTIONS
    // ============================
    actions: {
        async createTextWidget({ commit }, data) {
            try {
                const { process_id, task_id, widget } = data;

                if (!process_id || !task_id || !widget) {
                    return commit(
                        "createTextWidgetError",
                        "Nicht alle Daten wurden eingegeben."
                    );
                }

                // Check if the values of the widgets are given.
                if (!widget.value === undefined || widget.rank === undefined) {
                    return commit(
                        "createTextWidgetError",
                        "Das Textwidget hat nicht alle nötigen Daten."
                    );
                }

                // Send data to api.
                const res = await axios.post("/api/textwidget", {
                    process_id,
                    task_id,
                    widget
                });
                console.log(res.status);
                if (res.status === 201) {
                    commit("storeNewTextWidget", res.data);
                    return res.data;
                }
            } catch (error) {
                return commit(
                    "createTextWidgetError",
                    "Sorry, etwas ist schief gelaufen."
                );
            }
        },
        async updateTextWidget({ commit }, data) {
            try {
                const { process_id, widget_id, new_value, new_rank } = data;
                // Validate input.
                console.log(process_id);
                if (
                    process_id === undefined ||
                    widget_id === undefined ||
                    new_value === undefined ||
                    new_rank === undefined
                ) {
                    return commit(
                        "updateTextWidgetError",
                        "Nicht alle Daten wurden angegeben."
                    );
                }

                // Send data to api.
                const res = await axios.put("/api/textwidget", {
                    process_id,
                    widget_id,
                    new_value,
                    new_rank
                });

                if (res.status === 200) {
                    commit("updateTextWidgetSuccess", res.data);
                    return res.data;
                }
            } catch (error) {}
        }
    }
};
