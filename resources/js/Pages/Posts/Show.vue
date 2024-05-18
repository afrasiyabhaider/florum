<template>
    <AppLayout :title="post.title">
        <Container>
            <h1 class="text-2xl font-bold">{{ post.title }}</h1>
            <span class="block mt-1 text-sm text-gray-600">{{ relativeDate(post.created_at) }} by {{ post.user.name }}</span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>
            <ul class="divide-y mt-4">
                <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                    <Comment :comment="comment"/>
                </li>
            </ul>
            <Pagination :meta="comments.meta" :only="['comments']"/>
        </Container>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Comment from "@/Components/Comment.vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/Utilities/date.js";

const props = defineProps(['post','comments']);
</script>
