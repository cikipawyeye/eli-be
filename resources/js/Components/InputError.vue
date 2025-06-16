<script setup lang="ts">
defineProps<{
    message?: string;
}>();
</script>

<template>
    <div v-show="message">
        <p class="text-danger text-xs lh-sm mt-2 mb-4">
            {{ message }}
        </p>
    </div>
</template>
