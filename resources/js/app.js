import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Placeholder from '@tiptap/extension-placeholder';
import Highlight from '@tiptap/extension-highlight';
import TaskList from '@tiptap/extension-task-list';
import TaskItem from '@tiptap/extension-task-item';
import TextAlign from '@tiptap/extension-text-align';

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
                    extensions: [
                        StarterKit,
                        Placeholder.configure({
                            placeholder: 'Commencez votre pensée…',
                            emptyEditorClass: 'is-editor-empty',
                        }),
                        Highlight,
                        TaskList,
                        TaskItem.configure({ nested: true }),
                        TextAlign.configure({
                            types: ['heading', 'paragraph'],
                            alignments: ['left', 'center', 'right'],
                        }),
                    ],
                    content: input.value || '<h1>Journal</h1><p>Commencez ici…</p>',
                    editorProps: {
                        attributes: {
                            class: 'tiptap-editor min-h-[360px] px-4 pb-6 pt-4 text-[15px] leading-7 text-stone-800 focus:outline-none',
                        },
                    },
                    onUpdate: ({ editor }) => {
                        input.value = editor.getHTML();
                    },
                });

                element.__journalEditor = editor;
                this.editor = editor;

                const applyBlockAction = (action) => {
                    if (!editor || !editor.isEditable) {
                        return;
                    }

                    switch (action) {
                        case 'title':
                            editor.chain().focus().toggleHeading({ level: 1 }).run();
                            break;
                        case 'heading':
                            editor.chain().focus().toggleHeading({ level: 3 }).run();
                            break;
                        case 'paragraph':
                            editor.chain().focus().setParagraph().run();
                            break;
                        case 'bullet-list':
                            editor.chain().focus().toggleBulletList().run();
                            break;
                        case 'task-list':
                            editor.chain().focus().toggleTaskList().run();
                            break;
                        case 'quote':
                            editor.chain().focus().toggleBlockquote().run();
                            break;
                        case 'code':
                            editor.chain().focus().toggleCodeBlock().run();
                            break;
                        case 'bold':
                            editor.chain().focus().toggleBold().run();
                            break;
                        case 'italic':
                            editor.chain().focus().toggleItalic().run();
                            break;
                        case 'strike':
                            editor.chain().focus().toggleStrike().run();
                            break;
                        case 'highlight':
                            editor.chain().focus().toggleHighlight().run();
                            break;
                        case 'align-left':
                            editor.chain().focus().setTextAlign('left').run();
                            break;
                        case 'align-center':
                            editor.chain().focus().setTextAlign('center').run();
                            break;
                        case 'align-right':
                            editor.chain().focus().setTextAlign('right').run();
                            break;
                        default:
                            break;
                    }
                };

                this.$el.querySelectorAll('[data-editor-action]').forEach((button) => {
                    button.addEventListener('click', (event) => {
                        event.preventDefault();
                        applyBlockAction(button.dataset.editorAction);
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
