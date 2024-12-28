<script setup lang="ts">
import { useThemeStore } from '@/Stores/Theme';
import { Link } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { computed, onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { sidebarColor, sidebarType } = storeToRefs(useThemeStore());
const color = computed(() =>
    sidebarType.value === 'bg-gradient-dark' ? 'text-white' : 'text-dark',
);

const sidebarActiveClass = (
    routeName: string,
    hasParams?: Record<string, string>,
) => {
    const isRouteActive = route().current(routeName);
    const areParamsMatching = hasParams
        ? Object.entries(hasParams).every(
              ([key, value]) => route().params[key] === value,
          )
        : true;

    return isRouteActive && areParamsMatching
        ? `nav-link ${sidebarColor.value} active text-white`
        : `nav-link ${color.value}`;
};

const isBodyWhite = ref(false);
const isBodyDark = ref(false);

const { t } = useI18n();

onMounted(() => {
    isBodyWhite.value = !!document.querySelector('body:not(.dark-version)');
    isBodyDark.value = document.body.classList.contains('dark-version');
});
</script>
<template>
    <aside
        :class="`sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start my-2 ms-2 ${sidebarType}`"
        id="sidenav-main"
    >
        <div class="sidenav-header">
            <i
                class="fas fa-times text-dark position-absolute d-xl-none end-0 top-0 cursor-pointer p-3 opacity-5"
                aria-hidden="true"
                id="iconSidenav"
            ></i>

            <Link :href="route('dashboard')">
                <div class="navbar-brand m-0 px-4 py-3">
                    <img
                        src="/assets/img/logo-ct-dark.png"
                        class="navbar-brand-img"
                        width="26"
                        height="26"
                        alt="main_logo"
                    />
                    <span :class="`${color} ms-3 text-sm`">Motivasi App</span>
                </div>
            </Link>
        </div>
        <hr class="horizontal dark mb-2 mt-0" />
        <div class="navbar-collapse collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <Link
                        :class="sidebarActiveClass('dashboard')"
                        :href="route('dashboard')"
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >dashboard</i
                        >
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </Link>
                </li>
                <li class="nav-item mt-3">
                    <h6
                        :class="`text-uppercase ${color} font-weight-bolder ms-2 ps-4 text-xs opacity-5`"
                    >
                        {{ t('content') }}
                    </h6>
                </li>
                <li class="nav-item">
                    <Link
                        :class="
                            sidebarActiveClass('subcategories.index', {
                                category: '0',
                            })
                        "
                        :href="route('subcategories.index', { category: 0 })"
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >dashboard</i
                        >
                        <span class="nav-link-text ms-1">{{
                            t('motivation')
                        }}</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        :class="
                            sidebarActiveClass('subcategories.index', {
                                category: '1',
                            })
                        "
                        :href="route('subcategories.index', { category: 1 })"
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >dashboard</i
                        >
                        <span class="nav-link-text ms-1">{{
                            t('reminder')
                        }}</span>
                    </Link>
                </li>
                <li class="nav-item mt-3">
                    <h6
                        :class="`text-uppercase ${color} font-weight-bolder ms-2 ps-4 text-xs opacity-5`"
                    >
                        Account pages
                    </h6>
                </li>
                <li class="nav-item">
                    <Link
                        :class="sidebarActiveClass('profile.edit')"
                        :href="route('profile.edit')"
                    >
                        <i class="material-symbols-rounded opacity-5">person</i>
                        <span class="nav-link-text ms-1">Profile</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>
