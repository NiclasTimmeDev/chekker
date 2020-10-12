<template>
    <full-page-spinner v-if="process.loading"></full-page-spinner>
    <div v-else class="table-responsive">
        <table class="table table-hover">
            <!-- TABLE HEAD -->
            <thead>
                <tr>
                    <th scope="col" class="large-col">
                        <span class="icon"
                            ><i
                                class="fas fa-exclamation text-accent"
                            ></i></span
                        >Titel
                    </th>
                    <th scope="col" class="large-col">
                        <span class="icon">
                            <i class="fas fa-question text-accent"></i>
                        </span>
                        Beschreibung
                    </th>
                    <th scope="col" class="small-col">
                        <span class="icon">
                            <i class="fas fa-hashtag text-accent"></i>
                        </span>
                        Tasks
                    </th>
                    <th scope="col" class="medium-col">
                        <span class="icon"
                            ><i class="fas fa-users text-accent"></i></span
                        >Personen
                    </th>
                    <th scope="col" class="medium-col">
                        <span class="icon">
                            <i class="fas fa-clock text-accent"></i>
                        </span>
                        Automatisch?
                    </th>
                    <th scope="col" class="medium-col">
                        <span class="icon">
                            <i class="fas fa-code-branch text-accent"></i>
                        </span>
                        Bereich
                    </th>
                    <th scope="col" class="medium-col">
                        <span class="icon">
                            <i class="fas fa-tags text-accent"></i>
                        </span>
                        Tasks
                    </th>
                </tr>
            </thead>
            <!-- TABLE BODY -->
            <tbody>
                <tr
                    v-for="process in process.processesOfUser"
                    :key="process.id"
                >
                    <th scope="row" class="large-col">
                        <router-link :to="'/process/' + process.id">{{
                            process.title
                        }}</router-link>
                    </th>
                    <td class="large-col">
                        {{ process.description }}
                    </td>
                    <td>21</td>
                    <td>Personen</td>
                    <td>
                        Widerholunwe gwegewhgawerha erhaerhaerhawer gtfawerkjf
                        gweluifweggsmuste
                    </td>

                    <td>Bereich</td>
                    <td>
                        <Tag
                            v-for="tag in process.tags"
                            :key="tag.id"
                            :title="tag.title"
                            :background="tag.background"
                            :text="tag.text"
                        ></Tag>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "../../components/UI/Spinners/FullPageSpinner.vue";
import Tag from "./../../components/Tag";
export default {
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["process", "auth"])
    },
    // ============================
    // METHODS
    // ============================
    methods: {
        ...mapActions(["getAllProcessesOfUser"])
    },
    // ============================
    // berforeMount
    // ============================
    beforeMount() {
        console.log("btn-outline-da");
        this.getAllProcessesOfUser();
    },
    // ============================
    // COMPONENTS
    // ============================
    components: {
        "full-page-spinner": FullPageSpinner,
        Tag: Tag
    }
};
</script>
