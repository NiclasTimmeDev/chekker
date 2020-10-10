<template>
    <select
        class="custom-select custom-select-sm mb-4"
        v-model="currentTeamID"
        @change="setCurrentTeam"
    >
        <template v-for="team in team.teams">
            <option :value="team.id" :key="team.id">{{ team.name }}</option>
        </template>
    </select>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import localStorageService from "./../../services/localStorageService";
import LocalStorageService from "./../../services/localStorageService";

export default {
    data() {
        return {
            currentTeamID: "",
            currentName: ""
        };
    },
    // ============================
    // METHODS
    // ============================
    methods: {
        getCurrentTeamID() {
            const id = localStorageService.get("current_team");
            if (!id) {
                this.currentTeamID = "";
                return;
            }

            this.currentTeamID = id;
        },
        mapCurrentIDtoName() {
            if (!this.currentTeamID) {
                return;
            }

            const team = this.team.teams.filter(
                team => team.id === parseInt(this.currentTeamID)
            );
            if (team.length !== 1) {
                return;
            }
            this.currentName = team[0].name;
        },
        setCurrentTeam(id) {
            LocalStorageService.add("current_team", this.currentTeamID, true);
        }
    },
    // ============================
    // COMPUTED
    // ============================
    computed: {
        ...mapState(["team"]),
        ...mapGetters(["getTeams"])
    },
    // ============================
    // WATCHERS
    // ============================
    watch: {
        getTeams() {
            console.log("getTeams");
            this.getCurrentTeamID();
            this.mapCurrentIDtoName();
        }
    },
    // ============================
    // beforeMount
    // ============================
    beforeMount() {
        this.currentTeamID = this.getCurrentTeamID();
    }
};
</script>

<style lang="scss" scoped></style>
