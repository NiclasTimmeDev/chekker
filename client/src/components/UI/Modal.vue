<template>
    <div v-if="showModal">
        <div class="modal" @click="toggleModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- SLOT TITLE -->
                        <slot name="title"></slot>
                    </div>
                    <div class="modal-body">
                        <!-- SLOT BODY -->
                        <p><slot name="body"></slot></p>
                    </div>
                    <!-- SLOT FOOTER -->
                    <slot name="footer"> </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["showModal", "toggleModal"]
};
</script>

<style lang="scss" scoped>
.modal {
    display: block;

    color: black !important;

    .modal-header {
        color: black;
        border-bottom: none;
        padding-bottom: 0;
    }
}
</style>
