<template>
    <div></div>
</template>

<script>
import { mapState } from "vuex";
import AdminSidebar from "./../components/Sidebar/AdminSidebar/AdminSidebar.vue";
export default {
    computed: {
        ...mapState({
            auth: state => state.auth
        })
    },
    components: {
        "admin-sidebar": AdminSidebar
    }
};
</script>
