<template>
    <div class="widget checklist-widget--wrapper">
        <slot name="content"> </slot>
        <button class="btn btn-link" @click="onClick">
            Neuer Eintrag
        </button>
    </div>
</template>
<script>
export default {
    methods: {
        onClick() {
            this.$emit("click");
        }
    }
};
</script>
