<script setup lang="ts">
import { SidebarColor, SidebarType, useThemeStore } from '@/Stores/Theme';
import { onMounted, onUnmounted, ref } from 'vue';

const themeStore = useThemeStore();

const toggleFixedPlugin = () => {
    themeStore.showFixedPlugin = !themeStore.showFixedPlugin;
};

const setSidebarColor = (color: SidebarColor) => {
    themeStore.sidebarColor = color;
};

const setSidebarType = (type: SidebarType) => {
    themeStore.sidebarType = type;
};

// Refs untuk elemen DOM
const fixedPlugin = ref<HTMLElement | null>(null);
const fixedPluginButton = ref<HTMLElement | null>(null);
const fixedPluginButtonNav = ref<HTMLElement | null>(null);
const fixedPluginCard = ref<HTMLElement | null>(null);

function hideFixedPlugin(e: MouseEvent) {
    if (themeStore.showFixedPlugin === false) return;

    const target = e.target as HTMLElement;

    if (
        !target.classList.contains('fixed-plugin') &&
        !target.classList.contains('fixed-plugin-button') &&
        !target.closest('.fixed-plugin .card')
    ) {
        themeStore.showFixedPlugin = false;
    }
}

onMounted(() => {
    fixedPlugin.value = document.querySelector('.fixed-plugin');
    fixedPluginButton.value = document.querySelector('.fixed-plugin-button');
    fixedPluginButtonNav.value = document.querySelector(
        '.fixed-plugin-button-nav',
    );
    fixedPluginCard.value = document.querySelector('.fixed-plugin .card');

    document.addEventListener('click', hideFixedPlugin);
});

onUnmounted(() => {
    document.removeEventListener('click', hideFixedPlugin);
});
</script>

<template>
    <div class="fixed-plugin" :class="{ show: themeStore.showFixedPlugin }">
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mb-0 mt-3">UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button
                        class="btn btn-link text-dark fixed-plugin-close-button p-0"
                        @click="toggleFixedPlugin"
                    >
                        <i class="material-symbols-rounded">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1" />
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a
                    href="javascript:void(0)"
                    class="switch-trigger background-color"
                >
                    <div class="badge-colors my-2 text-start">
                        <span
                            class="badge bg-gradient-primary filter"
                            :class="{
                                active:
                                    themeStore.sidebarColor ===
                                    'bg-gradient-primary',
                            }"
                            data-color="primary"
                            @click="setSidebarColor('bg-gradient-primary')"
                        ></span>
                        <span
                            class="badge bg-gradient-dark filter"
                            :class="{
                                active:
                                    themeStore.sidebarColor ===
                                    'bg-gradient-dark',
                            }"
                            data-color="dark"
                            @click="setSidebarColor('bg-gradient-dark')"
                        ></span>
                        <span
                            class="badge bg-gradient-info filter"
                            :class="{
                                active:
                                    themeStore.sidebarColor ===
                                    'bg-gradient-info',
                            }"
                            data-color="info"
                            @click="setSidebarColor('bg-gradient-info')"
                        ></span>
                        <span
                            class="badge bg-gradient-success filter"
                            :class="{
                                active:
                                    themeStore.sidebarColor ===
                                    'bg-gradient-success',
                            }"
                            data-color="success"
                            @click="setSidebarColor('bg-gradient-success')"
                        ></span>
                        <span
                            class="badge bg-gradient-warning filter"
                            :class="{
                                active:
                                    themeStore.sidebarColor ===
                                    'bg-gradient-warning',
                            }"
                            data-color="warning"
                            @click="setSidebarColor('bg-gradient-warning')"
                        ></span>
                        <span
                            class="badge bg-gradient-danger filter"
                            :class="{
                                active:
                                    themeStore.sidebarColor ===
                                    'bg-gradient-danger',
                            }"
                            data-color="danger"
                            @click="setSidebarColor('bg-gradient-danger')"
                        ></span>
                    </div>
                </a>

                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">
                        Choose between different sidenav types.
                    </p>
                </div>
                <div class="d-flex">
                    <button
                        class="btn bg-gradient-dark mb-2 px-3"
                        :class="{
                            active:
                                themeStore.sidebarType === 'bg-gradient-dark',
                        }"
                        data-class="bg-gradient-dark"
                        @click="setSidebarType('bg-gradient-dark')"
                    >
                        Dark
                    </button>
                    <button
                        class="btn bg-gradient-dark mb-2 ms-2 px-3"
                        :class="{
                            active: themeStore.sidebarType === 'bg-transparent',
                        }"
                        data-class="bg-transparent"
                        @click="setSidebarType('bg-transparent')"
                    >
                        Transparent
                    </button>
                    <button
                        class="btn bg-gradient-dark mb-2 ms-2 px-3"
                        :class="{
                            active: themeStore.sidebarType === 'bg-white',
                        }"
                        data-class="bg-white"
                        @click="setSidebarType('bg-white')"
                    >
                        White
                    </button>
                </div>
                <p class="d-xl-none d-block mt-2 text-sm">
                    You can change the sidenav type just on desktop view.
                </p>
            </div>
        </div>
    </div>
</template>
