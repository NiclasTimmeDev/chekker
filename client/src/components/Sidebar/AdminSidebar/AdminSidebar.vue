<template>
    <aside id="admin-sidebar" class="sidebar bg-darkest">
        <div class="sidebar-content pt-2 pb-3 px-1">
            <!-- ADD BUTTON -->
            <PopUp width="300px" title="Neu">
                <template #button>
                    <AdminSidebarIcon
                        :class="'fas fa-plus'"
                        :isButtonIcon="true"
                    ></AdminSidebarIcon>
                </template>
                <template #body>
                    <ul class="list-group">
                        <li class="list-group-item" @click="toggleNewTeamModal">
                            Team
                        </li>
                        <li
                            @click="toggleNewProcessModal"
                            class="list-group-item"
                        >
                            Prozess
                        </li>
                        <li
                            @click="toggleNewProcessModal"
                            class="list-group-item"
                        >
                            Tag
                        </li>
                    </ul>
                </template>
            </PopUp>

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

            <!-- NEW PROCESS MODAL -->
            <CreateProcessModal
                :show="showNewProcessModal"
                :toggle="toggleNewProcessModal"
            >
            </CreateProcessModal>

            <!-- NEW TEAM MODAL -->
            <CreateTeamModal
                :show="showNewTeamModal"
                :toggle="toggleNewTeamModal"
            >
            </CreateTeamModal>
        </div>
    </aside>
</template>
<script>
import Modal from "./../../UI/Modals/Modal";
import AdminSidebarIcon from "./AdminSidebarIcon";
import CreateProcessModal from "./../../Process/CreateProcessModal";
import CreateTeamModal from "./../../Team/CreateTeamModal";
import PopUp from "./../../UI/Popups/PopUp";
import Spinner from "./../../UI/Spinners/SmallSpinner";
export default {
    data() {
        return {
            showNewProcessModal: false,
            showNewTeamModal: false,
            sidebarBig: true
        };
    },
    components: {
        Modal,
        AdminSidebarIcon,
        CreateProcessModal,
        CreateTeamModal,
        PopUp,
        Spinner
    },
    methods: {
        toggleNewProcessModal() {
            this.showNewProcessModal = !this.showNewProcessModal;
        },
        toggleNewTeamModal() {
            this.showNewTeamModal = !this.showNewTeamModal;
        },
        toggleSidebarWidth() {
            this.sidebarBig = !this.sidebarBig;
        }
    }
};
</script>
