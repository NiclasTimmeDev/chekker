<template>
    <div>
        <full-page-spinner v-if="auth.loading"></full-page-spinner>
        <div class="flex-container">
            <div class="flex">
                <app-admin-sidebar></app-admin-sidebar>
            </div>
            <div class="body-flex">
                <div class="container-fluid">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import Navbar from "./components/shared/Navbar";
import AdminSidebar from "./components/Sidebar/AdminSidebar/AdminSidebar";
import FullPageSpinner from "./components/UI/Spinners/FullPageSpinner.vue";

export default {
    components: {
        "app-navbar": Navbar,
        "app-admin-sidebar": AdminSidebar,
        "full-page-spinner": FullPageSpinner
    },
    methods: {
        ...mapActions(["loadUser", "loadTeams"])
    },
    computed: {
        ...mapState(["auth"])
    },
    mounted() {
        this.loadUser();
        this.loadTeams();
    }
};
</script>

<style lang="scss">
@import "./scss/main.scss";

.flex-container {
    display: flex;
    justify-content: space-between;
}
.body-flex {
    flex: 1;
}
</style>
