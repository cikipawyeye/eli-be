<script setup lang="ts">
import Guest from '@/Layouts/Guest.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>
    <Head title="Welcome" />

    <Guest>
        <h1>Halo guys</h1>
    </Guest>
</template>
