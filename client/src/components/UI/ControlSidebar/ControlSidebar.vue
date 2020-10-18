<template>
    <!-- 
    A small sidebar, usually displayed on the right side of the screen.
    It's fixed and can be used to parent action items or things alike.
    It has toggle state.
    -->
    <div
        class="control-sidebar--wrapper"
        :class="{
            'control-sidebar--wrapper-hide': !show
        }"
    >
        <div
            class="control-sidebar p-1"
            :class="{
                'control-sidebar--show': show,
                'control-sidebar--hide': !show
            }"
        >
            <span @click="toggle" class="control-sidebar--toggle-icon">
                <i
                    class="fas fa-chevron-right"
                    :class="{
                        rotate: !show
                    }"
                ></i>
            </span>
            <!-- CONTENT -->
            <slot name="content"></slot>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            show: true
        };
    },
    methods: {
        toggle() {
            this.show = !this.show;
        }
    }
};
</script>
