<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Pagination from '@/Components/Pagination.vue';
import { ContentCategory } from '@/Constants/ContentCategory';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { debounce, flashSuccess, rowNumber } from '@/Supports/helpers';
import { Deferred, Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, PropType, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    data: {
        type: Object as PropType<PaginatedResponseData<Subcategory>>,
        required: false,
    },
    criteria: {
        type: Object as PropType<{
            category: 0 | 1;
            search: string | null;
            type: 'active' | 'inactive' | null;
        }>,
        required: false,
    },
});
const success = usePage<SharedProps>().props.flash.success;
const meta = computed(() => props.data?.meta);
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
const type = ref<'active' | 'inactive' | null>(null);
const access = ref<'premium' | 'non_premium' | null>(null);

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

const handlePagination = ({
    per_page,
    page,
}: {
    per_page: number;
    page: number;
}) => reloadContent({ page, limit: per_page });

const handleSearch = debounce(() => {
    reloadContent({
        access: access.value,
        type: type.value,
        search: search.value,
        page: 1,
    });
});

watch(
    () => access.value,
    () =>
        reloadContent({
            access: access.value,
            type: type.value,
            search: search.value,
            page: 1,
        }),
);

watch(
    () => type.value,
    () =>
        reloadContent({
            access: access.value,
            type: type.value,
            search: search.value,
            page: 1,
        }),
);

onMounted(() => {
    search.value = props.criteria?.search ?? '';
    if (success) {
        flashSuccess(success);
    }
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
                <div
                    class="shadow-secondary border-radius-lg d-flex gap-4 p-3 flex-sm-nowrap flex-wrap"
                >
                    <h6 class="text-capitalize my-auto">
                        {{ category }}
                    </h6>

                    <div
                        class="d-flex align-items-center ms-auto gap-3 flex-sm-nowrap flex-wrap"
                    >
                        <InputGroup>
                            <select
                                v-model="access"
                                class="form-control form-control-sm"
                            >
                                <option :value="null">All Access</option>
                                <option value="premium">
                                    {{ t('premium_user_only') }}
                                </option>
                                <option value="non_premium">
                                    {{ t('all_users') }}
                                </option>
                            </select>
                        </InputGroup>
                        <InputGroup>
                            <select
                                v-model="type"
                                class="form-control form-control-sm"
                            >
                                <option :value="null">All Status</option>
                                <option value="active">
                                    {{ t('active') }}
                                </option>
                                <option value="inactive">
                                    {{ t('inactive') }}
                                </option>
                            </select>
                        </InputGroup>
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

                    <Link
                        :href="
                            route('subcategories.create', {
                                _query: {
                                    category: criteria?.category,
                                },
                            })
                        "
                    >
                        <button class="btn btn-primary btn-sm mb-0 text-nowrap">
                            <i class="fa fa-plus me-2"></i>
                            {{
                                t('create', {
                                    data: t('subcategory'),
                                })
                            }}
                        </button></Link
                    >
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
                                    {{ t('content') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('access') }}
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
                            <Deferred :data="['data']">
                                <template #fallback>
                                    <tr>
                                        <td
                                            colspan="4"
                                            class="text-secondary py-6 text-center"
                                        >
                                            <span>{{ t('loading_data') }}</span>
                                        </td>
                                    </tr>
                                </template>

                                <tr
                                    v-for="(subcategory, index) in data?.data"
                                    :key="subcategory.id"
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
                                                route('subcategories.show', {
                                                    subcategory: subcategory.id,
                                                })
                                            "
                                        >
                                            <h6 class="mb-0 text-sm">
                                                {{ subcategory.name }}
                                            </h6>
                                        </Link>
                                    </td>
                                    <td class="ps-4">
                                        <span
                                            class="font-weight-bold mb-0 text-sm"
                                            >{{
                                                subcategory.contents_count
                                            }}</span
                                        >
                                    </td>
                                    <td class="text-sm">
                                        <span
                                            class="badge text-none my-auto"
                                            :class="{
                                                'badge-info':
                                                    subcategory.premium,
                                                'badge-secondary':
                                                    !subcategory.premium,
                                            }"
                                            >{{
                                                t(
                                                    subcategory.premium
                                                        ? 'premium_user_only'
                                                        : 'all_users',
                                                )
                                            }}</span
                                        >
                                    </td>
                                    <td class="text-sm">
                                        <span
                                            class="badge text-none my-auto"
                                            :class="{
                                                'badge-info':
                                                    subcategory.is_active,
                                                'badge-secondary':
                                                    !subcategory.is_active,
                                            }"
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
                                        <Link
                                            :href="
                                                route('subcategories.show', {
                                                    subcategory: subcategory.id,
                                                })
                                            "
                                            class="text-secondary font-weight-bold text-xs"
                                        >
                                            {{ t('detail') }}
                                        </Link>
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
