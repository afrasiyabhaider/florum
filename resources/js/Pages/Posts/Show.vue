<template>
    <AppLayout :title="post.title">
        <Container>
            <h1 class="text-2xl font-bold">{{ post.title }}</h1>
            <span class="block mt-1 text-sm text-gray-600">{{ relativeDate(post.created_at) }} by {{ post.user.name }}</span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>
            <h1 class="font-semibold text-xl">Comments</h1>
            <form v-if="$page.props.auth.user" @submit.prevent="addComment" class="mt-1">
                <div>
                    <InputLabel for="body" class="sr-only">Comment</InputLabel>
                    <TextArea id="body" rows="4" v-model="commentsForm.body" placeholder="Speak your mind spock..." :disabled="commentsForm.processing"></TextArea>
                    <InputError :message="commentsForm.errors.body" class="mt-1"/>
                </div>
                <PrimaryButton type="submit" class="mt-3 bg-indigo-600 hover:bg-indigo-500">Add Comment</PrimaryButton>
            </form>
            <ul class="divide-y mt-4">
                <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                    <Comment @delete="deleteComment" class="break-all" :comment="comment"/>
                </li>
            </ul>
            <Pagination :meta="comments.meta" :only="['comments']"/>
        </Container>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Comment from "@/Components/Comment.vue";
import Pagination from "@/Components/Pagination.vue";
import {relativeDate} from "@/Utilities/date.js";
import { router, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const props = defineProps(['post','comments']);
const commentsForm = useForm({
    'body':null
});
const addComment = () => commentsForm.post(route('posts.comments.store',props.post.id),{
    preserveScroll: true,
    onSuccess: () => commentsForm.reset()
});

const deleteComment = (commentId)=> router.delete(route('comments.destroy',{'comment': commentId,'page': props.comments.meta.current_page}),{
    preserveScroll: true
});
</script>
