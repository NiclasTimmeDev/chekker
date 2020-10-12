<template>
  <div class="overlay">
    <div class="spinner-border text-accent" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.overlay {
  width: 100vw;
  height: 100vh;
  position: absolute;
  top: 0;
  left: 0;
  background-color: lightgray;
  opacity: 0.5;
  z-index: 100;

  .spinner-border {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 101;
  }
}
</style>
