<template>
    <span
        class="badge badge-pill badge-primary"
        :style="{ backgroundColor: background, color: text }"
        >{{ title }}</span
    >
</template>

<script>
export default {
    props: ["title", "background", "text"]
};
</script>
