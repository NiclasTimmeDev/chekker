<template>
    <!-- 
    A Button that opens a popup on click.
    The modal will appear right beneath the button,
    which increases UX.
    -->
    <div class="pop-up--wrapper">
        <div class="pop-up--button" @click="toggleModal">
            <!-- BUTTON -->
            <slot name="button"></slot>
        </div>
        <div
            v-if="showModal"
            class="pop-up--modal p-2"
            :style="`width:${width}`"
        >
            <div class="pop-up--header">
                <h4>{{ title }}</h4>
                <span @click="toggleModal" class="close-icon">
                    <i class="fas fa-times"></i>
                </span>
            </div>

            <!-- MODAL CONTENT -->
            <div @click="toggleModal" class="pop-up--content">
                <slot name="body"></slot>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["width", "title"],
    data() {
        return {
            showModal: false
        };
    },
    methods: {
        toggleModal() {
            this.showModal = !this.showModal;
        }
    }
};
</script>
