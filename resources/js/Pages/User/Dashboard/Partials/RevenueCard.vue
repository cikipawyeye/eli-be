<script setup lang="ts">
import { formatMoney } from '@/Supports/helpers';
import { usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage<SharedProps & {
    revenue: number;
}>()

const { t } = useI18n();

</script>

<template>
    <div class="card">
        <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-sm mb-0 text-capitalize">{{ t('revenue') }}</p>
                    <h4 class="mb-0">{{ formatMoney(page.props.revenue) }}</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                    <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+5% </span>than yesterday
            </p>
        </div>
    </div>
</template>