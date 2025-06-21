<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Pagination from '@/Components/Pagination.vue';
import { Permissions } from '@/Permission';
import { can, debounce, rowNumber } from '@/Supports/helpers';
import { Deferred, router } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';
import Modal from './Modal.vue';

const props = defineProps<{
    messages?: PaginatedResponseData<Message>;
    emotion: Emotion;
}>();
const meta = computed(() => props.messages?.meta);
const urlQuery = new URLSearchParams(window.location.search);
const criteria = computed(() => {
    const obj: Record<string, string> = {};
    urlQuery.forEach((value, key) => {
        obj[key] = value;
    });
    return obj;
});

const state = reactive({
    isShowingModal: false,
    selected: null as Message | null,
    isDeleting: false,
});

const reloadContent = (payload: Record<string, string | number | null>) => {
    router.reload({
        only: ['messages'],
        data: {
            ...criteria.value,
            ...payload,
        },
        showProgress: true,
    });
};

const handleSearch = debounce(() => {
    reloadContent({ search: criteria.value.search });
});

const handlePagination = ({
    per_page,
    page,
}: {
    per_page: number;
    page: number;
}) => reloadContent({ page, limit: per_page });

const setIsAdding = () => {
    state.selected = null;
    state.isDeleting = false;
    state.isShowingModal = true;
};

const setIsEditing = (item: Message) => {
    state.selected = item;
    state.isDeleting = false;
    state.isShowingModal = true;
};

const setIsDeleting = (item: Message) => {
    state.selected = item;
    state.isDeleting = true;
    state.isShowingModal = true;
};
</script>

<template>
    <div class="card mt-3">
        <div class="card-header p-0">
            <div class="border-radius-lg d-flex gap-4 p-3 flex-wrap">
                <h6 class="text-capitalize my-auto">
                    {{ $t('message_list') }}
                </h6>

                <div
                    class="d-flex align-items-center ms-auto gap-3 flex-sm-nowrap flex-wrap"
                >
                    <InputGroup>
                        <input
                            v-model="criteria.search"
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
                    @click="setIsAdding"
                    class="btn btn-primary btn-sm mb-0 text-nowrap"
                >
                    <i class="fa fa-plus"></i>
                    <span class="ms-2 d-none d-sm-inline">{{
                        $t('add', {
                            data: $t('message'),
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
                                {{ $t('name') }}
                            </th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <Deferred :data="['messages']">
                            <template #fallback>
                                <tr>
                                    <td
                                        colspan="7"
                                        class="text-secondary py-6 text-center"
                                    >
                                        <span>{{ $t('loading_data') }}</span>
                                    </td>
                                </tr>
                            </template>

                            <tr
                                v-for="(item, index) in messages?.data"
                                :key="item.id"
                            >
                                <td class="ps-4">
                                    <span class="font-weight-bold mb-0 text-sm"
                                        >{{
                                            rowNumber(
                                                index,
                                                messages?.meta?.from ?? 1,
                                            )
                                        }}.</span
                                    >
                                </td>
                                <td class="text-sm">
                                    {{ item.content }}
                                </td>
                                <td class="align-middle">
                                    <div
                                        class="d-flex gap-5 justify-content-center"
                                    >
                                        <a
                                            href="javascript:void(0)"
                                            @click="setIsEditing(item)"
                                            class="text-secondary font-weight-bold text-xs my-auto"
                                        >
                                            <i class="fa fa-pencil me-1"></i>
                                            {{ $t('edit') }}
                                        </a>
                                        <a
                                            href="javascript:void(0)"
                                            @click="setIsDeleting(item)"
                                            class="text-secondary font-weight-bold text-xs my-auto text-danger"
                                        >
                                            <i class="fa fa-trash me-1"></i>
                                            {{ $t('delete') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="!messages || messages?.data.length < 1">
                                <td
                                    colspan="7"
                                    class="text-secondary py-6 text-center"
                                >
                                    <span>{{
                                        criteria?.search
                                            ? $t('no_data_found')
                                            : $t('no_data')
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
        :show="state.isShowingModal"
        :message="state.selected"
        :emotion="emotion"
        :is-deleting="state.isDeleting"
        @close="state.isShowingModal = false"
    />
</template>
