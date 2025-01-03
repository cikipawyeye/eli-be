<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import { debounce } from '@/Supports/helpers';
import { Deferred, router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import AddContentForm from './AddContentForm.vue';
import ContentCard from './ContentCard.vue';
import DeleteContent from './DeleteContent.vue';
import EditContentForm from './EditContentForm.vue';

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
const isEditing = ref(false);
const isDeleting = ref(false);
const selectedContent = ref<Content | null>(null);
const type = ref<'premium_content' | 'non_premium_content' | null>(null);

const reloadContents = (payload: Record<string, string | number | null>) => {
    router.reload({
        only: ['contents', 'content_criteria'],
        data: {
            content: {
                ...criteria.value,
                ...payload,
            },
        },
        showProgress: true,
    });
};
const handleSearch = debounce(() =>
    reloadContents({ type: type.value, search: search.value, page: 1 }),
);
const handlePagination = ({
    per_page,
    page,
}: {
    per_page: number;
    page: number;
}) => {
    reloadContents({ limit: per_page, page });
};
watch(
    () => type.value,
    () => reloadContents({ type: type.value, search: search.value, page: 1 }),
);

const closeAddModal = () => {
    isAdding.value = false;
};

const editContent = (content: Content) => {
    selectedContent.value = content;
    isEditing.value = true;
};

const closeEditModal = () => {
    isEditing.value = false;
    selectedContent.value = null;
};

const deleteContent = (content: Content) => {
    selectedContent.value = content;
    isDeleting.value = true;
};

const closeDeleteModal = () => {
    isDeleting.value = false;
    selectedContent.value = null;
};
</script>

<template>
    <div>
        <div class="d-flex align-items-center my-2 ms-auto flex-wrap gap-3">
            <div class="d-flex gap-3">
                <InputGroup>
                    <input
                        v-model="search"
                        id="search"
                        type="search"
                        class="form-control"
                        :placeholder="
                            t('search', {
                                data: t('content'),
                            })
                        "
                        @input="handleSearch"
                    />
                </InputGroup>
                <InputGroup>
                    <select v-model="type" class="form-control">
                        <option :value="null">All Content Type</option>
                        <option value="premium_content">
                            {{ t('premium_content') }}
                        </option>
                        <option value="non_premium_content">
                            {{ t('non_premium_content') }}
                        </option>
                    </select>
                </InputGroup>
            </div>
            <button
                class="btn bg-gradient-primary mb-0 ms-auto text-nowrap"
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

        <div class="row">
            <Deferred :data="['contents']">
                <template #fallback>
                    <div class="d-flex p-4">
                        <div class="spinner-border mx-auto" role="status">
                            <span class="sr-only">{{ t('loading_data') }}</span>
                        </div>
                    </div>
                </template>

                <div
                    v-for="content in data?.data"
                    :key="content.id"
                    class="col-6 col-md-4 col-xl-3 d-flex align-items-stretch"
                >
                    <ContentCard
                        :content="content"
                        v-on:edit="editContent"
                        v-on:destroy="deleteContent"
                    />
                </div>

                <div v-if="!data || data?.data.length < 1">
                    <p class="text-secondary py-6 text-center">
                        <span>{{
                            criteria?.search ? t('no_data_found') : t('no_data')
                        }}</span>
                    </p>
                </div>
            </Deferred>
        </div>

        <div v-if="meta" class="card-footer">
            <Pagination :meta="meta" v-on:navigate="handlePagination" />
        </div>
    </div>

    <Modal id="add-content-modal" :show="isAdding" @close="closeAddModal">
        <AddContentForm
            v-if="page.props.data?.id && isAdding"
            :subcategory_id="page.props.data?.id"
            v-on:close-modal="closeAddModal"
        />
    </Modal>

    <Modal :show="isEditing" id="edit-content-modal" @close="closeEditModal">
        <EditContentForm
            :content="selectedContent ?? undefined"
            v-on:close-modal="closeEditModal"
        />
    </Modal>

    <Modal
        :show="isDeleting"
        id="delete-content-modal"
        @close="closeDeleteModal"
    >
        <DeleteContent
            :content="selectedContent ?? undefined"
            v-on:close-modal="closeDeleteModal"
        />
    </Modal>
</template>
