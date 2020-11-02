<template>
    <!--
    The icon that is shown is the sidebar.
    It's a round circle with with a font awesome icon inside
    that accepts a click event.
    -->
    <div
        class="sidebar-icon mb-4 mx-auto"
        :class="{ 'button-icon': isButtonIcon }"
    >
        <!-- ICON -->
        <i :class="icon"></i>
    </div>
</template>
<script>
export default {
    props: ["click", "icon", "isButtonIcon"]
};
</script>
