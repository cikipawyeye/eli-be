<script setup lang="ts">
defineProps<{
    message?: string;
}>();
</script>

<template>
    <div v-show="message">
        <small class="text-danger text-xs">
            {{ message }}
        </small>
    </div>
</template>
