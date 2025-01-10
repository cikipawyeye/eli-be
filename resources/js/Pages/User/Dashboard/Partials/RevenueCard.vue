<script setup lang="ts">
import { formatMoney } from '@/Supports/helpers';
import { Deferred, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps<{
    range: 'today' | 'week' | 'month' | 'year';
}>()
const page = usePage<SharedProps & {
    revenue?: {
        current: number;
        previous: number;
    }
}>()

const range = computed(() => props.range);
const before = computed(() => {
    switch (range.value) {
        case 'today':
            return 'yesterday';
        case 'week':
            return 'last_week';
        case 'month':
            return 'last_month';
        case 'year':
            return 'last_year';
    }
});
const percentage = computed(() => {
    if (!page.props.revenue) {
        return 0;
    }

    if (!page.props.revenue.current && !page.props.revenue.previous) {
        return 0;
    }

    if (!page.props.revenue.previous) {
        return 100;
    }

    return ((page.props.revenue.current - page.props.revenue.previous) / page.props.revenue.previous) * 100;
});

const { t } = useI18n();

</script>

<template>
    <div class="card">
        <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-sm mb-0 text-capitalize">{{ t('revenue') }}</p>
                    <Deferred :data="['revenue']">
                        <template #fallback>
                            <h6 class="h6 text-secondary">Loading...</h6>
                        </template>
                        <h4 class="mb-0">{{ formatMoney(page.props.revenue?.current ?? 0) }}</h4>
                    </Deferred>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                    <i class="material-symbols-rounded opacity-10">weekend</i>
                </div>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm"><span :class="{
                'text-success': percentage > 0,
                'text-danger': percentage < 0,
            }" class="font-weight-bolder">{{ percentage }}%</span>
                {{ t('than', {
                    data: t(before)
                }) }}
            </p>
        </div>
    </div>
</template>