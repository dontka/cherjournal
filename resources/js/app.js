import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';

window.journalNoteEditor = function () {
    return {
        editor: null,
        init() {
            this.$nextTick(() => {
                const element = this.$refs.editor;
                const input = this.$refs.contentInput;

                if (!element || !input) {
                    return;
                }

                if (this.editor) {
                    this.editor.destroy();
                }

                this.editor = new Editor({
                    element,
                    extensions: [StarterKit],
                    content: input.value || '<p></p>',
                    editorProps: {
                        attributes: {
                            class: 'tiptap-editor min-h-[260px] px-4 py-4 text-sm leading-7 text-stone-800 focus:outline-none',
                        },
                    },
                    onUpdate: ({ editor }) => {
                        const html = editor.getHTML();
                        input.value = html;
                        input.dispatchEvent(new Event('input', { bubbles: true }));
                    },
                });
            });
        },
        toggleBold() {
            if (!this.editor) {
                return;
            }

            this.editor.chain().focus().toggleBold().run();
        },
        toggleItalic() {
            if (!this.editor) {
                return;
            }

            this.editor.chain().focus().toggleItalic().run();
        },
        toggleBulletList() {
            if (!this.editor) {
                return;
            }

            this.editor.chain().focus().toggleBulletList().run();
        },
        setHeading() {
            if (!this.editor) {
                return;
            }

            const isHeading = this.editor.isActive('heading', { level: 3 });
            this.editor.chain().focus().toggleHeading({ level: 3 }).run();
            if (isHeading) {
                this.editor.chain().focus().setParagraph().run();
            }
        },
        destroy() {
            if (this.editor) {
                this.editor.destroy();
                this.editor = null;
            }
        },
    };
};
