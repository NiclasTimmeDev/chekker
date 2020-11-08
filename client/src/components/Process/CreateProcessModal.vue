<template>
    <!-- 
    A modal that holds an input where
    the title of the new process can be 
    entered. When submitting the data will
    be sent to the API.
    -->
    <modal :showModal="show" :toggleModal="toggle" limitHeight="false">
        <template #title>
            <h3>Neuer Prozess</h3>
        </template>
        <template #body>
            <!-- ALERT MESSAGE -->
            <template v-if="process.error">
                <div class="alert alert-danger" role="alert">
                    {{ process.error }}
                </div>
            </template>
            <form>
                <div class="form-group">
                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Der Titel Ihres neuen Prozesses..."
                        v-model="formData.title"
                    />
                </div>
                <!-- Error message -->
                <template v-if="formErrors.title">
                    <div class="invalid-feedback mb-3">
                        {{ formErrors.title }}
                    </div>
                </template>
                <button
                    @click.prevent="submit"
                    class="btn btn-primary flex-button"
                >
                    Erstellen <Spinner v-if="process.loading" />
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
                title: ""
            },
            formErrors: {
                title: ""
            }
        };
    },
    props: ["show", "toggle"],
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["process"])
    },
    methods: {
        ...mapActions(["createProcess"]),
        /**
         * Submit the form to create a new process.
         */
        async submit() {
            this._validateInput();
            if (this.formErrors.title !== "") {
                return;
            }
            // Make API call.
            const res = await this.createProcess(this.formData);

            // Actions if creation was successful.
            if (res) {
                console.log(res);
                this._createProcessSuccess(res.id);
            }
        },
        /**
         * Validate the inputs.
         */
        _validateInput() {
            if (this.formData.title !== "") {
                this.formErrors.title = "";
                return;
            }
            this.formErrors.title = "Bitte geben Sie einen Titel ein.";
        },
        /**
         * To be perfomred steps if creation was successful.
         * @param {string} id
         *   THe id of the newly created process.
         */
        _createProcessSuccess(id) {
            // Close modal
            this.toggle();

            // Go to Team route if it's not already active
            if (this.$route.name === "EditProcess") {
                return;
            }
            this.$router.push(`/process/edit/${id}`);
        }
    },
    components: {
        Modal,
        Spinner
    }
};
</script>
