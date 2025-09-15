<script setup>
import { useForm } from '@inertiajs/vue3'
import SiteLayout from '@/Layouts/SiteLayout.vue'
defineOptions({ layout: SiteLayout })

const form = useForm({ title: '', content: '' })

function submit() {
    form.post('/posts')
}
</script>

<template>
    <div class="p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4">Create New Post</h1>
        <form @submit.prevent="submit" class="space-y-4">
            <input v-model="form.title" type="text" placeholder="Title" class="w-full border px-2 py-1 rounded" />
            <textarea v-model="form.content" placeholder="Content" class="w-full border px-2 py-1 rounded"></textarea>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Publish</button>
        </form>
    </div>
</template>
