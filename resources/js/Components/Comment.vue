<template>
    <div class="sm:flex">
        <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
            <img :src="comment.user.profile_photo_url" class="h-10 w-10 rounded-full" />
        </div>
        <div class="flex-1">
            <div class="prose prose-sm" v-html="comment.html"></div>
            <span class="first-letter:uppercase block pt-1 text-xs text-gray-600">By {{ comment.user.name }} {{ relativeDate(comment.created_at) }}</span>
            <div class="mt-2 flex justify-end space-x-3 empty:hidden">
                <form v-if="comment.can?.update && commentIdBeingEdited !== comment.id" @submit.prevent="$emit('edit',comment.id)">
                    <button class=" hover:font-semibold">Edit</button>
                </form>
                <form v-if="comment.can?.delete && commentIdBeingEdited !== comment.id" @submit.prevent="$emit('delete',comment.id)">
                    <button class="text-red-700 hover:font-semibold">Delete</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import {relativeDate} from "@/Utilities/date.js";

const props = defineProps(['comment','commentIdBeingEdited']);
const emit = defineEmits(['edit','delete']);
</script>
