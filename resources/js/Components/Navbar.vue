<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth?.user || null) // hu: itt döntjük el, hogy be van-e jelentkezve
</script>

<template>
    <nav class="bg-white/90 backdrop-blur border-b">
        <div class="mx-auto max-w-5xl px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Link href="/" class="font-semibold text-gray-900">Blog</Link>
                <Link v-if="user" href="/posts/create"
                      class="text-sm px-3 py-1 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                    New Post
                </Link>
            </div>

            <div class="flex items-center gap-3">
                <template v-if="user">
                    <span class="text-sm text-gray-700">Hi, {{ user.name }}</span>
                    <Link href="/dashboard" class="text-sm text-gray-700 hover:underline">Dashboard</Link>
                    <Link as="button" method="post" href="/logout"
                          class="text-sm text-gray-600 hover:text-gray-900">
                        Log out
                    </Link>
                </template>

                <template v-else>
                    <Link href="/login" class="text-sm text-gray-700 hover:underline">Log in</Link>
                    <span class="text-gray-300 select-none">/</span>
                    <Link href="/register" class="text-sm text-gray-700 hover:underline">Register</Link>
                </template>
            </div>
        </div>
    </nav>
</template>
