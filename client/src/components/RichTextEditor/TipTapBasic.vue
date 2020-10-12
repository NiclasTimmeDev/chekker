<template>
    <div>
        <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
            <button
                :class="{ 'is-active': isActive.bold() }"
                @click.prevent="commands.bold"
            >
                Bold
            </button>
        </editor-menu-bar>
        <editor-content :editor="editor" />
    </div>
</template>

<script>
// Import the basic building blocks
import { Editor, EditorContent, EditorMenuBar } from "tiptap";
import { Heading, Bold } from "tiptap-extensions";

export default {
    components: {
        EditorContent,
        EditorMenuBar
    },
    data() {
        return {
            // Create an `Editor` instance with some default content. The editor is
            // then passed to the `EditorContent` component as a `prop`
            editor: new Editor({
                content: "Hi",
                extensions: [
                    // The editor will accept paragraphs and headline elements as part of its document schema.
                    new Heading(),
                    new Bold()
                ],
                onUpdate: ({ getHTML }) => {
                    // get new content on update
                    const newContent = getHTML();
                    console.log(newContent);
                }
            })
        };
    },
    beforeDestroy() {
        // Always destroy your editor instance when it's no longer needed
        this.editor.destroy();
    }
};
</script>
