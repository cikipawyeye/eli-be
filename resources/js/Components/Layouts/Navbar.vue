<script setup lang="ts">
import { useThemeStore } from '@/Stores/Theme';
import { Link } from '@inertiajs/vue3';
import { Dropdown } from 'bootstrap';
import { onMounted, ref } from 'vue';

const themeStore = useThemeStore();

const toggleFixedPlugin = () => {
    themeStore.showFixedPlugin = !themeStore.showFixedPlugin;
};

const dd = ref<Dropdown | null>(null);

onMounted(() => {
    dd.value = new Dropdown('#dropdownMenuButton');
});
</script>

<template>
    <nav
        class="navbar navbar-main navbar-expand-lg border-radius-xl position-sticky shadow-blur z-index-sticky left-auto top-1 mx-3 mt-4 px-0 blur"
        id="navbarBlur"
        data-scroll="true"
        aria-label="Main navigation"
    >
        <div class="container-fluid px-3 py-2">
            <nav
                v-if="$slots.header"
                aria-label="breadcrumb"
                class="d-flex me-2"
            >
                <slot name="header"></slot>
            </nav>
            <div
                class="navbar-collapse mt-sm-0 me-md-0 me-sm-4 collapse mt-2"
                id="navbar"
            >
                <ul
                    class="ms-md-auto navbar-nav d-flex align-items-center justify-content-end"
                >
                    <li
                        class="nav-item d-xl-none d-flex align-items-center ps-4"
                    >
                        <a
                            href="javascript:;"
                            class="nav-link p-0"
                            id="iconNavbarSidenav"
                        >
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                    <li
                        class="nav-item d-flex align-items-center px-4"
                        @click="toggleFixedPlugin()"
                    >
                        <a href="javascript:;" class="nav-link text-body p-0">
                            <i class="fa fa-cog fixed-plugin-button"></i>
                        </a>
                    </li>
                    <li
                        class="nav-item dropdown d-flex align-items-center pe-4"
                    >
                        <a
                            href="javascript:;"
                            class="nav-link text-body p-0"
                            id="dropdownMenuButton"
                            data-bs-toggle="dropdown"
                        >
                            <i class="fa fa-user-circle"></i>
                        </a>
                        <ul
                            class="dropdown-menu dropdown-menu-end me-sm-n4 px-2 pt-3"
                            aria-labelledby="dropdownMenuButton"
                        >
                            <li class="mb-2">
                                <Link
                                    class="dropdown-item border-radius-md text-secondary"
                                    :href="route('logout')"
                                    method="post"
                                >
                                    <div
                                        v-if="false"
                                        class="spinner-border spinner-border-sm me-1"
                                        role="status"
                                    >
                                        <span class="visually-hidden"
                                            >Loading...</span
                                        >
                                    </div>
                                    <i v-else class="fa fa-clock me-1"></i>
                                    Logout
                                </Link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
