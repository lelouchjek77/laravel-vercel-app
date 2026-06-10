<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'

const router = useRouter()

const ownedDocuments = ref([])
const sharedDocuments = ref([])

const shareDocument = async (documentId) => {

    const userId = prompt(
        'Enter user ID to share with (e.g. 2)'
    )

    if (!userId) return

    try {

        await api.post(
            `/documents/${documentId}/share`,
            {
                user_id: userId
            },
            {
                headers: {
                    Authorization:
                        `Bearer ${localStorage.getItem('token')}`
                }
            }
        )

        alert('Document shared successfully')

    } catch (error) {

        console.error(error)

        alert('Failed to share document')

    }

}

const loadDocuments = async () => {

    try {

        const response = await api.get(
            '/documents',
            {
                headers: {
                    Authorization:
                        `Bearer ${localStorage.getItem('token')}`
                }
            }
        )

        ownedDocuments.value = response.data

    } catch (error) {

        console.error(error)

    }

}

const loadSharedDocuments = async () => {

    try {

        const response = await api.get(
            '/shared-documents',
            {
                headers: {
                    Authorization:
                        `Bearer ${localStorage.getItem('token')}`
                }
            }
        )

        sharedDocuments.value = response.data

    } catch (error) {

        console.error(error)

    }

}

const importFile = async (event) => {

    const file = event.target.files[0]

    if (!file) return

    const formData = new FormData()

    formData.append('file', file)

    try {

        const response = await api.post(
            '/documents/import',
            formData,
            {
                headers: {
                    Authorization:
                        `Bearer ${localStorage.getItem('token')}`,
                    'Content-Type':
                        'multipart/form-data'
                }
            }
        )

        alert('Imported successfully')

        loadDocuments()

    } catch (error) {

        console.error(error)

        alert('Import failed')

    }

}

const createDocument = () => {

    router.push('/editor')

}

const openDocument = (id) => {

    router.push(`/editor/${id}`)

}

const logout = () => {

    localStorage.removeItem('token')
    localStorage.removeItem('user')

    router.push('/')

}

onMounted(() => {

    const token = localStorage.getItem('token')

    if (!token) {

        router.push('/')

        return
    }

    loadDocuments()
    loadSharedDocuments()

})
</script>

<template>

    <div class="dashboard">

        <div class="header">

            <h1>Dashboard</h1>

            <button @click="logout">
                Logout
            </button>

        </div>

        <button
            class="create-btn"
            @click="createDocument"
        >
            Create Document
        </button>
        <input
            type="file"
            accept=".txt,.md"
            @change="importFile"
        />

        <h2>Owned Documents</h2>

        <ul v-if="ownedDocuments.length">

            <li
                v-for="doc in ownedDocuments"
                :key="doc.id"
            >

                <span>
                    {{ doc.title }}
                </span>

                <div>

                    <button
                        @click="openDocument(doc.id)"
                    >
                        Open
                    </button>

                    <button
                        @click="shareDocument(doc.id)"
                    >
                        Share
                    </button>

                </div>

            </li>

        </ul>

        <p v-else>
            No documents yet.
        </p>

        <h2>Shared With Me</h2>

        <ul v-if="sharedDocuments.length">

            <li
                v-for="doc in sharedDocuments"
                :key="doc.id"
            >
                {{ doc.title }}
            </li>

        </ul>

        <p v-else>
            No shared documents.
        </p>

    </div>

</template>

<style scoped>

.dashboard {
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.create-btn {
    margin: 20px 0;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ddd;
}

li div {
    display: flex;
    gap: 10px;
}

</style>