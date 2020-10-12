<template>
    <aside id="admin-sidebar" class="sidebar bg-darkest">
        <div class="sidebar-content p-3">
            <!-- ACTION BUTTON -->
            <button
                class="btn btn-primary btn-block mx-auto"
                @click="toggleModal"
            >
                <i class="fas fa-plus"></i> Neu
            </button>

            <!-- SELECT TEAM -->
            <admin-team-display></admin-team-display>
            <!-- MODAL -->
            <create-new-modal :showModal="showModal" :toggleModal="toggleModal">
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
            </create-new-modal>

            <!-- PROCESSES -->
            <admin-control :showChevron="true">
                <template v-slot:icon>
                    <i class="fas fa-check"></i>
                </template>
                <template v-slot:title>
                    Prozesse
                </template>
                <template v-slot:content>
                    <ul>
                        <li class="mt-3 mb-3">
                            <router-link to="/process/view"
                                >Alle Prozesse</router-link
                            >
                        </li>
                    </ul>
                </template>
            </admin-control>

            <!-- TEAM -->
            <admin-control :showChevron="true">
                <template v-slot:icon>
                    <i class="fas fa-users"></i>
                </template>
                <template v-slot:title>
                    Team
                </template>
                <template v-slot:content>
                    <ul>
                        <li class="mt-3 mb-3">
                            <router-link to="/team">Teammitglieder</router-link>
                        </li>
                        <li class="mb-3">
                            <router-link to="/team/join"
                                >Team beitreten</router-link
                            >
                        </li>
                    </ul>
                </template>
            </admin-control>

            <!-- ACTIVE PROCESSES -->
            <admin-control :showChevron="true">
                <template v-slot:icon>
                    <i class="fas fa-clock"></i>
                </template>
                <template v-slot:title>
                    Aktive Prozesse
                </template>
                <template v-slot:content>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos
                    aliquam saepe ratione adipisci! At recusandae quae voluptas
                    iure distinctio! At alias quis enim nesciunt quas beatae
                    laborum earum, optio sed!
                </template>
            </admin-control>

            <!-- SETTINGS -->
            <admin-control>
                <template v-slot:icon>
                    <i class="fas fa-cog"></i>
                </template>
                <template v-slot:title>
                    <router-link :to="{ name: 'Settings' }"
                        >Einstellungen</router-link
                    >
                </template>
            </admin-control>
        </div>
    </aside>
</template>
<script>
import AdminControl from "./AdminControl.vue";
import Modal from "./../UI/Modal";
import AdminTeamDisplay from "./AdminTeamDisplay.vue";
export default {
    data() {
        return {
            showModal: false
        };
    },
    components: {
        "admin-control": AdminControl,
        "create-new-modal": Modal,
        "admin-team-display": AdminTeamDisplay
    },
    methods: {
        toggleModal() {
            this.showModal = !this.showModal;
        }
    }
};
</script>

<style lang="scss" scoped>
.sidebar {
    width: 20vw;
    max-width: 300px;
    height: 100vh;
    position: sticky;
    overflow: scroll;
    overflow-y: hidden;
    overflow-x: hidden;
    left: 0;
    top: 0;
    z-index: 101;

    .sidebar-content {
        width: 100%;
        height: 100%;

        .btn {
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none;

            li {
                a {
                    color: #fff;
                    font-size: 0.8rem;
                    &:hover {
                        text-decoration: none;
                    }
                }
            }
        }
    }

    .show-modal {
        display: block;
    }
}
</style>
