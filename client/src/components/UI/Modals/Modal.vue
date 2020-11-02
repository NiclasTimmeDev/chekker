<template>
    <div v-if="showModal">
        <div class="modal">
            <div class="modal-dialog" role="document">
                <div
                    class="modal-content"
                    :class="{ 'limit-height': limitHeight }"
                >
                    <!-- CLOSE ICON -->
                    <i class="fas fa-times" @click="toggleModal"></i>
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
    props: ["showModal", "toggleModal", "limitHeight"]
};
</script>
<style lang="scss"></style>
