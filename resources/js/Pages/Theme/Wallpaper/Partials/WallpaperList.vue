<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import { debounce } from '@/Supports/helpers';
import { Deferred, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import AddWallpaperForm from './AddWallpaperForm.vue';
import DeleteWallpaper from './DeleteWallpaper.vue';
import WallpaperCard from './WallpaperCard.vue';

const { t } = useI18n();

const page = usePage<
    {
        data?: PaginatedResponseData<Wallpaper>;
        criteria?: Record<string, string | number>;
    } & SharedProps
>();
const data = computed(() => page.props.data);
const meta = computed(() => page.props.data?.meta);
const criteria = computed(() => page.props.criteria);
const search = ref('');
const isAdding = ref(false);
const isDeleting = ref(false);
const selectedContent = ref<Wallpaper | null>(null);

const reloadContents = (payload: Record<string, string | number | null>) => {
    router.reload({
        only: ['data', 'criteria'],
        data: {
            ...criteria.value,
            ...payload,
        },
        showProgress: true,
    });
};
const handleSearch = debounce(() =>
    reloadContents({ search: search.value, page: 1 }),
);
const handlePagination = ({
    per_page,
    page,
}: {
    per_page: number;
    page: number;
}) => {
    reloadContents({ limit: per_page, page, search: search.value });
};

const closeAddModal = () => {
    isAdding.value = false;
};

const deleteContent = (item: Wallpaper) => {
    selectedContent.value = item;
    isDeleting.value = true;
};

const closeDeleteModal = () => {
    isDeleting.value = false;
    selectedContent.value = null;
};

onMounted(() => {
    search.value = (criteria.value?.search as string) ?? '';
});
</script>

<template>
    <div>
        <div class="d-flex align-items-center my-2 ms-auto flex-wrap gap-3">
            <div class="d-flex gap-3 flex-sm-nowrap flex-wrap">
                <InputGroup>
                    <input
                        v-model="search"
                        id="search"
                        type="search"
                        class="form-control"
                        :placeholder="
                            t('search', {
                                data: t('wallpaper'),
                            })
                        "
                        @input="handleSearch"
                    />
                </InputGroup>
            </div>
            <button
                class="btn bg-gradient-primary mb-0 ms-auto text-nowrap"
                @click="isAdding = true"
            >
                <i class="fa fa-plus"></i>
                <span class="d-none d-md-inline ms-2">{{
                    t('add', {
                        data: t('wallpaper'),
                    })
                }}</span>
            </button>
        </div>

        <div class="row">
            <Deferred :data="['data']">
                <template #fallback>
                    <div class="d-flex p-4">
                        <div class="spinner-border mx-auto" role="status">
                            <span class="sr-only">{{ t('loading_data') }}</span>
                        </div>
                    </div>
                </template>

                <div
                    v-for="wallpaper in data?.data"
                    :key="wallpaper.id"
                    class="col-12 col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch"
                >
                    <WallpaperCard
                        :wallpaper="wallpaper"
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

    <Modal id="add-wallpaper-modal" :show="isAdding" @close="closeAddModal">
        <AddWallpaperForm v-if="isAdding" v-on:close-modal="closeAddModal" />
    </Modal>

    <Modal
        :show="isDeleting"
        id="delete-wallpaper-modal"
        @close="closeDeleteModal"
    >
        <DeleteWallpaper
            :wallpaper="selectedContent ?? undefined"
            v-on:close-modal="closeDeleteModal"
        />
    </Modal>
</template>
