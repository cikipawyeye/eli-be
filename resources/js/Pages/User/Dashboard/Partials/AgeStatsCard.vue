<script setup lang="ts">
import { Deferred, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage<SharedProps & {
    ageStats: Record<'range0' | 'range1' | 'range2' | 'range3' | 'range4' | 'range5', number>;
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
                                {{ t('user') }}</th>
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
                                <Deferred :data="['ageStats']">
                                    <template #fallback>
                                        <p class="text-sm mb-0 text-secondary">Loading...</p>
                                    </template>
                                    <h6 class="mb-0 text-sm">{{ page.props.ageStats.range0 }}</h6>
                                </Deferred>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('user_age', {
                                    data: '18 - 25'
                                }) }}</h6>
                            </td>
                            <td>
                                <Deferred :data="['ageStats']">
                                    <template #fallback>
                                        <p class="text-sm mb-0 text-secondary">Loading...</p>
                                    </template>
                                    <h6 class="mb-0 text-sm">{{ page.props.ageStats.range1 }}</h6>
                                </Deferred>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('user_age', {
                                    data: '26 - 35'
                                }) }}</h6>
                            </td>
                            <td>
                                <Deferred :data="['ageStats']">
                                    <template #fallback>
                                        <p class="text-sm mb-0 text-secondary">Loading...</p>
                                    </template>
                                    <h6 class="mb-0 text-sm">{{ page.props.ageStats.range2 }}</h6>
                                </Deferred>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('user_age', {
                                    data: '36 - 45'
                                }) }}</h6>
                            </td>
                            <td>
                                <Deferred :data="['ageStats']">
                                    <template #fallback>
                                        <p class="text-sm mb-0 text-secondary">Loading...</p>
                                    </template>
                                    <h6 class="mb-0 text-sm">{{ page.props.ageStats.range3 }}</h6>
                                </Deferred>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0 text-sm">{{ t('user_age', {
                                    data: '46 - 55'
                                }) }}</h6>
                            </td>
                            <td>
                                <Deferred :data="['ageStats']">
                                    <template #fallback>
                                        <p class="text-sm mb-0 text-secondary">Loading...</p>
                                    </template>
                                    <h6 class="mb-0 text-sm">{{ page.props.ageStats.range4 }}</h6>
                                </Deferred>
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
                                <Deferred :data="['ageStats']">
                                    <template #fallback>
                                        <p class="text-sm mb-0 text-secondary">Loading...</p>
                                    </template>
                                    <h6 class="mb-0 text-sm">{{ page.props.ageStats.range5 }}</h6>
                                </Deferred>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>