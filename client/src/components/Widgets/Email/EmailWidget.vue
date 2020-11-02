<template>
    <!-- 
        The widget for emails. It's a form where the user can
        input all the necessary information about the mail that shall be send.\
        This includes:
        - receiver
        - Cc
        - subject
        - Body
    -->
    <div class="widget email-widget--wrapper">
        <form>
            <!-- RECEIVER -->
            <div class="form-group">
                <label for="exampleInputEmail1">Email Adresse Empfänger</label>
                <input
                    type="email"
                    class="form-control-sm form-control"
                    placeholder="E-Mail Adresse"
                    @input="updateValue()"
                    :value="value.receiver"
                    ref="receiver"
                />
            </div>
            <!-- Cc -->
            <div class="form-group">
                <label for="exampleInputEmail1">Cc</label>
                <input
                    type="email"
                    class="form-control-sm form-control"
                    placeholder="E-Mail Adresse Cc"
                    @input="updateValue()"
                    :value="value.cc"
                    ref="cc"
                />
            </div>
            <!-- SUBJECT -->
            <div class="form-group">
                <label for="exampleInputEmail1">Betreff</label>
                <input
                    type="text"
                    class="form-control-sm form-control"
                    placeholder="Betreff der E-Mail"
                    @input="updateValue()"
                    :value="value.subject"
                    ref="subject"
                />
            </div>

            <!-- TEXT -->
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Text</label>
                <div class="email-widget--body">
                    <textarea
                        @input="updateValue()"
                        :value="value.body"
                        class="form-control-sm form-control email-widget--body"
                        rows="3"
                        ref="body"
                    >
                    </textarea>
                </div>
            </div>
            <RelativeModal width="300px">
                <template #button>
                    <div class="btn btn-link" @click="clickTokenButton">
                        <span><i class="fas fa-plus"></i></span>
                        Token hinzufügen
                    </div>
                </template>
                <template #modalContent>
                    <!-- MODAL CONTENT SLOT -->
                    <slot name="modalContent"></slot>
                </template>
            </RelativeModal>
            <span
                v-for="(token, index) in tokens"
                :key="index"
                class="badge badge-primary mr-2"
                @click="insertToken(index)"
                >{{ token.name }}</span
            >
        </form>

        <!-- TEST EMAIL -->
        <a
            class="btn btn-outline-secondary mt-3"
            :href="
                `mailto:${value.receiver}?cc=${value.cc}&subject=${value.subject}&body=${value.body}`
            "
        >
            <i class="fas fa-paper-plane"></i>
            Test senden
        </a>
    </div>
</template>
<script>
import RelativeModal from "./../../UI/Modals/RelativeModal";
export default {
    props: ["value", "tokens"],
    methods: {
        /**
         * Update the values of the input fields
         */
        updateValue() {
            this.$emit("input", {
                receiver: this.$refs.receiver.value,
                cc: this.$refs.cc.value,
                subject: this.$refs.subject.value,
                body: this.$refs.body.value,
                tokens: this.tokens
            });
        },
        /**
         * Handle click event of token button
         */
        clickTokenButton() {
            this.$emit("clickTokenButton");
        },
        /**
         * Insert token value into the body.
         * @param {string} index
         *   The index of the token in the tokens array.
         */
        insertToken(index) {
            // Get cursor position inside the body.
            const pos = this.$refs.body.selectionStart;
            if (!pos && pos !== 0) {
                return;
            }
            // Get the corresponding token.
            const token = this.tokens[index];
            if (!token) {
                return;
            }
            // Insert the value of the token into the body's value.
            this.value.body =
                this.value.body.slice(0, pos) +
                token.value +
                this.value.body.slice(pos);
        }
    },

    components: {
        RelativeModal
    }
};
</script>
