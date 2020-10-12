<template>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div v-if="auth.loading">
                <full-page-spinner></full-page-spinner>
            </div>
            <div class="col-md-8 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <!-- ALERT MESSAGE -->
                        <template v-if="auth.errors">
                            <div class="alert alert-danger" role="alert">
                                {{ auth.errors }}
                            </div>
                        </template>

                        <!-- HEADER -->
                        <h2 class="page-header">
                            Login
                        </h2>
                        <form>
                            <!-- EMAIL -->
                            <div class="form-group">
                                <label for="email">E-Mail-Adresse</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="email"
                                    v-model="user.email"
                                />
                                <template v-if="errors.email">
                                    <div class="invalid-feedback">
                                        {{ errors.email }}
                                    </div>
                                </template>
                            </div>

                            <!-- PASSWORD -->
                            <div class="form-group">
                                <label for="password">Passwort</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    v-model="user.password"
                                />
                                <template v-if="errors.password">
                                    <div class="invalid-feedback">
                                        {{ errors.password }}
                                    </div>
                                </template>
                            </div>

                            <!-- STAY LOGGED IN -->
                            <div class="form-group form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="exampleCheck1"
                                />
                                <label
                                    class="form-check-label"
                                    for="exampleCheck1"
                                    >Eingeloggt bleiben</label
                                >
                            </div>
                            <!-- <div>{{ auth.user }}</div> -->
                            <!-- LOGIN BUTTON -->
                            <button
                                @click.prevent="loginUser"
                                class="btn btn-primary"
                            >
                                Login
                            </button>
                        </form>

                        <!-- SMALL TEXT -->
                        <small class="form-text text-muted"
                            >Noch kein Mitglied?
                            <router-link :to="{ name: 'Register' }"
                                >Registrieren</router-link
                            ></small
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import { mapActions } from "vuex";
import validator from "validator";
import FullPageSpinner from "./../components/UI/Spinners/FullPageSpinner.vue";

export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            user: {
                email: "",
                password: ""
            },
            errors: {
                email: "",
                password: ""
            }
        };
    },
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["auth"]),
        ...mapGetters(["isUserAuthenticated"])
    },
    // ============================
    // WATCH
    // ============================
    watch: {
        isUserAuthenticated() {
            if (this.isUserAuthenticated) {
                this.$router.push({ name: "Dashboard" });
            }
        }
    },
    // ============================
    // COMPONENTS
    // ============================
    components: {
        "full-page-spinner": FullPageSpinner
    },
    // ============================
    // METHODS
    // ============================
    methods: {
        ...mapActions(["login"]),
        /**
         * Log user in.
         */
        async loginUser() {
            const areInputsValid = this._validateInputs();
            if (areInputsValid) {
                await this.login(this.user);
            }
        },
        /**
         * Check if email and password are not invalid.
         */
        _validateInputs() {
            if (!validator.isEmail(this.user.email)) {
                this.errors.email =
                    "Bitte geben Sie eine valide E-Mail-Addresse an.";
                return false;
            }

            if (this.user.password === "") {
                this.errors.password = "Bitte geben Sie ein Passwort ein.";
                return false;
            }

            return true;
        }
    },
    // ============================
    // BEFORE MOUNT
    // ============================
    beforeMount() {
        if (!this.auth.loading && Object.keys(this.auth.user).length !== 0) {
            this.$router.push({ name: "Dashboard" });
        }
    },
    // ============================
    // BEFORE UPDATE
    // ============================
    beforeUpdate() {
        if (!this.auth.loading && Object.keys(this.auth.user).length !== 0) {
            this.$router.push({ name: "Dashboard" });
        }
    }
};
</script>

<style lang="scss" scoped>
.row {
    height: 80vh;
}

.text-muted {
    margin-top: 1rem;
}
</style>
