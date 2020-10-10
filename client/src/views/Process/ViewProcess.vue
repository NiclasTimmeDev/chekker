<template>
    <div class="row">
        <div class="col">
            <h1>{{ singleProcess.title }}</h1>
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
    // beforeMount
    // ============================
    beforeMount() {
        const id = this.$route.params.id;
        const processes = this.process.processesOfUser;
        if (processes.length === 0) {
            // await Fetch from DB.
        }

        /**
         * Check if process of interest is in store.
         * If so, quit callback.
         */
        const processInStore = processes.filter(p => {
            return p.id === +id;
        });
        if (processInStore.length !== 0) {
            console.log("okay");
            this.singleProcess = processInStore[0];
            return;
        }

        // Fetch single from database.
    }
};
</script>
