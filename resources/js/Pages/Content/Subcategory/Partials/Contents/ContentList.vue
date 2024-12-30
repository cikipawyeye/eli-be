<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import { debounce, rowNumber } from '@/Supports/helpers';
import { Deferred, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import AddContentForm from './AddContentForm.vue';

const { t } = useI18n();

const page = usePage<
    {
        data?: Subcategory;
        contents?: PaginatedResponseData<Content>;
        content_criteria?: Record<string, string | number>;
    } & SharedProps
>();
const data = computed(() => page.props.contents);
const meta = computed(() => page.props.contents?.meta);
const criteria = computed(() => page.props.content_criteria);
const search = ref('');
const isAdding = ref(false);

const handleSearch = debounce(() => {
    router.reload({
        only: ['contents', 'content_criteria'],
        data: {
            content: { search: search.value },
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
        only: ['contents', 'content_criteria'],
        data: {
            content: {
                ...criteria.value,
                limit: per_page,
                page,
            },
        },
        showProgress: true,
    });
};

const closeAddModal = () => {
    isAdding.value = false;
};
</script>

<template>
    <div>
        <div class="d-flex align-items-center ms-auto flex-wrap gap-3">
            <div>
                <InputGroup>
                    <input
                        v-model="search"
                        id="search"
                        type="search"
                        class="form-control form-control-sm"
                        :placeholder="
                            t('search', {
                                data: t('content'),
                            })
                        "
                        @input="handleSearch"
                    />
                </InputGroup>
            </div>
            <button
                class="btn btn-primary btn-sm mb-0 ms-auto text-nowrap"
                @click="isAdding = true"
            >
                <i class="fa fa-plus"></i>
                <span class="d-none d-md-inline ms-2">{{
                    t('add', {
                        data: t('content'),
                    })
                }}</span>
            </button>
        </div>

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
                            ID
                        </th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                        >
                            {{ t('title') }}
                        </th>
                        <th class="text-secondary opacity-7"></th>
                    </tr>
                </thead>
                <tbody>
                    <Deferred :data="['contents']">
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
                            v-for="(content, index) in data?.data"
                            :key="content.id"
                        >
                            <td class="ps-4">
                                <span class="font-weight-bold mb-0 text-sm"
                                    >{{
                                        rowNumber(index, data?.meta?.from ?? 1)
                                    }}.</span
                                >
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm">#{{ content.id }}</h6>
                            </td>
                            <td>{{ content.title }}</td>
                        </tr>

                        <tr v-if="!data || data?.data.length < 1">
                            <td
                                colspan="4"
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

        <div v-if="meta" class="card-footer">
            <Pagination :meta="meta" v-on:navigate="handlePagination" />
        </div>
    </div>

    <Modal id="add-content-modal" :show="isAdding" @close="closeAddModal">
        <AddContentForm
            v-if="page.props.data?.id"
            :subcategory_id="page.props.data?.id"
            v-on:close-modal="closeAddModal"
        />
    </Modal>
</template>
