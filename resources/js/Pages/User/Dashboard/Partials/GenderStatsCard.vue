<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Pie } from 'vue-chartjs'
import { computed } from 'vue';

const page = usePage<SharedProps & {
    genderStats: Record<'male' | 'female' | 'unknown', number>;
}>()

ChartJS.register(ArcElement, Tooltip, Legend)

const { t } = useI18n();

const dataset = computed(() => ({
    datasets: [{
        backgroundColor: ['#2CA4D2', '#B13173', '#C6C6C6'],
        data: [page.props.genderStats?.male ?? 0, page.props.genderStats?.female ?? 0, page.props.genderStats?.unknown ?? 0]
    }],

    labels: [
        t('male'),
        t('female'),
        t('not_filled'),
    ]
}));
</script>

<template>
    <div class="card w-100">
        <div class="card-header pb-0">
            <h6>{{ t('gender') }}</h6>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="d-flex justify-content-center">
                <div class="mx-auto" style="max-width: 300px;">
                    <Pie :data="dataset" :options="{ responsive: true }" />
                </div>
            </div>
        </div>
    </div>
</template>