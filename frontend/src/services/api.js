import axios from 'axios'

export default axios.create({
    baseURL: 'https://laravel-vercel-ojq6ezwo7-lelouchjek77s-projects.vercel.app/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})