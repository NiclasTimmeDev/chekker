<template>
    <!-- A clonable widget in the control sidebar that can be dragged
        into the canvas to create a widget where
    -->
    <div class="clonable-widget p-1">
        <span class="clonable-widget--icon mr-1">
            <i :class="icon"></i>
        </span>
        <span class="clonable-widget--text">{{ text }}</span>
    </div>
</template>
<script>
export default {
    props: ["icon", "text"]
};
</script>
