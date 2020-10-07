<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <h1>Neuer Tag</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
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
                            v-model="form.backgroundColor"
                        />
                        <div class="invalid-feedback">
                            {{ formErrors.backgroundColor }}
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
                        v-model="form.textColor"
                    />
                    <div class="invalid-feedback">
                        {{ formErrors.textColor }}
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
                        :background="form.backgroundColor"
                        :text="form.textColor"
                    ></Tag>
                </div>

                <!-- SUBMIT -->
                <button class="btn btn-primary">
                    Speichern
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "./../../components/FullPageSpinner.vue";
import Tag from "./../../components/Tag.vue";
export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            form: {
                title: "",
                backgroundColor: "#0f0f0f",
                textColor: "#f0f0f0"
            },
            formErrors: {
                title: "",
                backgroundColor: "",
                textColor: ""
            }
        };
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
</style>
