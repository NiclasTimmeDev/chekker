<template>
  <div class="panel-accordion--wrapper mb-5">
    <h6 class="panel-accordion--header mb-1 " @click="toggle">
      <span><slot name="icon"></slot></span>
      <slot name="title"></slot>
      <span v-if="showChevron" class="chevron-icon"
        ><i
          class="fas fa-chevron-right"
          :class="[{ 'chevron-icon-active': active }]"
        ></i
      ></span>
    </h6>
    <div :class="[{ active: active }]" class="panel-accordion-body">
      <slot name="content"></slot>
    </div>
  </div>
</template>

<script>
export default {
  // ============================
  // DATA
  // ============================
  data() {
    return {
      active: false
    };
  },
  // ============================
  // PROPS
  // ============================
  props: ["showChevron"],
  // ============================
  // METHODS
  // ============================
  methods: {
    toggle() {
      console.log("toggle");
      this.active = !this.active;
    },
    toggleChevron() {}
  }
};
</script>

<style lang="scss">
.panel-accordion--wrapper {
  .panel-accordion--header {
    cursor: pointer;

    span {
      display: inline-block;
      margin-right: 1rem;
    }

    .chevron-icon {
      padding-left: 8px;
      transition: 0.2s ease-in-out;
    }

    .fas {
      transition: 0.2s ease-in-out;
    }

    .chevron-icon-active {
      transform: rotate(90deg);
      transition: 0.2s ease-in-out;
    }
  }
  .panel-accordion-body {
    max-height: 0px;
    overflow: hidden;
    transition: 0.2s ease-in-out;
    width: 100;
  }

  .active {
    max-height: 100%;
    transition: 0.2s ease-in-out;
  }
}
</style>
