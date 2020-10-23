<template>
    <div class="with-management-sidebar">
        <!-- MANAGEMENT SIDEBAR -->
        <management-sidebar
            ><template #content>
                <button class="btn btn-primary mb-3">Speichern</button>
                <h2 class="mb-3">Teamname</h2>
                <!-- MODAL ACTIONS -->
                <div class="row-full">
                    <div class="col col-lg-6">
                        <RelativeModal>
                            <template #button>
                                <TransparentWithIconButton
                                    :icon="'fas fa-lock'"
                                    text="Rechte"
                                />
                            </template>
                            <template #modalContent>
                                <div>
                                    wegwegew wegwegweg ewgweg we wegwegew
                                    wegwegweg ewgweg we wegwegew wegwegweg
                                    ewgweg we wegwegew wegwegweg ewgweg we
                                    wegwegew wegwegweg ewgweg we wegwegew
                                    wegwegweg ewgweg we wegwegew wegwegweg
                                    ewgweg we
                                </div>
                            </template>
                        </RelativeModal>
                    </div>
                    <div class="col col-lg-6">
                        <RelativeModal>
                            <template #button>
                                <TransparentWithIconButton
                                    :icon="'fas fa-clock'"
                                    text="Wiederholung"
                                />
                            </template>
                            <template #modalContent>
                                <div>
                                    wegwegew wegwegweg ewgweg we wegwegew
                                    wegwegweg ewgweg we wegwegew wegwegweg
                                    ewgweg we wegwegew wegwegweg ewgweg we
                                    wegwegew wegwegweg ewgweg we wegwegew
                                    wegwegweg ewgweg we wegwegew wegwegweg
                                    ewgweg we
                                </div>
                            </template>
                        </RelativeModal>
                    </div>
                </div>

                <div class="draggable">
                    <draggable v-model="tasks" ghost-class="draggable--ghost">
                        <transition-group>
                            <!-- ONE CARD FOR EVERY TASK -->
                            <ManagementCard
                                v-for="(task, index) in tasks"
                                :key="index"
                                @onClick="changeCurrentTask(task.id)"
                            >
                                <template #input>
                                    <input
                                        class="input-full"
                                        type="text"
                                        v-model="task.label"
                                    />
                                </template>
                            </ManagementCard>
                        </transition-group>
                    </draggable>
                </div>

                <button class="btn btn-link" @click="addTask">
                    Neuer Task
                </button></template
            ></management-sidebar
        >
        <div class="with-sidebar-content">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <h1>{{ tasks[currentTask].label }}</h1>
                </div>
            </div>
            <!-- CANVAS -->
            <Canvas>
                <template #content>
                    <p
                        class="text-center"
                        v-if="tasks[currentTask].steps.length === 0"
                    >
                        Ziehen Sie ein Widget von der rechten Seite des
                        Bildschirms hier her.
                    </p>
                    <draggable
                        class="drag-area"
                        :list="tasks[currentTask].steps"
                        group="widgets"
                    >
                        <div
                            class="form-group"
                            v-for="(step, index) in tasks[currentTask].steps"
                            :key="index"
                        >
                            <!-- TEXT WIDGET -->
                            <div
                                class="editor inline-editor"
                                v-if="step.widgetType === 'text'"
                            >
                                <ckeditor
                                    v-model="step.value"
                                    :config="editorConfig"
                                    :editor="editor"
                                ></ckeditor>
                            </div>

                            <!-- IMAGE WIDGET -->
                            <div
                                class="custom-file"
                                v-if="step.widgetType === 'image'"
                            >
                                <input
                                    type="file"
                                    accept="image/*"
                                    @change="changeImage($event, index)"
                                    :id="index + 'file'"
                                    :name="index + 'file'"
                                    class="custom-file-input"
                                />
                                <label
                                    class="custom-file-label"
                                    :for="index + 'file'"
                                >
                                    <template v-if="step.value">
                                        Bild ändern..
                                    </template>
                                    <template v-else>
                                        Bild wählen...
                                    </template>
                                </label>
                            </div>
                        </div>
                    </draggable>
                </template>
            </Canvas>
        </div>
        <!-- CONTROL SIDEBAR -->
        <ControlSidebar>
            <template v-slot:content>
                <div>Einfügen</div>
                <div class="draggable">
                    <draggable
                        :list="clonableWidgets"
                        ghost-class="draggable--ghost"
                        :clone="clone"
                        :group="{ name: 'widgets', pull: 'clone', put: false }"
                        :sort="false"
                    >
                        <transition-group>
                            <!-- ONE CARD FOR EVERY TASK -->
                            <clonable-widget
                                v-for="(widget, index) in clonableWidgets"
                                :key="index"
                                :icon="widget.icon"
                                :text="widget.label"
                            />
                        </transition-group>
                    </draggable>
                </div>
            </template>
        </ControlSidebar>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "./../../components/UI/Spinners/FullPageSpinner.vue";
import Tag from "./../../components/Tag";
import Modal from "./../../components/UI/Modal.vue";
import ManagementSidebar from "./../../components/ManagementSidebar/ManagementSidebar.vue";
import ControlSidebar from "./../../components/UI/ControlSidebar/ControlSidebar.vue";
import ManagementCard from "./../../components/ManagementSidebar/ManagementCard.vue";
import TransparentWithIconButton from "./../../components/UI/Buttons/TransparentWithIconButton.vue";
import RelativeModal from "./../../components/UI/Modals/RelativeModal.vue";
import draggable from "vuedraggable";
import Canvas from "./../../components/Process/Canvas.vue";
import ClonableWidget from "./../../components/Widgets/ClonableWidget.vue";
import CKEditor from "@ckeditor/ckeditor5-vue";
import InlineEditor from "@ckeditor/ckeditor5-build-inline";

export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            currentTask: 0,
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
            showTagsModal: false,
            tasks: [
                {
                    label: "Title",
                    widgetType: "text",
                    id: 0,
                    steps: []
                }
            ],
            clonableWidgets: [
                {
                    icon: "fas fa-text-width",
                    label: "Text",
                    type: "text",
                    id: 0
                },
                {
                    icon: "fas fa-list",
                    label: "Checkliste",
                    id: 1,
                    type: "checklist"
                },
                {
                    icon: "fas fa-image",
                    label: "Bild",
                    type: "image",
                    id: 2
                },
                {
                    icon: "fas fa-paper-plane",
                    label: "E-Mail",
                    type: "email",
                    id: 3
                }
            ],
            editorConfig: {
                // The configuration of the editor.
            },
            editor: InlineEditor
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
         * Add a new task to the list.
         * The id makes it idenfiable
         * so that the right data can be displayed
         * on the canvas.
         */
        addTask() {
            this.tasks.push({
                label: "",
                id: this.tasks.length,
                steps: []
            });
        },
        /**
         * Change the task the user is currently working on.
         *
         * @param {number} id
         *   The id of the current task.
         */
        changeCurrentTask(id) {
            this.currentTask = id;
        },
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
         * Clone a widget. This function is called
         * when a widget from the ControlSidebar is dragged.
         * It will return a new tasks object. This will be appended
         * to the tasks array.
         *
         * @param {object} id
         *   The id of the cloned widget.
         *
         * @return object
         *   The object that will be appended to the tasks array.
         */
        clone({ id }) {
            // Get the widget object that shall be cloned.
            const widget = this.clonableWidgets.filter(widget => {
                return widget.id == id;
            })[0];

            // Create default value depending on widget type
            let value = "";
            switch (widget.type) {
                case "text":
                    value = "<p>Schreiben Sie etwas...</p>";
                    break;
                case "image":
                    value = "";
                    break;
                default:
                    "";
            }
            // Create new object with same schema as the other tasks.
            return {
                id: this.tasks[this.currentTask].steps.length,
                label: widget.label,
                widgetType: widget.type,
                value: value
            };
        },
        /**
         * Show and hide modal to add tags.
         */
        toggleTagsModal() {
            this.getAllTags();
            this.showTagsModal = !this.showTagsModal;
        },
        /**
         * Append image form data.
         *
         * @param event
         *   The event object
         * @param index
         *   The index of the step of the current task.
         */
        changeImage(event, index) {
            let data = new FormData();
            data.append("file", event.target.files[0]);
            this.tasks[this.currentTask].steps[index].value = data;
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
        FullPageSpinner,
        Tag,
        Modal,
        ManagementSidebar,
        ControlSidebar,
        ManagementCard,
        draggable,
        TransparentWithIconButton,
        RelativeModal,
        Canvas,
        ClonableWidget,
        ckeditor: CKEditor.component
    }
};
</script>
