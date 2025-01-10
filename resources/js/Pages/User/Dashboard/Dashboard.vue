<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PremiumUserCard from './Partials/PremiumUserCard.vue';
import NonPremiumUserCard from './Partials/NonPremiumUserCard.vue';
import AverageAgeCard from './Partials/AverageAgeCard.vue';
import AgeStatsCard from './Partials/AgeStatsCard.vue';
import GenderStatsCard from './Partials/GenderStatsCard.vue';
import RevenueCard from './Partials/RevenueCard.vue';
import TabNavs from '@/Components/TabNavs.vue';
import CityStatsCard from './Partials/CityStatsCard.vue';

const { t } = useI18n();

const range = ref<'today' | 'week' | 'month' | 'year'>('today');

const reload = (range: string) => {
    router.reload({
        only: ['revenue'],
        data: {
            range
        },
        showProgress: true
    });
};

watch(range, reload);
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <ol class="breadcrumb m-auto bg-transparent">
                <li class="breadcrumb-item text-dark active text-sm" aria-current="page">
                    Dashboard
                </li>
            </ol>
        </template>

        <div class="mt-2 row">
            <div class="col-12 col-lg-4 mb-4 ps-4">
                <h3 class="mb-0 h5 font-weight-bolder">Dashboard</h3>
                <p class="mb-0">
                    Welcome, <span class="text-primary">{{ $page.props.auth.user.name }}</span>
                </p>
            </div>
            <div class="col-12 col-lg-8 mb-4">
                <TabNavs border variant="nav-pills-primary" :items="[{
                    id: 'today',
                    name: t('today'),
                    active: true,
                }, {
                    id: 'week',
                    name: t('this_week'),
                    active: false,
                }, {
                    id: 'month',
                    name: t('this_month'),
                    active: false,
                }, {
                    id: 'year',
                    name: t('this_year'),
                    active: false,
                }]" v-on:click="(selected) => (range = (selected as any))" />
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <PremiumUserCard />
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <NonPremiumUserCard />
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <AverageAgeCard />
            </div>
            <div class="col-xl-3 col-sm-6">
                <RevenueCard :range="range" />
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                <AgeStatsCard />
            </div>
            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                <CityStatsCard />
            </div>
            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                <GenderStatsCard />
            </div>
        </div>
    </AuthenticatedLayout>
</template>