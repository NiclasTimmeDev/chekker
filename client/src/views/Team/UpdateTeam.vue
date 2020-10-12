<template>
    <div class="row justify-content-center align-items-center">
        <div v-if="auth.loading || team.loading">
            <full-page-spinner></full-page-spinner>
        </div>
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
                        Ändern Sie den Namen Ihres Teams.
                    </h2>
                    <form>
                        <!-- Name -->
                        <div class="form-group">
                            <label for="email">Neuer Name</label>
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                v-model="form.name"
                            />
                            <template v-if="error">
                                <div class="invalid-feedback">
                                    {{ error }}
                                </div>
                            </template>
                        </div>
                        <!-- SUBMIT BUTTON -->
                        <button
                            @click.prevent="updateTeam(form.name)"
                            class="btn btn-primary"
                        >
                            Ändern
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "../../components/UI/Spinners/FullPageSpinner.vue";

export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            form: {
                name: ""
            },
            error: ""
        };
    },
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["team", "auth"])
    },
    // ============================
    // METHODS
    // ============================
    methods: {
        ...mapActions(["updateTeam"])
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

small {
    display: block;
}
</style>
