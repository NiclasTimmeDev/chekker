<template>
    <div class="editor inline-editor">
        <ckeditor
            v-bind="data"
            :config="editorConfig"
            :editor="editor"
        ></ckeditor>
    </div>
</template>
<script>
import CKEditor from "@ckeditor/ckeditor5-vue";
import InlineEditor from "@ckeditor/ckeditor5-build-inline";
export default {
    data() {
        return {
            editorConfig: {
                // The configuration of the editor.
            },
            editor: InlineEditor
        };
    },
    props: ["data"],
    components: {
        ckeditor: CKEditor.component
    }
};
</script>
