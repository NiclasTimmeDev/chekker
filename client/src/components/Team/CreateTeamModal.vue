<template>
    <!-- 
    A modal that holds an input where
    the title of the new team can be 
    entered. When submitting the data will
    be sent to the API.
    -->
    <modal :showModal="show" :toggleModal="toggle" limitHeight="false">
        <template #title>
            <h3>Neues Team</h3>
        </template>
        <template #body>
            <form>
                <div class="form-group">
                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Der Titel Ihres neuen Teams..."
                        v-model="formData.name"
                    />
                </div>
                <button
                    @click.prevent="submit"
                    class="btn btn-primary flex-button"
                >
                    Erstellen <Spinner v-if="team.loading" />
                </button>
            </form>
        </template>
    </modal>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import Modal from "./../UI/Modals/Modal";
import Spinner from "./../UI/Spinners/SmallSpinner";
export default {
    data() {
        return {
            formData: {
                name: ""
            },
            formErrors: {
                name: ""
            }
        };
    },
    props: ["show", "toggle"],
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["team", "auth"])
    },
    methods: {
        ...mapActions(["createTeam"]),
        /**
         * Submit the form to create a new process.
         */
        async submit() {
            this._validateInputs();
            if (this.formErrors.name !== "") {
                return;
            }
            // Make API call.
            const response = await this.createTeam(this.formData);

            // If positive response, switch route.
            if (response) {
                // Close modal
                this.toggle();

                // Go to Team route if it's not already active
                if (this.$route.name === "Team") {
                    return;
                }
                this.$router.push({ name: "Team" });
            }
        },
        /**
         * Validate the inputs.
         */
        _validateInputs() {
            if (this.formData.name !== "") {
                this.formErrors.name = "";
                return;
            }
            this.formErrors.name = "Bitte geben Sie einen Namen ein.";
        }
    },
    components: {
        Modal,
        Spinner
    }
};
</script>
