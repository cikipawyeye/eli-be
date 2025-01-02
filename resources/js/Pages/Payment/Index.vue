<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    debounce,
    flashError,
    flashSuccess,
    formatHumanDateTime,
    formatMoney,
    rowNumber,
} from '@/Supports/helpers';
import { Deferred, Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, PropType, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    data: {
        type: Object as PropType<PaginatedResponseData<Payment>>,
        required: false,
    },
    criteria: {
        type: Object as PropType<{
            search: string | null;
        }>,
        required: false,
    },
});
const { success, error } = usePage<SharedProps>().props.flash;
const meta = computed(() => props.data?.meta);
const search = ref('');

const reloadContent = (payload: Record<string, string | number | null>) => {
    router.reload({
        only: ['data'],
        data: {
            ...props.criteria,
            ...payload,
        },
        showProgress: true,
    });
};

const handleSearch = debounce(() => {
    reloadContent({ search: search.value });
});
const handlePagination = ({
    per_page,
    page,
}: {
    per_page: number;
    page: number;
}) => reloadContent({ page, limit: per_page });

onMounted(() => {
    search.value = props.criteria?.search ?? '';
    if (success) {
        flashSuccess(success);
    }
    if (error) {
        flashError(error);
    }
});
</script>

<template>
    <Head :title="t('payments')" />

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
                    {{ t('payments') }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div class="shadow-secondary border-radius-lg d-flex gap-4 p-3">
                    <h6 class="text-capitalize my-auto">
                        {{ t('payments') }}
                    </h6>

                    <div class="d-flex align-items-center ms-auto gap-3">
                        <InputGroup>
                            <input
                                v-model="search"
                                id="search"
                                type="search"
                                class="form-control form-control-sm"
                                placeholder="Search"
                                @input="handleSearch"
                            />
                        </InputGroup>
                    </div>
                </div>
            </div>

            <div class="card-body pb-2">
                <div class="table-responsive p-0">
                    <table class="align-items-center mb-0 table">
                        <thead>
                            <tr>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    #
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('user') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('jumlah') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('status') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('date') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <Deferred :data="['data']">
                                <template #fallback>
                                    <tr>
                                        <td
                                            colspan="6"
                                            class="text-secondary py-6 text-center"
                                        >
                                            <span>{{ t('loading_data') }}</span>
                                        </td>
                                    </tr>
                                </template>

                                <tr
                                    v-for="(payment, index) in data?.data"
                                    :key="payment.id"
                                >
                                    <td class="ps-4">
                                        <span
                                            class="font-weight-bold mb-0 text-sm"
                                            >{{
                                                rowNumber(
                                                    index,
                                                    data?.meta?.from ?? 1,
                                                )
                                            }}.</span
                                        >
                                    </td>
                                    <td>
                                        <Link
                                            :href="
                                                route('users.show', {
                                                    user: payment.user_id,
                                                })
                                            "
                                        >
                                            <h6 class="mb-0 text-sm">
                                                {{ payment.user?.name ?? '-' }}
                                            </h6>
                                        </Link>
                                    </td>
                                    <td class="text-sm">
                                        <span
                                            class="font-weight-bold mb-0 text-sm"
                                            >{{
                                                formatMoney(payment.amount)
                                            }}</span
                                        >
                                    </td>
                                    <td class="text-sm">
                                        <span
                                            class="font-weight-bold mb-0 text-sm"
                                            >{{ payment.state }}</span
                                        >
                                    </td>
                                    <td class="text-sm">
                                        <span
                                            class="font-weight-bold mb-0 text-sm"
                                            >{{
                                                payment.created_at
                                                    ? formatHumanDateTime(
                                                          payment.created_at,
                                                      )
                                                    : '-'
                                            }}</span
                                        >
                                    </td>
                                </tr>

                                <tr v-if="!data || data?.data.length < 1">
                                    <td
                                        colspan="6"
                                        class="text-secondary py-6 text-center"
                                    >
                                        <span>{{
                                            criteria?.search
                                                ? t('no_data_found')
                                                : t('no_data')
                                        }}</span>
                                    </td>
                                </tr>
                            </Deferred>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="meta" class="card-footer">
                <Pagination :meta="meta" v-on:navigate="handlePagination" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
