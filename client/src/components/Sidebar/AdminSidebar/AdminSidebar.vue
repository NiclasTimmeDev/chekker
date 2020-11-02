<template>
    <aside id="admin-sidebar" class="sidebar bg-darkest">
        <div class="sidebar-content pt-2 pb-3 px-1">
            <!-- ADD BUTTON -->
            <div @click="toggleModal">
                <AdminSidebarIcon
                    :class="'fas fa-plus'"
                    :isButtonIcon="true"
                ></AdminSidebarIcon>
            </div>

            <!-- PROFILE -->
            <router-link to="/profile">
                <AdminSidebarIcon :class="'fas fa-user'"></AdminSidebarIcon>
            </router-link>

            <!-- CHECKMARK -->
            <router-link to="/process/view">
                <AdminSidebarIcon :class="'fas fa-check'"></AdminSidebarIcon>
            </router-link>

            <!-- MORE -->
            <router-link to="/process/view">
                <AdminSidebarIcon
                    :class="'fas fa-ellipsis-h'"
                ></AdminSidebarIcon>
            </router-link>

            <!-- MODAL -->
            <Modal :showModal="showModal" :toggleModal="toggleModal">
                <template v-slot:title>
                    <h4>Was möchten Sie erstellen?</h4>
                </template>
                <template v-slot:body>
                    <ul class="list-group">
                        <li class="list-group-item" @click="toggleModal">
                            <router-link to="/team/create" class="text-primary"
                                >Team</router-link
                            >
                        </li>
                        <li @click="toggleModal" class="list-group-item">
                            <router-link
                                to="/process/create"
                                class="text-primary"
                                >Prozess</router-link
                            >
                        </li>
                        <li @click="toggleModal" class="list-group-item">
                            <router-link to="/tag/create" class="text-primary"
                                >Tag</router-link
                            >
                        </li>
                    </ul>
                </template>
            </Modal>
        </div>
    </aside>
</template>
<script>
import Modal from "./../../UI/Modals/Modal";
import AdminSidebarIcon from "./AdminSidebarIcon";
export default {
    data() {
        return {
            showModal: false,
            sidebarBig: true
        };
    },
    components: {
        Modal,
        AdminSidebarIcon
    },
    methods: {
        toggleModal() {
            this.showModal = !this.showModal;
        },
        toggleSidebarWidth() {
            this.sidebarBig = !this.sidebarBig;
        }
    }
};
</script>
