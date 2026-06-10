<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'
import { onMounted } from 'vue'

const router = useRouter()

const email = ref('')
const password = ref('')
const error = ref('')

onMounted(() => {

    const token = localStorage.getItem('token')

    if (token) {
        router.push('/dashboard')
    }

})

const login = async () => {
    try {

        const response = await api.post('/login', {
            email: email.value,
            password: password.value
        })

        localStorage.setItem(
            'token',
            response.data.token
        )

        localStorage.setItem(
            'user',
            JSON.stringify(response.data.user)
        )

        router.push('/dashboard')

    } catch (err) {

        error.value = err.response?.data?.message ??
            'Login failed'

    }
}
</script>

<template>
    <div>
        <h1>Login</h1>

        <p v-if="error">
            {{ error }}
        </p>

        <input
            v-model="email"
            type="email"
            placeholder="Email"
        />

        <input
            v-model="password"
            type="password"
            placeholder="Password"
        />

        <button @click="login">
            Login
        </button>
    </div>
</template>