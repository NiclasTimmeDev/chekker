<template>
    <!-- SPINNER -->
    <FullPageSpinner v-if="process.loading"></FullPageSpinner>
    <!-- CONTENT -->
    <div v-else>
        <!-- HEADER -->
        <div class="row justify-content-center">
            <div class="col-10 header-col">
                <h1>{{ process.singleProcess.title }}</h1>
                <span class="icon"><i class="fas fa-pen text-accent"></i></span>
                <button class="btn btn-primary ml-auto">Prozess starten</button>
            </div>
        </div>
        <!-- GENERAL INFO -->
        <div class="row justify-content-center">
            <!-- Tasks -->
            <div class="col-10">
                <p>
                    <span class="icon"
                        ><i class="fas fa-hashtag text-accent"></i></span
                    >16 Tasks
                </p>
            </div>
            <!-- Tasks -->
            <div class="col-10">
                <p>
                    <span class="icon"
                        ><i class="fas fa-user text-accent"></i></span
                    >4 involvierte Personen
                </p>
            </div>
            <!-- Recurrence Pattern -->
            <div class="col-10">
                <p>
                    <span class="icon"
                        ><i class="fas fa-clock text-accent"></i></span
                    >Jede Woche dienstags
                </p>
            </div>
            <!-- Tags -->
            <div class="col-10">
                <p class="tags">
                    <span class="icon"
                        ><i class="fas fa-tags text-accent"></i
                    ></span>
                    <template
                        v-if="
                            process.singleProcess.related_data.tags.length === 0
                        "
                    >
                        <span>Keine Tags vorhanden</span>
                    </template>
                    <Tag
                        v-else
                        v-for="tag in process.singleProcess.related_data.tags"
                        :key="tag.id"
                        :title="tag.title"
                        :background="tag.background"
                        :text="tag.text"
                    ></Tag>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "../../components/FullPageSpinner";
import Tag from "./../../components/Tag";
export default {
    data() {
        return {
            singleProcess: {}
        };
    },
    // ============================
    // beforeMount
    // ============================
    computed: {
        ...mapState(["process"])
    },
    // ============================
    // METHODS
    // ============================
    methods: {
        ...mapActions(["getSingleProcess"]),
        getProcess() {
            // Get process id from route param.
            const id = this.$route.params.id;

            // Check if singleProcess in state is the process of interest.
            const currentSingleProcess = this.process.singleProcess;
            if (+currentSingleProcess.id === +id) {
                return;
            }

            // Fetch single process from API.
            this.getSingleProcess(id);
        }
    },
    // ============================
    // beforeMount
    // ============================
    beforeMount() {
        this.getProcess();
    },
    components: { FullPageSpinner, Tag }
};
</script>
<style lang="scss" scoped>
.header-col {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 2rem;
    h1 {
        margin-right: 1rem;
        margin-bottom: 0;
    }

    i {
        font-size: 1rem;
    }
}

i {
    margin-right: 0.5rem;
}

.tags {
    .badge {
        margin-right: 0.5rem;
    }
}
</style>
