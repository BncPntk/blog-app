<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import SiteLayout from '@/Layouts/SiteLayout.vue'
defineOptions({ layout: SiteLayout })

const { post } = defineProps({ post: Object })
const form = useForm({ comment: '' })

function submit() {
    form.post(`/posts/${post.id}/comments`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('comment')
            router.reload({ only: ['post'] })
        },
    })
}
</script>

<template>
    <div class="p-6">
        <h1 class="text-3xl font-bold">{{ post.title }}</h1>
        <p class="text-gray-600">by {{ post.user ? post.user.name : 'Guest' }}</p>
        <div class="mt-4">{{ post.content }}</div>

        <h2 class="text-2xl mt-6 mb-2">Comments</h2>
        <ul class="space-y-2">
            <li v-for="comment in (post.comments || [])" :key="comment.id" class="p-2 border rounded">
                <strong>{{ comment.user?.name ?? 'Guest' }}:</strong> {{ comment.comment }}

                <Link
                    v-if="comment.can?.delete"
                    as="button"
                    method="delete"
                    :href="`/comments/${comment.id}`"
                    class="text-red-600 text-sm ml-2"
                >Delete</Link>
            </li>
        </ul>

        <form @submit.prevent="submit" class="mt-4 flex space-x-2">
            <input v-model="form.comment" type="text" placeholder="Write a comment..." class="border rounded px-2 py-1 flex-1" />
            <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">Add</button>
        </form>
    </div>
</template>
