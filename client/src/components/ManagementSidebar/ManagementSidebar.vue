<template>
    <!--
    A sidebar, usually displayed on the right side of a form, e.g., a process or task.
    It helps to visually separate the the form and make more use of the available space.

    For this component to work correctly, the parent component must have a wrapper div with the class
    'with-management-sidebar'. For more info see /scss/_managementSidebar.scss
    -->
    <div class="management-sidebar">
        <slot name="content">
            <!-- All the other stuff goes here. -->
        </slot>
    </div>
</template>
<script>
export default {};
</script>
