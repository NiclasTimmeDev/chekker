<template>
    <div class="card mt-2">
        <div @click="toggleShow" class="card-header " id="headingOne">
            <div class="mb-0">
                <!-- TITLE SLOT -->
                <slot name="title"></slot>
                <span class="chevron-icon"
                    ><i
                        class="fas fa-chevron-right"
                        :class="[{ 'chevron-icon-active': show }]"
                    ></i
                ></span>
            </div>
        </div>

        <div
            class="collapse"
            :class="{ show: show }"
            aria-labelledby="headingOne"
            data-parent="#accordion"
        >
            <div class="card-body">
                <!-- CONTENT SLOT -->
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            show: false
        };
    },
    methods: {
        toggleShow() {
            this.show = !this.show;
        }
    }
};
</script>
