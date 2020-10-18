<template>
    <div class="with-management-sidebar">
        <div class="with-sidebar-content">
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

                        <!-- Involved persons -->
                        <div class="form-group involved-persons">
                            <label for="name">Involvierte Personen</label>
                            <p class="text-muted">
                                Fügen Sie Personen hinzu, die in diesen Task
                                involviert sind. Sie können beschreiben, was
                                Rolle der Person ist und E-Mail Vorlagen
                                erstellen, die automatisch versendet werden,
                                sobald der Task ansteht.
                            </p>
                            <button
                                class="btn btn-outline-secondary btn-sm btn-inline"
                                @click.prevent="
                                    toggleTagModal();
                                    showTeamMembers();
                                "
                            >
                                Person Hinzufügen
                            </button>

                            <div class="form-check form-check-inline ml-3">
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
                            <template v-slot:title
                                >Personen hinzufügen</template
                            >
                            <template v-slot:body1>
                                <small-spinner
                                    v-if="team.loading"
                                ></small-spinner>
                                <ul v-else class="list-group list-group-flush">
                                    <li
                                        v-for="member in team.members"
                                        :key="member.id"
                                        class="list-group-item"
                                    >
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            :value="member"
                                            :id="member.id"
                                            v-model="form.people"
                                        />
                                        <span>{{ member.name }}</span>
                                    </li>
                                </ul>
                            </template>
                            <template v-slot:body2>
                                <small-spinner
                                    v-if="team.externalPersons.loading"
                                ></small-spinner>
                                <ul v-else class="list-group list-group-flush">
                                    <li
                                        v-for="person in team.externalPersons
                                            .persons"
                                        :key="person.id"
                                        class="list-group-item"
                                    >
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            :value="person"
                                            :id="person.id"
                                            v-model="form.externalPersons"
                                        />
                                        <span
                                            >{{ person.name }} ({{
                                                person.organization
                                            }})</span
                                        >
                                    </li>
                                </ul>
                            </template>
                        </TabModal>
                        <!-- SHOW SELECTED INVOLVED PERSONS -->
                        <Accordion>
                            <template v-slot:accordionItems>
                                <AccordionItem
                                    v-for="person in form.people"
                                    :key="person.id"
                                >
                                    <template v-slot:title>
                                        {{ person.name }}
                                    </template>
                                    <template v-slot:content>
                                        <div>
                                            <AccordionItem>
                                                <template v-slot:title>
                                                    Beschreibung
                                                </template>
                                                <template v-slot:content>
                                                    <p class="text-muted">
                                                        Beschreiben Sie die
                                                        Rolle, die diese Person
                                                        spielt.
                                                    </p>
                                                    <div class="form-group">
                                                        <textarea
                                                            class="form-control"
                                                            rows="3"
                                                            name="description"
                                                            v-model="
                                                                person.description
                                                            "
                                                        ></textarea>
                                                    </div>
                                                </template>
                                            </AccordionItem>
                                            <AccordionItem>
                                                <template v-slot:title>
                                                    E-Mail Vorlage
                                                </template>
                                                <template v-slot:content>
                                                    <p class="text-muted">
                                                        Sie schreiben die Mail
                                                        ein Mal. Wir versenden
                                                        Sie immer, sobald der
                                                        Task ansteht.
                                                    </p>
                                                    <div class="form-group">
                                                        <textarea
                                                            class="form-control"
                                                            rows="3"
                                                            name="description"
                                                            v-model="
                                                                person.emailTemplate
                                                            "
                                                        ></textarea>
                                                    </div>
                                                    <button
                                                        class="btn btn-outline-primary btn-sm"
                                                    >
                                                        Platzhalter hinzufügen
                                                    </button>
                                                </template>
                                            </AccordionItem>
                                        </div>
                                    </template>
                                </AccordionItem>
                            </template>
                        </Accordion>
                        <!-- SEND EMAIL BOOLEAN DECSISION -->
                        <div class="form-group"></div>
                        <!-- EMAIL TEMPLATE -->
                        <div v-if="form.sendEmail" class="form-group">
                            <label for="description">E-Mail Template</label>
                            <textarea
                                class="form-control"
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
        <management-sidebar
            ><template v-slot:content>
                <div>
                    Hello
                </div>
            </template></management-sidebar
        >
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "./../../components/UI/Spinners/FullPageSpinner.vue";
import SmallSpinner from "./../../components/UI/Spinners/SmallSpinner.vue";
import TipTapBasic from "./../../components/RichTextEditor/TipTapBasic.vue";
import TabModal from "./../../components/UI/TabModal";
import ManagementSidebar from "./../../components/ManagementSidebar/ManagementSidebar.vue";
import Accordion from "./../../components/UI/Accordion/Accordion";
import AccordionItem from "./../../components/UI/Accordion/AccordionItem";
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
                externalPersons: [],
                sendEmail: false,
                emailTemplate: ""
            },
            formErrors: {
                title: "",
                description: "",
                people: [],
                externalPersons: "",
                sendEmail: false,
                emailTemplate: ""
            },
            addPeople: false
        };
    },
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["team"])
    },
    methods: {
        ...mapActions([
            "loadTeamMembers",
            "loadAllExternalPersons",
            "createExternalPerson"
        ]),
        toggleTagModal() {
            this.addPeople = !this.addPeople;
        },
        /**
         * Load all team members and external persons if necessary.
         */
        showTeamMembers() {
            if (this.team.members.length === 0) {
                this.loadTeamMembers();
            }
            if (this.team.externalPersons.persons.length === 0) {
                this.loadAllExternalPersons();
            }
        }
    },
    // ============================
    // COMPONENTS
    // ============================
    components: {
        FullPageSpinner,
        TipTapBasic,
        TabModal,
        SmallSpinner,
        ManagementSidebar,
        Accordion,
        AccordionItem
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

.involved-persons {
    label {
        display: block;
    }
}
</style>
