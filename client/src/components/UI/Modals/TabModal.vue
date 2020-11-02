<template>
    <!-- A modal with two tabs that can be switched between.
    -->
    <div v-if="showModal">
        <modal
            :limitHeight="limitHeight"
            :showModal="showModal"
            :toggleModal="toggleModal"
        >
            <template v-slot:title>
                <!-- SLOT TITLE -->
                <slot name="title"></slot>
            </template>
            <template v-slot:body>
                <ul class="nav nav-tabs">
                    <li class="nav-item" @click="toggleBodies">
                        <span class="nav-link" :class="{ active: showBody1 }">{{
                            tab1Title
                        }}</span>
                    </li>
                    <li class="nav-item" @click="toggleBodies">
                        <span class="nav-link" :class="{ active: showBody2 }">{{
                            tab2Title
                        }}</span>
                    </li>
                </ul>
                <!-- SLOT body1 -->
                <template v-if="showBody1">
                    <slot name="body1"></slot>
                </template>

                <!-- SLOT body2 -->
                <template v-if="showBody2">
                    <slot name="body2"></slot>
                </template>
            </template>
            <template v-slot:footer>
                <!-- SLOT body -->
                <slot name="footer"></slot>
            </template>
        </modal>
    </div>
</template>
<script>
import Modal from "./Modal.vue";
export default {
    data() {
        return {
            showBody1: true,
            showBody2: false
        };
    },
    methods: {
        toggleBodies() {
            this.showBody1 = !this.showBody1;
            this.showBody2 = !this.showBody2;
        }
    },
    components: {
        Modal
    },
    props: ["showModal", "toggleModal", "limitHeight", "tab1Title", "tab2Title"]
};
</script>
<style lang="scss" scoped>
.nav-item {
    cursor: pointer;
}
</style>
