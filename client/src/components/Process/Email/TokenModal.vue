<template>
    <PopUp>
        <template #button>
            <TransparentWithIconButton
                :icon="'fas fa-plus'"
                text="Token hinzufügen"
                @click="onClick"
            />
        </template>
        <template #modalContent>
            <div>
                <div class="form-group">
                    <input
                        type="text"
                        class="form-control-sm form-control"
                        placeholder="Name des Tokens..."
                        :value="value"
                        @input="$emit('input', $event.target.value)"
                    />
                </div>
            </div>
        </template>
    </PopUp>
</template>
<script>
import PopUp from "./../../UI/Popups/PopUp";
import TransparentWithIconButton from "./../../UI/Buttons/TransparentWithIconButton.vue";
export default {
    props: ["value"],
    components: {
        PopUp,
        TransparentWithIconButton
    },
    methods: {
        onClick() {
            this.$emit("click");
        }
    }
};
</script>
