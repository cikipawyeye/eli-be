<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Permissions } from '@/Permission';
import { can } from '@/Supports/helpers';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from './Partials/Modal.vue';

defineProps<{
    data: Emotion;
}>();

const isEditing = ref(false);
const isDeleting = ref(false);
</script>

<template>
    <Head :title="$t('emotion')" />

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
                <li class="breadcrumb-item text-dark text-sm">
                    <Link
                        class="text-dark opacity-5"
                        :href="route('emotions.index')"
                    >
                        {{ $t('emotion') }}
                    </Link>
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
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div
                    class="shadow-secondary border-radius-lg d-flex flex-wrap gap-4 p-3"
                >
                    <h6 class="text-capitalize my-auto">
                        {{ data?.name }}
                    </h6>

                    <div
                        class="d-flex align-items-center justify-content-end ms-auto flex-wrap gap-3"
                    >
                        <button
                            v-if="can($page, Permissions.EDIT_EMOTION)"
                            class="btn btn-sm btn-warning mb-0 text-nowrap"
                            @click="isEditing = true"
                        >
                            <i class="fa fa-pencil"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                $t('edit', {
                                    data: $t('emotion'),
                                })
                            }}</span>
                        </button>
                        <button
                            v-if="can($page, Permissions.DELETE_EMOTION)"
                            class="btn btn-sm btn-danger mb-0 text-nowrap"
                            @click="isDeleting = true"
                        >
                            <i class="fa fa-trash"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                $t('delete', {
                                    data: $t('emotion'),
                                })
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <ul class="list-group m-4">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">{{ $t('name') }}:</strong>
                        &nbsp;
                        {{ data.name }}
                    </li>
                </ul>
            </div>
        </div>

        <Modal
            :show="isEditing || isDeleting"
            :is-deleting="isDeleting"
            :emotion="data"
            @close="
                () => {
                    isEditing = false;
                    isDeleting = false;
                }
            "
        />
    </AuthenticatedLayout>
</template>
