<template>
    <div class="with-management-sidebar">
        <management-sidebar
            ><template v-slot:content>
                <div>
                    Hello
                </div>
            </template></management-sidebar
        >
        <div class="with-sidebar-content">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <h1>Neuer Prozess</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <!-- ALERT MESSAGE -->
                    <template v-if="process.error">
                        <div class="alert alert-danger" role="alert">
                            {{ process.error }}
                        </div>
                    </template>
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
                            <div class="invalid-feedback">
                                {{ formErrors.name }}
                            </div>
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
                            <div class="invalid-feedback">
                                {{ formErrors.description }}
                            </div>
                        </div>
                        <!-- PERMISSIONS -->
                        <label>Rechte</label>
                        <div class="text-muted mb-2">
                            Wer soll den Prozess sehen, starten und in das
                            eigene Prozess-Portfolio kopieren können?
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
                                        Wählen Sie die Mitglieder aus, die
                                        Zugriff haben sollen.
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
                        <div class="invalid-feedback">
                            {{ formErrors.permission }}
                        </div>
                        <!-- TAGS -->
                        <div class="form-group">
                            <button
                                class="btn btn-outline-primary btn-sm"
                                @click.prevent="toggleTagsModal"
                            >
                                Tags hinzufügen
                            </button>
                            <!-- TAGS MODAL -->
                            <Modal
                                :showModal="showTagsModal"
                                :toggleModal="toggleTagsModal"
                                :limitHeight="true"
                            >
                                <template v-slot:title>
                                    <h4>Fügen Sie Tags hinzu</h4>
                                </template>
                                <template v-slot:body>
                                    <ul
                                        class="list-group list-group-flush"
                                        v-if="!tag.loading"
                                    >
                                        <li
                                            v-for="tag in tag.tags"
                                            :key="tag.id"
                                            class="list-group-item"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :value="tag.id"
                                                :id="tag.id"
                                                v-model="form.tags"
                                            />
                                            <Tag
                                                :title="tag.title"
                                                :background="tag.background"
                                                :text="tag.text"
                                            ></Tag>
                                        </li>
                                    </ul>
                                    <button
                                        @click="toggleTagsModal"
                                        class="btn btn-outline-primary btn-sm mt-3"
                                    >
                                        Fertig
                                    </button>
                                </template>
                            </Modal>
                        </div>

                        <!-- SUBMIT -->
                        <button
                            class="btn btn-primary mt-4"
                            @click.prevent="submit"
                        >
                            Prozess erstellen
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- CONTROL SIDEBAR -->
        <ControlSidebar>
            <template v-slot:content>
                <div>Einfügen</div>
            </template>
        </ControlSidebar>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "./../../components/UI/Spinners/FullPageSpinner.vue";
import Tag from "./../../components/Tag";
import Accordion from "./../../components/UI/Accordion/Accordion";
import AccordionItem from "./../../components/UI/Accordion/AccordionItem";
import Modal from "./../../components/UI/Modal.vue";
import ManagementSidebar from "./../../components/ManagementSidebar/ManagementSidebar.vue";
import ControlSidebar from "./../../components/UI/ControlSidebar/ControlSidebar.vue";
export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            form: {
                name: "",
                description: "",
                permission: "",
                allowedMembers: [],
                tags: []
            },
            formErrors: {
                name: "",
                description: "",
                permission: ""
            },
            teamMembers: [],
            newTag: {
                color: "",
                name: ""
            },
            showTagsModal: false
        };
    },
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["team", "auth", "tag", "process"]),
        ...mapGetters(["getMembers", "getTags"])
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
        ...mapActions(["loadTeamMembers", "createProcess", "getAllTags"]),
        /**
         * Submit the form.
         */
        async submit() {
            // Early return if inputs are invalid.
            this._validateInputs();
            if (
                this.formErrors.name ||
                this.formErrors.description ||
                this.formErrors.permission
            ) {
                return;
            }

            // Send req to api via vuex.
            const newProcess = await this.createProcess(this.form);

            // Navigate to new process overview page.
            this.$router.push({ path: `/process/${newProcess.id}` });
        },
        /**
         * Check if all required values of the form are set.
         */
        _validateInputs() {
            // No name.
            if (!this.form.name) {
                this.formErrors.name = "Bitte geben Sie einen Namen ein.";
            } else {
                this.formErrors.name = "";
            }

            // No description.
            if (!this.form.description) {
                this.formErrors.description =
                    "Bitte geben Sie eine Beschreibung ein.";
            } else {
                this.formErrors.description = "";
            }

            // No permission.
            if (!this.form.permission) {
                this.formErrors.permission =
                    "Bitte vergeben Sie Berechtigungen.";
            }

            // Advanced permission but no team members selected.
            if (
                this.form.permission === "advanced" &&
                this.form.allowedMembers.length === 0
            ) {
                this.formErrors.permission =
                    "Bitte vergeben Sie Berechtigungen für einzelne Teammitglieder.";
            }
            // Permission other than advanced.
            if (this.form.permission && this.form.permission !== "advanced") {
                this.formErrors.permission = "";
            }
            // Advanced permission but no members selected.
            if (
                this.form.permission === "advanced" &&
                this.form.allowedMembers.length !== 0
            ) {
                this.formErrors.permission = "";
            }
        },
        /**
         * Show and hide modal to add tags.
         */
        toggleTagsModal() {
            this.getAllTags();
            this.showTagsModal = !this.showTagsModal;
        }
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
            this.form.allowedMembers = [];
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
        "full-page-spinner": FullPageSpinner,
        Tag: Tag,
        Accordion: Accordion,
        AccordionItem: AccordionItem,
        Modal: Modal,
        ManagementSidebar: ManagementSidebar,
        ControlSidebar: ControlSidebar
    }
};
</script>

<style lang="scss" scoped>
.invalid-feedback {
    display: block;
}

.list-group-item {
    display: flex;
    align-items: center;
    input {
        margin-top: 0;
    }
}
</style>
