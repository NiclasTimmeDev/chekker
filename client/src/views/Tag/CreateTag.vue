<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <h1>Neuer Tag</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <!-- ALERT MESSAGE -->
                <template v-if="tag.error">
                    <div class="alert alert-danger" role="alert">
                        {{ tag.error }}
                    </div>
                </template>
                <form>
                    <!-- TITLE -->
                    <div class="form-group">
                        <label for="name">Titel</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="z.B. Finanzen"
                            id="title"
                            name="title"
                            v-model="form.title"
                        />
                        <div class="invalid-feedback">
                            {{ formErrors.title }}
                        </div>
                    </div>
                    <!-- BACKGROUND-COLOR -->
                    <div class="form-group">
                        <label for="color-picker">Hintergrundfarbe</label>
                        <input
                            type="color"
                            class="form-control form-control-color"
                            id="color-picker"
                            name="color"
                            v-model="form.background"
                        />
                        <div class="invalid-feedback">
                            {{ formErrors.background }}
                        </div>
                    </div>
                </form>
                <!-- TEXT-COLOR -->
                <div class="form-group">
                    <label for="color-picker">Hintergrundfarbe</label>
                    <input
                        type="color"
                        class="form-control form-control-color"
                        id="color-picker"
                        name="color"
                        v-model="form.text"
                    />
                    <div class="invalid-feedback">
                        {{ formErrors.text }}
                    </div>
                </div>
                <!-- PREVIEW -->
                <div class="tag-wrapper mb-4">
                    <label class="tag-header">
                        Vorschau
                    </label>
                    <div v-if="!form.title" class="text-muted">
                        Hier wird eine Vorschau Ihres neuen Tags erscheinen...
                    </div>
                    <Tag
                        v-else
                        :title="form.title"
                        :background="form.background"
                        :text="form.text"
                    ></Tag>
                </div>

                <!-- SUBMIT -->
                <button class="btn btn-primary" @click.prevent="createNewTag">
                    Speichern
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "./../../components/UI/Spinners/FullPageSpinner.vue";
import Tag from "./../../components/UI/Tags/Tag.vue";
export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            form: {
                title: "",
                background: "#0f0f0f",
                text: "#f0f0f0"
            },
            formErrors: {
                title: "",
                background: "",
                text: ""
            }
        };
    },
    // ============================
    // ACTIONS
    // ============================
    methods: {
        ...mapActions(["createTag"]),
        createNewTag() {
            if (this._validateForm()) {
                this.createTag(this.form);
            }
        },
        _validateForm() {
            // Title
            if (!this.form.title) {
                this.formErrors.title = "Bite geben Sie einen Titel ein.";
            } else {
                this.formErrors.title = "";
            }
            // Background Color
            if (!this.form.background) {
                this.formErrors.background =
                    "Bitte wählen Sie eine Hintergrundfarbe aus.";
            } else {
                this.formErrors.background = "";
            }
            // Text Color
            if (!this.form.text) {
                this.formErrors.text = "Bitte wählen Sie eine Textfarbe aus.";
            } else {
                this.formErrors.text = "";
            }

            // Return true if no errors.
            if (
                !this.formErrors.title &&
                !this.formErrors.background &&
                !this.formErrors.text
            ) {
                return true;
            }

            // Return false if errors.
            return false;
        }
    },

    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["tag", "auth"])
    },
    // ============================
    // COMPONTENTS
    // ============================
    components: {
        Tag
    }
};
</script>
<style lang="scss" scoped>
.form-control-color {
    max-width: 60px;
    cursor: pointer;
}

.tag-wrapper {
    display: block;

    label {
        display: block;
    }
}

.invalid-feedback {
    display: block;
}
</style>
