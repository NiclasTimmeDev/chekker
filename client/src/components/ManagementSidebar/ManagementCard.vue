<template>
    <div class="card management-card mb-2">
        <span class="mr-2"><i class="fas fa-grip-lines"></i></span>
        <div><slot name="input"></slot></div>
    </div>
</template>
<script>
export default {
    props: ["title"]
};
</script>
