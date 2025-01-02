<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Permissions } from '@/Permission';
import {
    flashError,
    flashSuccess,
    formatHumanDateTime,
} from '@/Supports/helpers';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, PropType, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import Delete from './Partials/Delete.vue';
import Edit from './Partials/Edit.vue';

const props = defineProps({
    data: {
        type: Object as PropType<User>,
        required: true,
    },
});
const user = computed(() => props.data);
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
                <li class="breadcrumb-item text-sm">{{ t('users') }}</li>
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    {{ data?.name }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div
                    class="shadow-secondary border-radius-lg d-flex flex-wrap gap-4 p-3"
                >
                    <h6 class="text-capitalize my-auto">
                        {{ user?.name }}
                    </h6>

                    <div
                        class="d-flex align-items-center justify-content-end ms-auto flex-wrap gap-3"
                    >
                        <button
                            v-if="
                                (
                                    $page.props?.auth.user
                                        ?.permissions_by_roles ?? []
                                ).includes(Permissions.EDIT_USER)
                            "
                            :href="route('users.create')"
                            class="btn btn-sm btn-warning mb-0 text-nowrap"
                            @click="isEditing = true"
                        >
                            <i class="fa fa-pencil"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                t('edit', {
                                    data: t('user'),
                                })
                            }}</span>
                        </button>
                        <button
                            v-if="
                                (
                                    $page.props?.auth.user
                                        ?.permissions_by_roles ?? []
                                ).includes(Permissions.DELETE_USER)
                            "
                            :href="route('users.create')"
                            class="btn btn-sm btn-danger mb-0 text-nowrap"
                            @click="isDeleting = true"
                        >
                            <i class="fa fa-trash"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                t('delete', {
                                    data: t('user'),
                                })
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <ul class="list-group m-4">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">{{ t('name') }}:</strong>
                        &nbsp;
                        {{ user.name }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">{{ t('email') }}:</strong>
                        &nbsp;
                        {{ user.email }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark"
                            >{{ t('email_verified_at') }}:</strong
                        >
                        &nbsp;
                        {{ user.email_verified_at ?? t('not_verified') }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark"
                            >{{ t('registered_at') }}:</strong
                        >
                        &nbsp;
                        {{
                            user.created_at
                                ? formatHumanDateTime(user.created_at)
                                : ''
                        }}
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal
        v-if="
            ($page.props?.auth.user?.permissions_by_roles ?? []).includes(
                Permissions.EDIT_USER,
            )
        "
        :show="isEditing"
        id="edit-modal"
        @close="closeEditModal"
    >
        <Edit v-on:close-modal="closeEditModal" />
    </Modal>

    <Modal
        v-if="
            ($page.props?.auth.user?.permissions_by_roles ?? []).includes(
                Permissions.DELETE_USER,
            )
        "
        :show="isDeleting"
        id="delete-modal"
        @close="closeDeleteModal"
    >
        <Delete v-on:close-modal="closeDeleteModal" />
    </Modal>
</template>
