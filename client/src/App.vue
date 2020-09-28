:`<template>
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
</template>

<script>
import { mapActions } from "vuex";
import Navbar from "./components/shared/Navbar";
import AdminSidebar from "./components/AdminSidebar/AdminSidebar";

export default {
    components: {
        "app-navbar": Navbar,
        "app-admin-sidebar": AdminSidebar
    },
    methods: {
        ...mapActions(["loadUser"])
    },
    mounted() {
        this.loadUser();
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
