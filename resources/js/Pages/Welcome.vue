<script setup lang="ts">
import Guest from '@/Layouts/Guest.vue';
import { Head, Link } from '@inertiajs/vue3';

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

        <Link :href="route('login')">Login</Link>
    </Guest>
</template>
