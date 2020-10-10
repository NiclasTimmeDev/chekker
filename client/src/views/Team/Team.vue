<template>
    <div class="container-fluid">
        <div v-if="auth.loading || team.loading">
            <full-page-spinner></full-page-spinner>
        </div>
        <template v-else>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="icon"
                                ><i class="fas fa-exclamation text-accent"></i
                            ></span>
                            Name
                        </th>
                        <th scope="col">
                            <span class="icon"
                                ><i class="fas fa-question text-accent"></i
                            ></span>
                            Jobbeschreibung
                        </th>
                        <th scope="col">
                            <span class="icon"
                                ><i class="fas fa-envelope text-accent"></i
                            ></span>
                            E-Mail
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- LIST OF TEAM MEMBERS -->
                    <template v-if="team.members">
                        <tr v-for="member in team.members" :key="member.id">
                            <td>{{ member.name }}</td>
                            <!-- Only show job position if it exists -->
                            <td v-if="member.job_position">
                                {{ member.job_position }}
                            </td>
                            <td v-else>Noch keine Jobbeschreibung vorhanden</td>
                            <td>{{ member.email }}</td>
                        </tr>
                    </template>
                    <template v-else>
                        <div>
                            Es gibt noch keine Mitglieder
                        </div>
                    </template>
                </tbody>
            </table>
            <router-link to="/team/members/new" class="btn btn-primary">
                <i class="fas fa-plus"></i> Neues Teammitglied hinzufügen
            </router-link>
        </template>
    </div>
</template>
<script>
import { mapGetters, mapState, mapActions } from "vuex";
import FullPageSpinner from "../../components/FullPageSpinner";
export default {
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["team", "auth"])
    },
    // ============================
    // METHODS
    // ============================
    methods: {
        ...mapActions(["loadTeamMembers"])
    },
    // ============================
    // COMPONENTS
    // ============================
    components: {
        "full-page-spinner": FullPageSpinner
    },
    // ============================
    // berforeMount
    // ============================
    beforeMount() {
        this.loadTeamMembers();
    }
};
</script>
<style lang="scss" scoped>
.table-wrapper {
    .icon {
        margin-right: 5px;
    }
}
</style>
