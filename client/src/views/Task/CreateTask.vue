<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <h2>Neuer Task</h2>
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
                            placeholder="z.B. 'Alle Zahlen überprüfen'"
                            id="title"
                            name="title"
                            v-model="form.title"
                        />
                        <div class="invalid-feedback">
                            {{ formErrors.title }}
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
                    <!-- <div class="form-group">
                        <label for="description">Beschreibung</label>
                        <TipTapBasic
                            :description="form.description"
                        ></TipTapBasic>
                    </div> -->

                    <!-- Involved persons -->
                    <div class="form-group">
                        <label for="name">Involvierte Personen</label>
                        <div class="inline-form-group">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Geben Sie einen Namen ein"
                                id="people"
                                name="people"
                                v-model="form.title"
                            />
                            <button
                                class="btn btn-outline-secondary btn-sm btn-inline ml-3"
                                @click.prevent="toggleTagModal"
                            >
                                Person erstellen
                            </button>
                        </div>

                        <div class="invalid-feedback">
                            {{ formErrors.title }}
                        </div>
                    </div>
                    <!-- ADD PEOPLE MODAL -->
                    <TabModal
                        :showModal="addPeople"
                        :toggleModal="toggleTagModal"
                        tab1Title="Intern"
                        tab2Title="Extern"
                    >
                    </TabModal>
                    <!-- SEND EMAIL BOOLEAN DECSISION -->
                    <div class="form-group">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="send-email"
                                value="1"
                                name="send-email"
                                v-model="form.sendEmail"
                            />
                            <label class="form-check-label" for="send-email"
                                >Automatische Email versenden</label
                            >
                        </div>
                    </div>
                    <!-- EMAIL TEMPLATE -->
                    <div v-if="form.sendEmail" class="form-group">
                        <label for="description">E-Mail Template</label>
                        <textarea
                            class="form-control"
                            id="email-template"
                            rows="3"
                            name="email-template"
                            v-model="form.emailTemplate"
                        ></textarea>
                        <div class="invalid-feedback">
                            {{ formErrors.emailTemplate }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "./../../components/FullPageSpinner.vue";
import TipTapBasic from "./../../components/RichTextEditor/TipTapBasic.vue";
import TabModal from "./../../components/UI/TabModal";
export default {
    // ============================
    // DATA
    // ============================
    data() {
        return {
            form: {
                title: "",
                description: "",
                people: [],
                sendEmail: false,
                emailTemplate: ""
            },
            formErrors: {
                title: "",
                description: "",
                people: [],
                sendEmail: false,
                emailTemplate: ""
            },
            addPeople: false
        };
    },
    methods: {
        toggleTagModal() {
            this.addPeople = !this.addPeople;
        }
    },
    // ============================
    // COMPONENTS
    // ============================
    components: {
        FullPageSpinner,
        TipTapBasic,
        TabModal
    }
};
</script>
<style lang="scss">
.inline-form-group {
    display: flex;
    justify-content: space-between;
    align-items: center;

    button {
        flex-shrink: 0;
    }
}
</style>
