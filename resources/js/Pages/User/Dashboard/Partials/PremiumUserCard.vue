<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage<SharedProps & {
    premiumUser: number;
    nonPremiumUser: number;
    averageAge: string;
}>()

const { t } = useI18n();

</script>

<template>
    <div class="card">
        <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-sm mb-0 text-capitalize">{{ t('premium_user') }}</p>
                    <h4 class="mb-0">{{ page.props.premiumUser }}</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                    <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than last week
            </p>
        </div>
    </div>
</template>