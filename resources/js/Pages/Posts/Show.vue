<template>
    <AppLayout :title="post.title">
        <Container>
            <h1 class="text-2xl font-bold">{{ post.title }}</h1>
            <span class="block mt-1 text-sm text-gray-600">{{ relativeDate(post.created_at) }} by {{ post.user.name }}</span>

            <article class="mt-6">
                <pre class="whitespace-pre-wrap font-sans">{{ post.body }}</pre>
            </article>
            <h1 class="font-semibold text-xl">Comments</h1>
            <form v-if="$page.props.auth.user" @submit.prevent="()=> commentIdBeingEdited?updateComment() : addComment()" class="mt-1">
                <div>
                    <InputLabel for="body" class="sr-only">Comment</InputLabel>
                    <TextArea ref="commentTextAreaRef"  id="body" rows="4" v-model="commentsForm.body" placeholder="Speak your mind spock..." :disabled="commentsForm.processing"></TextArea>
                    <InputError :message="commentsForm.errors.body" class="mt-1"/>
                </div>
                <PrimaryButton type="submit" class="mt-3 bg-indigo-600 hover:bg-indigo-500" v-text="commentIdBeingEdited ? 'Update Comment' : 'Add Comment'"></PrimaryButton>
                <SecondaryButton @click="cancelEditComment" v-if="commentIdBeingEdited" class="ml-2">Cancel</SecondaryButton>
            </form>
            <ul class="divide-y mt-4">
                <li v-for="comment in comments.data" :key="comment.id" class="px-2 py-4">
                    <Comment @edit="editComment"  @delete="deleteComment" class="break-all" :comment="comment" :commentIdBeingEdited="commentIdBeingEdited"/>
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
import { computed, ref } from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps(['post','comments']);
const commentsForm = useForm({
    'body':null
});
const commentTextAreaRef = ref(null);
const commentIdBeingEdited = ref(null);
const commentBeingEdited = computed(()=> props.comments.data.find(comment => comment.id === commentIdBeingEdited.value));
const editComment = (commentId) => {
    commentIdBeingEdited.value = commentId;
    commentsForm.body = commentBeingEdited.value?.body;
    commentTextAreaRef.value?.focus();
}
const cancelEditComment = () =>{
    commentIdBeingEdited.value = null;
    commentsForm.reset();
}
const addComment = () => commentsForm.post(route('posts.comments.store',props.post.id),{
    preserveScroll: true,
    onSuccess: () => commentsForm.reset()
});
const updateComment = () => commentsForm.put(route('comments.update',{
    'comment': commentIdBeingEdited.value,
    'page': props.comments.meta.current_page,
}),{
    preserveScroll: true,
    onSuccess: cancelEditComment
})
const deleteComment = (commentId)=> router.delete(route('comments.destroy',{'comment': commentId,'page': props.comments.meta.current_page}),{
    preserveScroll: true
});
</script>
