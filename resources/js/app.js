import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Placeholder from '@tiptap/extension-placeholder';
import Highlight from '@tiptap/extension-highlight';
import TaskList from '@tiptap/extension-task-list';
import TaskItem from '@tiptap/extension-task-item';
import TextAlign from '@tiptap/extension-text-align';

window.journalNoteEditor = function () {
    return {
        syncFrame: null,
        syncVersion: 0,
        syncEditorContent(content) {
            const html = content || this.$refs.contentInput?.value || '<p>Commencez ici…</p>';
            const version = ++this.syncVersion;

            if (this.syncFrame) {
                cancelAnimationFrame(this.syncFrame);
            }

            this.syncFrame = requestAnimationFrame(() => {
                this.syncFrame = null;
                const editor = this.$refs.editor?.__journalEditor;

                if (version !== this.syncVersion || !editor || editor.isDestroyed) {
                    return;
                }

                if (html === editor.getHTML()) {
                    return;
                }

                editor.commands.setContent(html, {
                    emitUpdate: false,
                });

                if (this.$refs.contentInput) {
                    this.$refs.contentInput.value = html;
                }
            });
        },
        init() {
            if (this.$el.dataset.journalEditorInitialized === 'true') {
                return;
            }

            this.$el.dataset.journalEditorInitialized = 'true';

            this.$nextTick(() => {
                const element = this.$refs.editor;
                const input = this.$refs.contentInput;
                const toolbar = this.$refs.floatingToolbar;
                const blockMenu = this.$refs.blockMenu;
                const blockMenuButton = this.$refs.blockMenuButton;

                if (!element || !input) {
                    return;
                }

                if (element.__journalEditor) {
                    element.__journalEditor.destroy();
                }

                const runEditorCommand = (callback) => {
                    const editor = element.__journalEditor;

                    if (!editor || editor.isDestroyed) {
                        return;
                    }

                    try {
                        callback(editor);
                    } catch (error) {
                        if (error instanceof RangeError) {
                            return;
                        }

                        throw error;
                    }
                };

                const applyBlockType = (type) => {
                    runEditorCommand((editor) => {
                        const chain = editor.chain();

                        switch (type) {
                            case 'title':
                                chain.toggleHeading({ level: 1 }).run();
                                break;
                            case 'heading':
                                chain.toggleHeading({ level: 3 }).run();
                                break;
                            case 'paragraph':
                                chain.setParagraph().run();
                                break;
                            case 'list':
                                chain.toggleBulletList().run();
                                break;
                            case 'checklist':
                                chain.toggleTaskList().run();
                                break;
                            case 'quote':
                                chain.toggleBlockquote().run();
                                break;
                            case 'code':
                                chain.toggleCodeBlock().run();
                                break;
                            case 'emoji':
                                chain.insertContent('🙂 ').run();
                                break;
                            default:
                                chain.setParagraph().run();
                                break;
                        }
                    });

                    if (blockMenu) {
                        blockMenu.classList.add('hidden');
                    }
                };

                const applyTextAction = (action) => {
                    runEditorCommand((editor) => {
                        const chain = editor.chain();

                        switch (action) {
                            case 'bold':
                                chain.toggleBold().run();
                                break;
                            case 'italic':
                                chain.toggleItalic().run();
                                break;
                            case 'strike':
                                chain.toggleStrike().run();
                                break;
                            case 'highlight':
                                chain.toggleHighlight().run();
                                break;
                            case 'align-left':
                                chain.setTextAlign('left').run();
                                break;
                            case 'align-center':
                                chain.setTextAlign('center').run();
                                break;
                            case 'align-right':
                                chain.setTextAlign('right').run();
                                break;
                            case 'emoji':
                                chain.insertContent('🙂 ').run();
                                break;
                            default:
                                break;
                        }
                    });
                };

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
                            class: 'journal-prose-editor',
                        },
                    },
                    onUpdate: ({ editor }) => {
                        if (!editor || editor.isDestroyed) {
                            return;
                        }

                        input.value = editor.getHTML();
                    },
                });

                element.__journalEditor = editor;
                input.value = editor.getHTML();

                if (blockMenuButton) {
                    blockMenuButton.addEventListener('click', (event) => {
                        event.preventDefault();
                        if (blockMenu) {
                            blockMenu.classList.toggle('hidden');
                        }
                    });
                }

                if (blockMenu) {
                    blockMenu.querySelectorAll('[data-block-type]').forEach((button) => {
                        button.addEventListener('click', (event) => {
                            event.preventDefault();
                            applyBlockType(button.dataset.blockType);
                        });
                    });
                }

                this.$el.querySelectorAll('[data-editor-action]').forEach((button) => {
                    button.addEventListener('click', (event) => {
                        event.preventDefault();
                        applyTextAction(button.dataset.editorAction);
                    });
                });

                const updateToolbar = () => {
                    if (!toolbar) {
                        return;
                    }

                    const hasFocus = element.contains(document.activeElement) || document.activeElement === element;
                    toolbar.classList.toggle('opacity-0', !hasFocus);
                    toolbar.classList.toggle('pointer-events-none', !hasFocus);
                };

                element.addEventListener('focusin', updateToolbar);
                element.addEventListener('focusout', () => setTimeout(updateToolbar, 50));
                updateToolbar();
            });
        },
        destroy() {
            if (this.syncFrame) {
                cancelAnimationFrame(this.syncFrame);
                this.syncFrame = null;
            }

            this.syncVersion++;

            if (this.$refs.editor && this.$refs.editor.__journalEditor) {
                this.$refs.editor.__journalEditor.destroy();
                this.$refs.editor.__journalEditor = null;
            }
        },
    };
};
