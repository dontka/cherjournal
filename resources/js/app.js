import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';

window.journalNoteEditor = function () {
    return {
        editor: null,
        init() {
            if (this.$el.dataset.journalEditorInitialized === 'true') {
                return;
            }

            this.$el.dataset.journalEditorInitialized = 'true';

            this.$nextTick(() => {
                const element = this.$refs.editor;
                const input = this.$refs.contentInput;

                if (!element || !input) {
                    return;
                }

                if (element.__journalEditor) {
                    element.__journalEditor.destroy();
                }

                const editor = new Editor({
                    element,
                    extensions: [StarterKit],
                    content: input.value || '<p></p>',
                    editorProps: {
                        attributes: {
                            class: 'tiptap-editor min-h-[260px] px-4 py-4 text-sm leading-7 text-stone-800 focus:outline-none',
                        },
                    },
                    onUpdate: ({ editor }) => {
                        input.value = editor.getHTML();
                    },
                });

                element.__journalEditor = editor;
                this.editor = editor;

                this.$el.querySelectorAll('[data-editor-action]').forEach((button) => {
                    button.addEventListener('click', (event) => {
                        event.preventDefault();
                        const action = button.dataset.editorAction;

                        if (!editor || !editor.isEditable) {
                            return;
                        }

                        if (action === 'bold') {
                            editor.chain().focus().toggleBold().run();
                            return;
                        }

                        if (action === 'italic') {
                            editor.chain().focus().toggleItalic().run();
                            return;
                        }

                        if (action === 'bullet-list') {
                            editor.chain().focus().toggleBulletList().run();
                            return;
                        }

                        if (action === 'heading') {
                            const isHeading = editor.isActive('heading', { level: 3 });
                            editor.chain().focus().toggleHeading({ level: 3 }).run();

                            if (isHeading) {
                                editor.chain().focus().setParagraph().run();
                            }
                        }
                    });
                });
            });
        },
        destroy() {
            if (this.editor) {
                this.editor.destroy();
                this.editor = null;
            }

            if (this.$refs.editor && this.$refs.editor.__journalEditor) {
                this.$refs.editor.__journalEditor.destroy();
                this.$refs.editor.__journalEditor = null;
            }
        },
    };
};
