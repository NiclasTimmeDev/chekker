<template>
    <div class="row justify-content-center align-items-center">
        <div v-if="auth.loading || team.loading">
            <full-page-spinner></full-page-spinner>
        </div>
        <!-- <div v-else-if="team.loading">
            <full-page-spinner></full-page-spinner>
        </div> -->
        <div class="col-md-9 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <!-- ALERT MESSAGE -->
                    <template v-if="team.errors">
                        <div class="alert alert-danger" role="alert">
                            {{ team.errors }}
                        </div>
                    </template>

                    <!-- HEADER -->
                    <h2 class="page-header">
                        Neues Team erstellen
                    </h2>
                    <form>
                        <!-- Name -->
                        <div class="form-group">
                            <label for="email">Name des Teams</label>
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                v-model="form.name"
                            />
                            <template v-if="errors.name">
                                <div class="invalid-feedback">
                                    {{ errors.name }}
                                </div>
                            </template>
                        </div>
                        <!-- SUBMIT BUTTON -->
                        <button class="btn btn-primary" @click.prevent="create">
                            Team erstellen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "../../components/FullPageSpinner";

export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            form: {
                name: ""
            },
            errors: {
                name: ""
            }
        };
    },
    // ============================
    // METHODS
    // ============================
    methods: {
        ...mapActions(["createTeam"]),
        async create() {
            this._validateInputs();
            if (this.errors.name !== "") {
                return;
            }
            const response = await this.createTeam(this.form);
            if (response) {
                this.$router.push({ name: "Dashboard" });
            }
        },
        _validateInputs() {
            console.log(this.auth.user);
            if (this.form.name === "") {
                this.errors.name = "Bitte geben Sie einen Namen ein.";
            } else {
                this.errors.name = "";
            }
        }
    },
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["team", "auth"])
    },
    // ============================
    // COMPONENTS
    // ============================
    components: {
        "full-page-spinner": FullPageSpinner
    }
};
</script>

<style lang="scss" scoped>
.row {
    height: 100vh;
}
.invalid-feedback {
    display: inherit;
}
</style>
