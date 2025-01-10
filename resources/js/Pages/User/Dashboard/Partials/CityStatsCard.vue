<script setup lang="ts">
import CursorPagination from '@/Components/CursorPagination.vue';
import { toTitleCase } from '@/Supports/helpers';
import { Deferred, router, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage<SharedProps & {
    topCities: CursorPaginatedResponseData['meta'] & {
        data: {
            name: string;
            users_count: number;
        }[];
    };
}>()

const { t } = useI18n();

const reload = (cursor: {
    cursor: string | null;
    per_page: number;
}) => {
    router.reload({
        only: ['topCities'],
        data: {
            city_cursor: cursor.cursor,
        }
    })
}
</script>

<template>
    <div class="card w-100">
        <div class="card-header pb-0 d-flex">
            <h6>{{ t('city') }}</h6>

            <CursorPagination v-if="page.props.topCities" :meta="page.props.topCities" v-on:navigate="reload"
                :withPageSetting="false" size="sm" />
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
                        <Deferred :data="['topCities']">
                            <template #fallback>
                                <tr>
                                    <td colspan="4">
                                        <p class="text-center text-sm mb-0 text-secondary">Loading...</p>
                                    </td>
                                </tr>
                            </template>
                            <tr v-for="city, index in page.props.topCities.data" :key="index">
                                <td class="ps-4">
                                    <h6 v-if="city.name" class="mb-0 text-sm">{{ toTitleCase(city.name) }}</h6>
                                    <h6 v-else class="mb-0 text-sm text-secondary">{{ t('unknown') }}</h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 text-sm">{{ city.users_count }} {{ t('users') }}</h6>
                                </td>
                            </tr>
                        </Deferred>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>