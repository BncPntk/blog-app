<script setup>
import {Link, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'
import SiteLayout from '@/Layouts/SiteLayout.vue'
defineOptions({ layout: SiteLayout })

const {posts} = defineProps({posts: Object})

const page = usePage()
const isLoggedIn = computed(() => !!page.props.auth?.user)
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">All Posts</h1>

        <div class="mb-4">
            <Link v-if="isLoggedIn"
                  href="/posts/create"
                  class="bg-indigo-600 text-white px-3 py-2 rounded hover:bg-indigo-700">
                New Post
            </Link>

            <div v-else class="flex gap-2">
                <Link href="/login" class="px-3 py-2 border rounded">Log in to post</Link>
                <Link href="/register" class="px-3 py-2 border rounded">Register</Link>
            </div>
        </div>

        <ul class="space-y-4">
            <li v-for="post in posts.data" :key="post.id" class="p-4 border rounded shadow">
                <h2 class="text-xl font-semibold">{{ post.title }}</h2>
                <p class="text-gray-600">by {{ post.user ? post.user.name : 'Guest' }}</p>
                <p class="mt-2 line-clamp-3">{{ post.content }}</p>
                <Link :href="`/posts/${post.id}`" class="text-indigo-600 mt-2 block hover:text-indigo-700 hover:underline">Read more</Link>

                <div v-if="post.can?.update || post.can?.delete" class="flex space-x-2 mt-2">
                    <Link v-if="post.can?.update" :href="`/posts/${post.id}/edit`" class="bg-yellow-500 text-white px-2 py-1 rounded">
                        Edit
                    </Link>

                    <Link v-if="post.can?.delete" as="button" method="delete" :href="`/posts/${post.id}`"
                          class="bg-red-600 text-white px-2 py-1 rounded">
                        Delete
                    </Link>
                </div>
            </li>
        </ul>
    </div>
</template>
