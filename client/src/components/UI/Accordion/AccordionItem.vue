<template>
    <div class="card">
        <div @click="toggleShow" class="card-header" id="headingOne">
            <h5 class="mb-0">
                <slot name="title"></slot>
                <span class="chevron-icon"
                    ><i
                        class="fas fa-chevron-right"
                        :class="[{ 'chevron-icon-active': show }]"
                    ></i
                ></span>
            </h5>
        </div>

        <div
            id="collapseOne"
            class="collapse"
            :class="{ show: show }"
            aria-labelledby="headingOne"
            data-parent="#accordion"
        >
            <div class="card-body">
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
