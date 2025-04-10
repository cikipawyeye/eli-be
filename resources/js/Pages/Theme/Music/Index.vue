<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import WallpaperList from './Partials/MusicList.vue';

const { t } = useI18n();
</script>

<template>
    <Head :title="t('musics')" />

    <AuthenticatedLayout>
        <template #header>
            <ol class="breadcrumb m-auto bg-transparent">
                <li class="breadcrumb-item text-sm">
                    <Link
                        class="text-dark opacity-5"
                        :href="route('dashboard')"
                    >
                        <i class="fa fa-house"></i>
                    </Link>
                </li>
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    {{ t('musics') }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div
                    class="shadow-secondary border-radius-lg d-flex gap-4 p-3 flex-wrap"
                >
                    <h6 class="text-capitalize my-auto">
                        {{ t('musics') }}
                    </h6>
                </div>
            </div>

            <div class="card-body pb-2">
                <WallpaperList />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
