<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PremiumUserCard from './Partials/PremiumUserCard.vue';
import NonPremiumUserCard from './Partials/NonPremiumUserCard.vue';
import AverageAgeCard from './Partials/AverageAgeCard.vue';

defineProps<{
    premiumUser: number;
    nonPremiumUser: number;
    averageAge: string;
}>();

const { t } = useI18n();
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

        <div class="row my-2">
            <div class="ms-3">
                <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
                <p class="mb-4">
                    Check the sales, value and bounce rate by country.
                </p>
            </div>

            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <PremiumUserCard />
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <NonPremiumUserCard />
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <AverageAgeCard />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
