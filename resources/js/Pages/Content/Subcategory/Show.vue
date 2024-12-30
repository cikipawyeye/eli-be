<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import { ContentCategory } from '@/Constants/ContentCategory';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { flashError, flashSuccess } from '@/Supports/helpers';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { onMounted, PropType, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import Delete from './Partials/Delete.vue';
import Edit from './Partials/Edit.vue';

defineProps({
    data: {
        type: Object as PropType<Subcategory>,
        required: false,
    },
});
const { success, error } = usePage<SharedProps>().props.flash;
const isEditing = ref(false);
const isDeleting = ref(false);

const { t } = useI18n();

const closeEditModal = () => {
    isEditing.value = false;
};

const closeDeleteModal = () => {
    isDeleting.value = false;
};

onMounted(() => {
    if (success) {
        flashSuccess(success);
    }

    if (error) {
        flashError(error);
    }
});
</script>

<template>
    <Head :title="data?.name" />

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
                <li v-if="data?.category" class="breadcrumb-item text-sm">
                    <Link
                        class="text-dark opacity-5"
                        :href="
                            route('subcategories.index', {
                                category: data.category,
                            })
                        "
                    >
                        {{ t(ContentCategory[data.category]) }}
                    </Link>
                </li>
                <li class="breadcrumb-item text-sm">
                    {{ t('subcategory') }}
                </li>
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    {{ data?.name }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-body">
                <div
                    class="card-header position-relative mt-n4 z-index-2 mx-3 p-0"
                >
                    <div
                        class="shadow-secondary border-radius-lg d-flex gap-3 p-3"
                    >
                        <h6 class="text-capitalize my-auto">
                            {{ data?.name }}
                        </h6>
                        <span
                            class="badge text-none my-auto"
                            :class="{
                                'badge-info': data?.is_active,
                                'badge-secondary': !data?.is_active,
                            }"
                            >{{
                                t(data?.is_active ? 'active' : 'inactive')
                            }}</span
                        >

                        <div class="d-flex align-items-center ms-auto gap-3">
                            <button
                                class="btn btn-info mb-0 text-nowrap"
                                @click="isEditing = true"
                            >
                                <i class="fa fa-pencil me-2"></i>
                                {{
                                    t('edit', {
                                        data: t('subcategory'),
                                    })
                                }}
                            </button>
                            <button
                                class="btn btn-danger mb-0 text-nowrap"
                                @click="isDeleting = true"
                            >
                                <i class="fa fa-trash me-2"></i>
                                {{
                                    t('delete', {
                                        data: t('subcategory'),
                                    })
                                }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body pb-2"></div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal :show="isEditing" id="edit-modal" @close="closeEditModal">
        <Edit v-if="data" v-on:close-modal="closeEditModal" />
    </Modal>

    <Modal :show="isDeleting" id="delete-modal" @close="closeDeleteModal">
        <Delete v-if="data" v-on:close-modal="closeDeleteModal" />
    </Modal>
</template>
