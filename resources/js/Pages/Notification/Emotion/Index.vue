<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Permissions } from '@/Permission';
import { can, debounce, rowNumber } from '@/Supports/helpers';
import { Deferred, Head, Link, router } from '@inertiajs/vue3';
import { computed, PropType, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import Modal from './Partials/Modal.vue';

const { t } = useI18n();

const props = defineProps({
    data: {
        type: Object as PropType<PaginatedResponseData<Emotion>>,
        required: false,
    },
});

const urlQuery = new URLSearchParams(window.location.search);

const meta = computed(() => props.data?.meta);
const criteria = computed(() => {
    const obj: Record<string, string> = {};
    urlQuery.forEach((value, key) => {
        obj[key] = value;
    });
    return obj;
});
const search = ref(urlQuery.get('search') ?? '');

const isShowingModal = ref<boolean>(false);

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
    reloadContent({ search: search.value });
});

const handlePagination = ({
    per_page,
    page,
}: {
    per_page: number;
    page: number;
}) => reloadContent({ page, limit: per_page });
</script>

<template>
    <Head :title="t('reminder_notification')" />

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
                    {{ t('emotion') }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div
                    class="shadow-secondary border-radius-lg d-flex gap-4 p-3 flex-wrap"
                >
                    <h6 class="text-capitalize my-auto">
                        {{ t('emotion') }}
                    </h6>

                    <div
                        class="d-flex align-items-center ms-auto gap-3 flex-sm-nowrap flex-wrap"
                    >
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
                    <button
                        v-if="can($page, Permissions.ADD_EMOTION)"
                        @click="isShowingModal = true"
                        class="btn btn-primary btn-sm mb-0 text-nowrap"
                    >
                        <i class="fa fa-plus"></i>
                        <span class="ms-2 d-none d-sm-inline">{{
                            t('add', {
                                data: t('emotions'),
                            })
                        }}</span>
                    </button>
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
                                    {{ t('emotion_name') }}
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                >
                                    {{ t('emotion_messages_count') }}
                                </th>
                                <th
                                    v-if="can($page, Permissions.READ_EMOTION)"
                                    class="text-secondary opacity-7"
                                ></th>
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
                                    v-for="(item, index) in data?.data"
                                    :key="item.id"
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
                                    <td class="text-sm">
                                        {{ item.name }}
                                    </td>
                                    <td class="text-sm">
                                        {{ item.messages_count }}
                                    </td>
                                    <td
                                        v-if="
                                            can($page, Permissions.READ_EMOTION)
                                        "
                                        class="align-middle"
                                    >
                                        <Link
                                            :href="
                                                route('emotions.show', item.id)
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

        <Modal
            :show="isShowingModal"
            :emotion="null"
            @close="isShowingModal = false"
        />
    </AuthenticatedLayout>
</template>
