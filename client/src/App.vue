<template>
  <div>
    <app-navbar></app-navbar>
    <router-view></router-view>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Navbar from "./components/shared/Navbar";

export default {
  components: {
    "app-navbar": Navbar
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
</style>
