<script setup lang="ts">
import FixedPlugin from '@/Components/Layouts/FixedPlugin.vue';
import Footer from '@/Components/Layouts/Footer.vue';
import Navbar from '@/Components/Layouts/Navbar.vue';
import Sidebar from '@/Components/Layouts/Sidebar.vue';
import { onMounted, onUnmounted, ref } from 'vue';

const body = ref<HTMLElement | null>(null);
const sidenav = ref<HTMLElement | null>(null);
const iconSidenav = ref<HTMLElement | null>(null);
const iconNavbarSidenav = ref<HTMLElement | null>(null);

function toggleSidenav() {
    const isPinned = body.value?.classList.toggle('g-sidenav-pinned');

    if (isPinned) {
        sidenav.value?.classList.add('bg-white');
        sidenav.value?.classList.remove('bg-transparent');
        iconSidenav.value?.classList.remove('d-none');
    } else {
        setTimeout(() => {
            sidenav.value?.classList.remove('bg-white');
        }, 100);
        sidenav.value?.classList.add('bg-transparent');
    }
}

onMounted(() => {
    iconNavbarSidenav.value = document.getElementById('iconNavbarSidenav');
    iconSidenav.value = document.getElementById('iconSidenav');
    sidenav.value = document.getElementById('sidenav-main');
    body.value = document.body;

    iconNavbarSidenav.value?.addEventListener('click', toggleSidenav);
    iconSidenav.value?.addEventListener('click', toggleSidenav);
});

onUnmounted(() => {
    iconNavbarSidenav.value?.removeEventListener('click', toggleSidenav);
    iconSidenav.value?.removeEventListener('click', toggleSidenav);
});
</script>

<template>
    <Sidebar />

    <main
        class="main-content position-relative max-height-vh-100 h-100 border-radius-lg"
    >
        <Navbar>
            <template #header>
                <slot name="header"></slot>
            </template>
        </Navbar>

        <div class="container py-2">
            <slot />

            <Footer />
        </div>
    </main>

    <FixedPlugin />
</template>
