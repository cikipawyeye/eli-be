<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Pagination from '@/Components/Pagination.vue';
import { ContentCategory } from '@/Constants/ContentCategory';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { debounce, rowNumber } from '@/Supports/helpers';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, onMounted, PropType, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps({
    data: {
        type: Object as PropType<PaginatedResponseData<Subcategory>>,
        required: false,
    },
    criteria: {
        type: Object as PropType<{ search: string | null; category: 0 | 1 }>,
        required: false,
    },
});
const meta = computed(() => props.data?.meta);

const { t } = useI18n();

const loading = ref(false);
const category = computed(() => {
    if (
        props.criteria?.category !== undefined &&
        props.criteria?.category !== null
    ) {
        return props.criteria.category in Object.keys(ContentCategory)
            ? t(ContentCategory[props.criteria.category])
            : t('subcategories');
    }

    return t('motivation');
});

const search = ref('');
const handleSearch = debounce(() => {
    router.reload({
        only: ['data'],
        data: {
            search: search.value,
        },
        showProgress: true,
    });
});

const handlePagination = ({
    per_page,
    page,
}: {
    per_page: number;
    page: number;
}) => {
    router.reload({
        only: ['data'],
        data: {
            page,
            limit: per_page,
        },
        showProgress: true,
    });
};

onMounted(() => {
    search.value = props.criteria?.search ?? '';
    router.reload({
        only: ['data'],
        data: {
            search: search.value,
        },
        onStart: () => (loading.value = true),
        onFinish: () => (loading.value = false),
    });
});
</script>

<template>
    <Head :title="category" />

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
                <li class="breadcrumb-item text-sm">{{ t('content') }}</li>
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    {{ category }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div class="shadow-dark border-radius-lg d-flex gap-4 p-3">
                    <h6 class="text-capitalize mb-1">
                        {{ category }}
                    </h6>

                    <div class="ms-auto">
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
                                    {{ t('subcategory') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('status') }}
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(subcategory, index) in data?.data"
                                :key="subcategory.id"
                            >
                                <td class="ps-4">
                                    <span class="font-weight-bold mb-0 text-sm"
                                        >{{
                                            rowNumber(
                                                index,
                                                data?.meta?.from ?? 1,
                                            )
                                        }}.</span
                                    >
                                </td>
                                <td>
                                    <h6 class="mb-0 text-sm">
                                        {{ subcategory.name }}
                                    </h6>
                                </td>
                                <td class="text-sm">
                                    <span
                                        class="badge badge-sm bg-gradient-success"
                                        >{{
                                            t(
                                                subcategory.is_active
                                                    ? 'active'
                                                    : 'inactive',
                                            )
                                        }}</span
                                    >
                                </td>
                                <td class="align-middle">
                                    <a
                                        href="javascript:;"
                                        class="text-secondary font-weight-bold text-xs"
                                        data-toggle="tooltip"
                                        data-original-title="Edit"
                                    >
                                        Edit
                                    </a>
                                </td>
                            </tr>

                            <tr v-if="!data || data?.data.length < 1">
                                <td
                                    colspan="4"
                                    class="text-secondary py-6 text-center"
                                >
                                    <span v-if="loading">{{
                                        t('loading_data')
                                    }}</span>

                                    <span v-else>{{
                                        criteria?.search
                                            ? t('no_data_found')
                                            : t('no_data')
                                    }}</span>
                                </td>
                            </tr>
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
