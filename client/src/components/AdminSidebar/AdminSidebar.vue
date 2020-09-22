<template>
  <nav id="admin-sidebar" class="sidebar bg-darkest">
    <div class="sidebar-content p-3">
      <!-- HEADER -->
      <h1>Chekker.io</h1>
      <!-- ACTION BUTTON -->
      <button class="btn btn-primary btn-block mx-auto">
        <i class="fas fa-plus"></i> Neu
      </button>
      <!-- PROCESSES -->
      <admin-control :showChevron="true">
        <template v-slot:icon>
          <i class="fas fa-check"></i>
        </template>
        <template v-slot:title>
          Prozesse
        </template>
        <template v-slot:content>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos aliquam
          saepe ratione adipisci! At recusandae quae voluptas iure distinctio!
          At alias quis enim nesciunt quas beatae laborum earum, optio sed!
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
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos aliquam
          saepe ratione adipisci! At recusandae quae voluptas iure distinctio!
          At alias quis enim nesciunt quas beatae laborum earum, optio sed!
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
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos aliquam
          saepe ratione adipisci! At recusandae quae voluptas iure distinctio!
          At alias quis enim nesciunt quas beatae laborum earum, optio sed!
        </template>
      </admin-control>

      <!-- SETTINGS -->
      <admin-control>
        <template v-slot:icon>
          <i class="fas fa-cog"></i>
        </template>
        <template v-slot:title>
          Einstellungen
        </template>
        <template v-slot:content>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos aliquam
          saepe ratione adipisci! At recusandae quae voluptas iure distinctio!
          At alias quis enim nesciunt quas beatae laborum earum, optio sed!
        </template>
      </admin-control>
    </div>
  </nav>
</template>
<script>
import AdminControl from "./AdminControl.vue";
export default {
  components: {
    "admin-control": AdminControl
  }
};
</script>

<style lang="scss" scoped>
.sidebar {
  width: 3 0vw;
  height: 100vh;
  position: fixed;
  overflow: scroll;
  left: 0;
  top: 0;
  z-index: 101;

  .sidebar-content {
    width: 100%;
    height: 100%;

    .btn {
      margin-bottom: 30px;
    }
  }

  * {
    color: white;
  }
}
</style>
