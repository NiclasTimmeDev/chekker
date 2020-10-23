<template>
    <div class="widget checklist-widget--item mb-1 ">
        <span><i class="fas fa-check-circle"></i></span>
        <input
            type="text"
            :value="value"
            @input="$emit('input', $event.target.value)"
            class="ml-1"
            placeholder="Schreiben Sie ein To-Do..."
        />
    </div>
</template>
<script>
export default {
    props: ["value"]
};
</script>
