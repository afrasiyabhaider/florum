<template>
    <AppLayout title="Create a post">
        <Container>
            <h1 class="text-2xl font-bold">Create a Post</h1>
            <form @submit.prevent="createPost" class="mt-6">
                <div>
                    <InputLabel for="title" class="sr-only">Title</InputLabel>
                    <TextInput id="title" v-model="postForm.title" class="w-full" placeholder="Give it a great title…"/>
                    <InputError :message="postForm.errors.title" class="mt-1"/>
                </div>
                <div>
                    <InputLabel for="body" class="sr-only">body</InputLabel>
                    <TextArea id="body" v-model="postForm.body" class="w-full mt-1" rows="25" placeholder="Give it a great body..."/>
                    <InputError :message="postForm.errors.body" class="mt-1"/>
                </div>
                <div>
                    <PrimaryButton type="submit" class="mt-1">Create Post</PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";

const postForm = useForm({
    'title': '',
    'body': ''
});
const createPost = () => postForm.post(route('posts.store'),{
    onSuccess: () => postForm.reset()
});
</script>
