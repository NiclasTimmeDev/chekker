<template>
    <!--
    A second-level sidebar, usually displayed on the lwft side nwxt to the admin panel.
    It helps to visually separate the the form and make more use of the available space.

    For this component to work correctly, the parent component must have a wrapper div with the class
    'with-management-sidebar'. For more info see /scss/components/_managementSidebar.scss
    -->
    <div class="management-sidebar--wrapper">
        <div class="management-sidebar--content">
            <slot name="content">
                <!-- All the other stuff goes here. -->
            </slot>
        </div>
    </div>
</template>
<script>
export default {};
</script>
