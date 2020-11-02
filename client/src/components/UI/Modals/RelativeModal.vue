<template>
    <!-- 
    A Button that opens a modal on click.
    The modal will appear right beneath the button,
    which increases UX.
    The modal has no background overlay as normal modals do
    -->
    <div class="relative-modal--wrapper">
        <div class="relative-modal--button" @click="toggleModal">
            <!-- BUTTON -->
            <slot name="button"></slot>
        </div>
        <div
            v-if="showModal"
            class="relative-modal--modal p-2"
            :style="`width:${width}`"
        >
            <span @click="toggleModal" class="close-icon">
                <i class="fas fa-times"></i>
            </span>
            <!-- MODAL CONTENT -->
            <div class="relative-modal--content">
                <slot name="modalContent"></slot>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["width"],
    data() {
        return {
            showModal: false
        };
    },
    methods: {
        toggleModal() {
            console.log("check");
            this.showModal = !this.showModal;
        }
    }
};
</script>
