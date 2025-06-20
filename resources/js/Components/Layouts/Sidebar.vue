<script setup lang="ts">
import { useThemeStore } from '@/Stores/Theme';
import { Link } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { computed, onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const { sidebarColor, sidebarType } = storeToRefs(useThemeStore());

const color = computed(() =>
    sidebarType.value === 'bg-gradient-dark' ? 'text-white' : 'text-dark',
);

const sidebarActiveClass = (
    routeName: string,
    hasParams?: Record<string, string>,
) => {
    const isRouteActive = route().current()?.startsWith(routeName);
    const areParamsMatching = hasParams
        ? Object.entries(hasParams).every(
              ([key, value]) => route().params[key] === value,
          )
        : true;

    return isRouteActive && areParamsMatching
        ? `${sidebarColor.value} text-white active`
        : color.value;
};

const isBodyWhite = ref(false);
const isBodyDark = ref(false);

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
                        v-if="sidebarType != 'bg-gradient-dark'"
                        src="/assets/img/small-logos/app-logo.webp"
                        class="navbar-brand-img"
                        width="26"
                        height="26"
                        alt="main_logo"
                    />
                    <img
                        v-else
                        src="/assets/img/small-logos/app-logo.webp"
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
                        :class="`nav-link ${sidebarActiveClass('dashboard')}`"
                        :href="route('dashboard')"
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >dashboard</i
                        >
                        <span class="nav-link-text ms-1 ps-1">Dashboard</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <a
                        href="#contentSidebar"
                        class="nav-link"
                        :class="{
                            active: route()
                                .current()
                                ?.startsWith('subcategories'),
                            'text-dark': sidebarType != 'bg-gradient-dark',
                            'text-white': sidebarType == 'bg-gradient-dark',
                        }"
                        data-bs-toggle="collapse"
                        aria-controls="contentSidebar"
                        :aria-expanded="
                            route().current()?.startsWith('subcategories')
                        "
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >space_dashboard</i
                        >
                        <span class="nav-link-text ms-1 ps-1">{{
                            t('content')
                        }}</span>
                    </a>
                    <div class="show collapse" id="contentSidebar">
                        <ul class="nav">
                            <li
                                class="nav-item"
                                :class="{
                                    active:
                                        route()
                                            .current()
                                            ?.startsWith('subcategories') &&
                                        route().params.category == '0',
                                }"
                            >
                                <Link
                                    class="nav-link"
                                    :class="`${sidebarActiveClass(
                                        'subcategories',
                                        {
                                            category: '0',
                                        },
                                    )}`"
                                    :href="
                                        route('subcategories.index', {
                                            category: 0,
                                        })
                                    "
                                >
                                    <span class="sidenav-mini-icon">
                                        &#x2022;
                                    </span>
                                    <span class="sidenav-normal ms-1 ps-1">
                                        {{ t('motivation') }}
                                    </span>
                                </Link>
                            </li>
                            <li
                                class="nav-item"
                                :class="{
                                    active:
                                        route()
                                            .current()
                                            ?.startsWith('subcategories') &&
                                        route().params.category == '1',
                                }"
                            >
                                <Link
                                    class="nav-link"
                                    :class="`${sidebarActiveClass(
                                        'subcategories',
                                        {
                                            category: '1',
                                        },
                                    )}`"
                                    :href="
                                        route('subcategories.index', {
                                            category: 1,
                                        })
                                    "
                                >
                                    <span class="sidenav-mini-icon">
                                        &#x2022;
                                    </span>
                                    <span class="sidenav-normal ms-1 ps-1">
                                        {{ t('reminder') }}
                                    </span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <Link
                        :class="`nav-link ${sidebarActiveClass('users')}`"
                        :href="route('users.index')"
                    >
                        <i class="material-symbols-rounded opacity-5">group</i>
                        <span class="nav-link-text ms-1 ps-1">{{
                            t('users')
                        }}</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        :class="`nav-link ${sidebarActiveClass('payments')}`"
                        :href="route('payments.index')"
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >payments</i
                        >
                        <span class="nav-link-text ms-1 ps-1">{{
                            t('payments')
                        }}</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        :class="`nav-link ${sidebarActiveClass('wallpapers')}`"
                        :href="route('wallpapers.index')"
                    >
                        <i class="material-symbols-rounded opacity-5">image</i>
                        <span class="nav-link-text ms-1 ps-1">{{
                            t('wallpapers')
                        }}</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        :class="`nav-link ${sidebarActiveClass('musics')}`"
                        :href="route('musics.index')"
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >music_note</i
                        >
                        <span class="nav-link-text ms-1 ps-1">{{
                            t('musics')
                        }}</span>
                    </Link>
                </li>

                <li class="nav-item mt-3">
                    <h6
                        :class="`text-uppercase ${color} font-weight-bolder ms-2 ps-4 text-xs opacity-5`"
                    >
                        Settings
                    </h6>
                </li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :class="
                            sidebarActiveClass('reminder-notifications.index')
                        "
                        :href="route('reminder-notifications.index')"
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >notifications</i
                        >
                        <span class="nav-link-text ms-1">{{
                            t('reminder_notification')
                        }}</span>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :class="sidebarActiveClass('emotions.index')"
                        :href="route('emotions.index')"
                    >
                        <i class="material-symbols-rounded opacity-5"
                            >sentiment_content</i
                        >
                        <span class="nav-link-text ms-1">{{
                            t('emotion_and_messages')
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
                        class="nav-link"
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
