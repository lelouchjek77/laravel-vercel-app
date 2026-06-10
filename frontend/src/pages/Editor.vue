<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'

import api from '../services/api'

const route = useRoute()
const router = useRouter()

const documentId = route.params.id

const title = ref('')
const loading = ref(false)

const editor = useEditor({
    extensions: [
        StarterKit,
        Underline,
    ],
    content: '<p>Start writing...</p>',
})

const authHeaders = {
    Authorization: `Bearer ${localStorage.getItem('token')}`
}

const loadDocument = async () => {
    
    if (!documentId) return

    try {

        const response = await api.get(
            `/documents/${documentId}`,
            {
                headers: authHeaders
            }
        )
        console.log("edit", response.data.title);
        title.value = response.data.title

        editor.value.commands.setContent(
            response.data.content
        )

    } catch (error) {

        console.error(error)

    }

}

const saveDocument = async () => {

    try {

        loading.value = true

        const payload = {
            title: title.value,
            content: editor.value.getHTML()
        }

        if (documentId) {

            await api.put(
                `/documents/${documentId}`,
                payload,
                {
                    headers: authHeaders
                }
            )

        } else {

            const response = await api.post(
                '/documents',
                payload,
                {
                    headers: authHeaders
                }
            )

            router.push(
                `/editor/${response.data.id}`
            )

        }

        alert('Document Saved')

    } catch (error) {

        console.error(error)

        alert('Save failed')

    } finally {

        loading.value = false

    }

}

onMounted(() => {

    loadDocument()

})
</script>

<template>
    <div>

        <div class="header">

            <input
                v-model="title"
                placeholder="Document Title"
            />

            <button
                @click="saveDocument"
                :disabled="loading"
            >
                {{ loading ? 'Saving...' : 'Save Document' }}
            </button>

        </div>
    
        <div class="toolbar">

            <button
                @click="editor.chain().focus().toggleBold().run()"
            >
                Bold
            </button>

            <button
                @click="editor.chain().focus().toggleItalic().run()"
            >
                Italic
            </button>

            <button
                @click="editor.chain().focus().toggleUnderline().run()"
            >
                Underline
            </button>

            <button
                @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
            >
                H1
            </button>

            <button
                @click="editor.chain().focus().toggleBulletList().run()"
            >
                Bullet List
            </button>

            <button
                @click="editor.chain().focus().toggleOrderedList().run()"
            >
                Number List
            </button>

        </div>

        <EditorContent
            :editor="editor"
        />

    </div>
</template>

<style>
.ProseMirror {
    min-height: 400px;
    border: 1px solid #ddd;
    padding: 15px;
    margin-top: 10px;
}
</style>