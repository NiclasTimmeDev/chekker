<template>
    <div class="with-management-sidebar">
        <!-- MANAGEMENT SIDEBAR -->
        <management-sidebar
            ><template #content>
                <button class="btn btn-primary mb-3">Speichern</button>
                <h4 class="mb-3">
                    <input
                        type="text"
                        v-model="processName"
                        class="input-full"
                    />
                </h4>
                <!-- MODAL ACTIONS -->
                <div class="row-full">
                    <div class="col col-lg-6">
                        <RelativeModal width="200px">
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
                        <RelativeModal width="200px">
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

                <!-- DRAG & DROP OF TASKS -->
                <div class="draggable">
                    <draggable
                        ghost-class="draggable--ghost"
                        :list="tasks"
                        group="tasks"
                    >
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

                <!-- ADD NEW TASK BUTTON -->
                <button class="btn btn-link" @click="addTask">
                    Neuer Task
                </button></template
            ></management-sidebar
        >
        <!-- LABEL OF CURRENT TASK -->
        <div class="with-sidebar-content">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <h1>{{ tasks[currentTask].label }}</h1>
                </div>
            </div>
            <!-- CANVAS -->
            <Canvas>
                <template #content>
                    <!-- CTA IF THERE IS NO WIDGET YET -->
                    <p
                        class="text-center"
                        v-if="tasks[currentTask].steps.length === 0"
                    >
                        Ziehen Sie ein Widget von der rechten Seite des
                        Bildschirms hier her.
                    </p>
                    <!-- WIDGETS -->
                    <draggable
                        class="drag-area"
                        :list="tasks[currentTask].steps"
                        group="widgets"
                    >
                        <div
                            class="form-group canvas--widget-wrapper py-3 px-2"
                            v-for="(step, index) in tasks[currentTask].steps"
                            :key="index"
                        >
                            <!-- WIDGET ACTIONS -->
                            <div class="canvas--widget-actions-wrapper p-2">
                                <!-- Clone -->
                                <span
                                    @click="cloneStep(index)"
                                    class="canvas--widget-actions-item"
                                >
                                    <i class="fas fa-clone mr-2"></i>
                                </span>
                                <!-- Delete -->
                                <span
                                    @click="deleteStep(index)"
                                    class="canvas--widget-actions-item"
                                >
                                    <i class="fas fa-trash "></i>
                                </span>
                            </div>
                            <div class="canvas--widget-item">
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

                                <!-- CHECKLIST WIDGET -->
                                <ChecklistWrapperWidget
                                    v-if="step.widgetType === 'checklist'"
                                    @click="addChecklistItem(index)"
                                >
                                    <template #content>
                                        <div
                                            v-for="(item, index) in step.value"
                                            :key="index"
                                            class="checklist-widget--item"
                                        >
                                            <ChecklistInputWidget
                                                v-model="step.value[index]"
                                            />
                                        </div>
                                    </template>
                                </ChecklistWrapperWidget>

                                <!-- EMAIL WIDGET -->
                                <EmailWidget
                                    v-if="step.widgetType === 'email'"
                                    v-model="step.value"
                                    @clickTokenButton="addToken(index)"
                                    :tokens="step.value.tokens"
                                >
                                    <template #modalContent>
                                        <div class="form-group">
                                            <label
                                                class="mt-3"
                                                :for="`token-${index}`"
                                                >Name des Tokens</label
                                            >
                                            <input
                                                class="form-control form-control-sm "
                                                type="text"
                                                placeholder="Name des Tokens..."
                                                :id="`token-${index}`"
                                                v-model="
                                                    step.value.tokens[
                                                        step.value.tokens
                                                            .length - 1
                                                    ].name
                                                "
                                                @input="
                                                    'input',
                                                        updateTokenValue(
                                                            index,
                                                            step.value.tokens
                                                                .length - 1
                                                        )
                                                "
                                            />
                                            <label
                                                class="mt-3"
                                                :for="`token-${index}`"
                                                >Platzhalter</label
                                            >
                                            <div>
                                                {{
                                                    step.value.tokens[
                                                        step.value.tokens
                                                            .length - 1
                                                    ].value
                                                }}
                                            </div>
                                        </div>
                                    </template>
                                </EmailWidget>
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
import ChecklistInputWidget from "./../../components/Widgets/Checklist/ChecklistInputWidget";
import ChecklistWrapperWidget from "./../../components/Widgets/Checklist/ChecklistWrapperWidget";
import EmailWidget from "./../../components/Widgets/Email/EmailWidget";
import TokenModal from "./../../components/Process/Email/TokenModal.vue";
export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            processName: "Name einfügen...",
            currentTask: 0,
            isTokenModalActive: false,
            tasks: [
                {
                    label: "Title",
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
                case "checklist":
                    value = ["", "", ""];
                    break;
                case "email":
                    value = {
                        receiver: "",
                        cc: "",
                        subject: "",
                        body: "",
                        tokens: []
                    };
                    break;
                default:
                    "";
            }
            // Create new object with same schema as the other tasks.
            return {
                id: this.tasks[this.currentTask].steps.length,
                label: widget.label,
                widgetID: widget.id,
                widgetType: widget.type,
                value: value
            };
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
        },
        /**
         * Attach a new checklist item to the checklist form
         * @param {string} index
         *   The index of the current step in the current task.
         */
        addChecklistItem(index) {
            this.tasks[this.currentTask].steps[index].value.push("");
        },
        /**
         * Attach a new token to the email form
         * @param {string} index
         *   The index of the current step in the current task.
         */
        addToken(index) {
            // Check if token modal is currently open. If so, do nothing.
            const task = this.tasks[this.currentTask].steps[index];
            if (this.isTokenModalActive) {
                this.isTokenModalActive = !this.isTokenModalActive;
                return;
            }

            /**
             * Check if its actually an email widget
             * and if tokens array exists.
             */
            if (task.widgetType !== "email" || !task.value.tokens) {
                this.isTokenModalActive = !this.isTokenModalActive;
                return;
            }

            // Add new item to tokens array.
            task.value.tokens.push({
                name: "",
                value: ""
            });
            this.isTokenModalActive = !this.isTokenModalActive;
        },
        /**
         * Sanitize the name of a token
         * and thereby create a placeholder string
         * that can then be referenced in the mail body.
         *
         * @param {string} taskIndex
         *   The index of the current step in the current Task.
         * @param tokenIndex
         *   The index of the current token.
         */
        updateTokenValue(taskIndex, tokenIndex) {
            const task = this.tasks[this.currentTask].steps[taskIndex];
            const token = this.tasks[this.currentTask].steps[taskIndex].value
                .tokens[tokenIndex];
            // Replace spaces with underscores.
            const nospaces = token.name.replace(" ", "_");
            // Convert to only lower case.
            const onlyLower = nospaces.toLowerCase();
            // Replace special characrters.
            const final = onlyLower.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "");
            // Replace value of token.
            token.value = `{{::${final}::}}`;
        },
        /**
         * Delete a step from the current task.
         *
         * @param {string} index
         *   The index of the step that should be deleted from the current task.
         */
        deleteStep(index) {
            const steps = this.tasks[this.currentTask].steps;
            steps.splice(index, 1);
        },
        cloneStep(index) {
            // Get all steps.
            const steps = this.tasks[this.currentTask].steps;

            // Get the ID of the corresponding clonable widget.
            const widgetID = steps[index].widgetID;

            // Create a clone.
            let clone = this.clone({ id: widgetID });

            // Get the value of the old widget
            const value = steps[index].value;

            // Check the type of the value and copy the value appropriately.
            if (value.isArray) {
                clone.value = [...value];
            } else if (typeof value === "object") {
                clone.value = { ...value };
            } else {
                clone.value = value;
            }
            steps.splice(index + 1, 0, clone);
        }
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
        ckeditor: CKEditor.component,
        ChecklistWrapperWidget,
        ChecklistInputWidget,
        TokenModal,
        EmailWidget
    }
};
</script>
