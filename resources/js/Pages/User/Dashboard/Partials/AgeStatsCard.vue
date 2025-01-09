<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage<SharedProps & {
    premiumUser: number;
    nonPremiumUser: number;
    ageStats: Record<'range0'  | 'range1' | 'range2' | 'range3' | 'range4' | 'range5', number>;
}>()

const { t } = useI18n();
</script>

<template>
    <div class="card w-100">
        <div class="card-header pb-0">
            <h6>{{ t('age') }}</h6>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                {{ t('range') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                {{ t('amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('less_than', {
                                    data: t('user_age', {
                                        data: '18'
                                    })
                                }) }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm">{{ page.props.ageStats.range0 }} {{ t('users') }}</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('user_age', {
                                    data: '18 - 25'
                                }) }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm">{{ page.props.ageStats.range1 }} {{ t('users') }}</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('user_age', {
                                    data: '26 - 35'
                                }) }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm">{{ page.props.ageStats.range2 }} {{ t('users') }}</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('user_age', {
                                    data: '36 - 45'
                                }) }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm">{{ page.props.ageStats.range3 }} {{ t('users') }}</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('user_age', {
                                    data: '46 - 55'
                                }) }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm">{{ page.props.ageStats.range4 }} {{ t('users') }}</h6>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('more_than', {
                                    data: t('user_age', {
                                        data: '55'
                                    })
                                }) }}</h6>
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm">{{ page.props.ageStats.range5 }} {{ t('users') }}</h6>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>