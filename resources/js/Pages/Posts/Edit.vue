<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ post: Object })

const form = useForm({
    title: props.post.title,
    content: props.post.content,
})

function submit() {
    form.put(`/posts/${props.post.id}`)
}
</script>

<template>
    <div class="p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Post</h1>
        <form @submit.prevent="submit" class="space-y-4">
            <input v-model="form.title" type="text" class="w-full border px-2 py-1 rounded" />
            <textarea v-model="form.content" class="w-full border px-2 py-1 rounded"></textarea>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
        </form>
    </div>
</template>
