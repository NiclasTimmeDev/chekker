<template>
    <button class="btn btn-transparent flex-button btn-sm">
        <span>
            <i :class="icon"></i>
        </span>
        <span class="ml-1">{{ text }}</span>
    </button>
</template>
<script>
export default {
    props: ["icon", "text"]
};
</script>
