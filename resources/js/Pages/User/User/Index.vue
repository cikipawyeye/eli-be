<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Permissions } from '@/Permission';
import { debounce, formatHumanDateTime, rowNumber } from '@/Supports/helpers';
import { Deferred, Head, Link, router } from '@inertiajs/vue3';
import { computed, onMounted, PropType, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    data: {
        type: Object as PropType<PaginatedResponseData<User>>,
        required: false,
    },
    criteria: {
        type: Object as PropType<{
            search: string | null;
        }>,
        required: false,
    },
});
const meta = computed(() => props.data?.meta);
const criteria = computed(() => props.criteria);
const premium = ref<'true' | 'false' | null>(null);
const search = ref('');

const reloadContent = (payload: Record<string, string | number | null>) => {
    router.reload({
        only: ['data'],
        data: {
            ...criteria.value,
            ...payload,
        },
        showProgress: true,
    });
};

const handleSearch = debounce(() => {
    reloadContent({ search: search.value, is_premium: premium.value });
});
const handlePagination = ({
    per_page,
    page,
}: {
    per_page: number;
    page: number;
}) => reloadContent({ page, limit: per_page });
watch(
    () => premium.value,
    () => reloadContent({ is_premium: premium.value, search: search.value }),
);

onMounted(() => {
    search.value = props.criteria?.search ?? '';
});
</script>

<template>
    <Head :title="t('users')" />

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
                    {{ t('users') }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div
                    class="shadow-secondary border-radius-lg d-flex gap-4 p-3 flex-wrap"
                >
                    <h6 class="text-capitalize my-auto">
                        {{ t('users') }}
                    </h6>

                    <div
                        class="d-flex align-items-center ms-auto gap-3 flex-sm-nowrap flex-wrap"
                    >
                        <InputGroup>
                            <select
                                v-model="premium"
                                class="form-control form-control-sm"
                            >
                                <option :value="null">
                                    All Account Status
                                </option>
                                <option value="true">
                                    {{ t('premium') }}
                                </option>
                                <option value="false">
                                    {{ t('regular') }}
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
                        v-if="
                            (
                                $page.props?.auth.user?.permissions_by_roles ??
                                []
                            ).includes(Permissions.ADD_USER)
                        "
                        :href="route('users.create')"
                    >
                        <button class="btn btn-primary btn-sm mb-0 text-nowrap">
                            <i class="fa fa-plus"></i>
                            <span class="ms-2 d-none d-sm-inline">{{
                                t('add', {
                                    data: t('user'),
                                })
                            }}</span>
                        </button>
                    </Link>
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
                                    {{ t('account_status') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('name') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('email') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('registered_at') }}
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <Deferred :data="['data']">
                                <template #fallback>
                                    <tr>
                                        <td
                                            colspan="7"
                                            class="text-secondary py-6 text-center"
                                        >
                                            <span>{{ t('loading_data') }}</span>
                                        </td>
                                    </tr>
                                </template>

                                <tr
                                    v-for="(user, index) in data?.data"
                                    :key="user.id"
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
                                        <span
                                            v-if="user.is_premium"
                                            class="badge bg-gradient-primary badge-sm"
                                            >Premium</span
                                        >
                                        <span
                                            v-else
                                            class="badge badge-secondary badge-sm"
                                            >Regular</span
                                        >
                                    </td>
                                    <td>
                                        <Link
                                            :href="
                                                route('users.show', {
                                                    user: user.id,
                                                })
                                            "
                                        >
                                            <h6 class="mb-0 text-sm">
                                                {{ user.name }}
                                            </h6>
                                        </Link>
                                    </td>
                                    <td class="text-sm">
                                        <span
                                            class="font-weight-bold mb-0 text-sm"
                                            >{{ user.email }}</span
                                        >
                                    </td>
                                    <td class="text-sm">
                                        <span
                                            class="font-weight-bold mb-0 text-sm"
                                            >{{
                                                user.created_at
                                                    ? formatHumanDateTime(
                                                          user.created_at,
                                                      )
                                                    : '-'
                                            }}</span
                                        >
                                    </td>
                                    <td class="align-middle">
                                        <Link
                                            :href="
                                                route('users.show', {
                                                    user: user.id,
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
                                        colspan="7"
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
