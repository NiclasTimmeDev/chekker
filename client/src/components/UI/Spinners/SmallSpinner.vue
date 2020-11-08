<template>
    <div class="spinner-wrapper">
        <div class="spinner-border text-accent" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.spinner-wrapper {
    width: 100%;
    height: 100%;
    /* min-height: 60px;
    min-width: 60px; */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 100;
    background-color: transparent;
}
.spinner-border {
    z-index: 101;
}
</style>
