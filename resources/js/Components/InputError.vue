<script setup lang="ts">
defineProps<{
    message?: string;
}>();
</script>

<template>
    <div v-show="message">
        <p class="text-danger text-sm">
            {{ message }}
        </p>
    </div>
</template>
