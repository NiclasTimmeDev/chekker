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
                        Treten Sie einem Team bei
                    </h2>
                    <small class="mb-3"
                        >Geben Sie einfach den Zugangscode zu dem Team
                        ein.</small
                    >
                    <form>
                        <!-- Name -->
                        <div class="form-group">
                            <label for="email">Zugangscode</label>
                            <input
                                type="text"
                                class="form-control"
                                name="code"
                                v-model="form.code"
                            />
                            <template v-if="error">
                                <div class="invalid-feedback">
                                    {{ error }}
                                </div>
                            </template>
                        </div>
                        <!-- SUBMIT BUTTON -->
                        <button
                            @click.prevent="joinTeam(form.code)"
                            class="btn btn-primary"
                        >
                            Beitreten
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
                code: ""
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
        ...mapActions(["joinTeam"])
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
