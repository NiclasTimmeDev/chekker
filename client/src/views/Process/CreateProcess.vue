<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <h1>Neuer Prozess</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <form>
                    <!-- NAME -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Der Name des neuen Prozesses"
                            id="name"
                            name="name"
                            v-model="form.name"
                        />
                    </div>
                    <!-- DESCRIPTION -->
                    <div class="form-group">
                        <label for="description">Beschreibung</label>
                        <textarea
                            class="form-control"
                            id="description"
                            rows="3"
                            name="description"
                            v-model="form.description"
                        ></textarea>
                    </div>
                    <!-- PERMISSIONS -->
                    <label>Rechte</label>
                    <div class="text-muted mb-2">
                        Wer soll den Prozess sehen, starten und in das eigene
                        Prozess-Portfolio kopieren können?
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                id="only-me"
                                value="only-me"
                                name="permissions"
                                v-model="form.permission"
                            />
                            <label class="form-check-label" for="only-me"
                                >Nur ich</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                id="team"
                                value="team"
                                name="permissions"
                                v-model="form.permission"
                            />
                            <label class="form-check-label" for="team"
                                >Mein Team</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                id="Erweitert"
                                value="advanced"
                                name="permissions"
                                v-model="form.permission"
                            />
                            <label class="form-check-label" for="Erweitert"
                                >Erweitert</label
                            >
                        </div>
                    </div>
                    <!-- SHOW TEAM MEMBERS FOR ADVANCED SETTINGS -->
                    <div
                        class="form-group"
                        v-if="form.permission === 'advanced'"
                    >
                        <full-page-spinner
                            v-if="!team.membersLoaded"
                        ></full-page-spinner>
                        <template v-else>
                            <div class="form-group">
                                <label>
                                    Wählen Sie die Mitglieder aus, die Zugriff
                                    haben sollen.
                                </label>
                                <div
                                    class="form-check"
                                    v-for="member in teamMembers"
                                    :key="member.id"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        :value="member.id"
                                        :id="member.id"
                                        v-model="form.allowedMembers"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="member.id"
                                    >
                                        {{ member.name }}
                                    </label>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- SUBMIT -->
                    <button class="btn btn-primary mt-4">
                        Prozess erstellen
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "./../../components/FullPageSpinner.vue";
export default {
    // ============================
    // COMPUTED
    // ============================
    data() {
        return {
            form: {
                name: "",
                description: "",
                permission: "",
                allowedMembers: []
            },
            teamMembers: []
        };
    },
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["team", "auth"]),
        ...mapGetters(["getMembers"])
    },
    // ============================
    // WATCHERS
    // ============================
    watch: {
        /**
         * Only show team members that are not the
         * currently logged in user.
         */
        getMembers() {
            this.teamMembers = this.team.members.filter(member => {
                return this.auth.user.id !== member.id;
            });
        }
    },
    // ============================
    // METHODS
    // ============================
    methods: {
        ...mapActions(["loadTeamMembers"])
    },
    // ============================
    // beforeUpdate
    // ============================
    /**
     * If advanced permission settings are chosen
     * Show all members of the team
     */
    beforeUpdate() {
        // Don't do anything if permission is not set to advanced.
        if (this.form.permission !== "advanced") {
            return;
        }

        // Return if members are already in state.
        if (this.team.membersLoaded) {
            return;
        }

        this.loadTeamMembers();
    },
    // ============================
    // COMPONENTS
    // ============================
    components: {
        "full-page-spinner": FullPageSpinner
    }
};
</script>
