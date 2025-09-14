<script setup>
import { Link, useForm } from '@inertiajs/vue3'

defineProps({ post: Object })
const form = useForm({ comment: '' })

function submit(postId) {
    form.post(`/posts/${postId}/comments`, { preserveScroll: true })
}
</script>

<template>
    <div class="p-6">
        <h1 class="text-3xl font-bold">{{ post.title }}</h1>
        <p class="text-gray-500">by {{ post.user.name }}</p>
        <div class="mt-4">{{ post.content }}</div>

        <h2 class="text-2xl mt-6 mb-2">Comments</h2>
        <ul class="space-y-2">
            <li v-for="comment in post.comments" :key="comment.id" class="p-2 border rounded">
                <strong>{{ comment.user?.name ?? 'Guest' }}:</strong> {{ comment.comment }}
            </li>
        </ul>

        <form @submit.prevent="submit(post.id)" class="mt-4 flex space-x-2">
            <input v-model="form.comment" type="text" placeholder="Write a comment..." class="border rounded px-2 py-1 flex-1" />
            <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">Add</button>
        </form>
    </div>
</template>
