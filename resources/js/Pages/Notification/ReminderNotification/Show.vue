<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Permissions } from '@/Permission';
import { can } from '@/Supports/helpers';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from './Partials/Modal.vue';
import NotificationPreview from './Partials/NotificationPreview.vue';

defineProps<{
    data: ReminderNotification;
}>();

const isEditing = ref(false);
const isDeleting = ref(false);
</script>

<template>
    <Head :title="$t('reminder_notification')" />

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
                        :href="route('reminder-notifications.index')"
                    >
                        {{ $t('reminder_notification') }}
                    </Link>
                </li>
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    {{ data?.title }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div
                    class="shadow-secondary border-radius-lg d-flex flex-wrap gap-4 p-3"
                >
                    <h6 class="text-capitalize my-auto">
                        {{ data?.title }}
                    </h6>

                    <span
                        v-if="data.is_active"
                        class="badge bg-gradient-primary my-auto"
                        >Active</span
                    >

                    <div
                        class="d-flex align-items-center justify-content-end ms-auto flex-wrap gap-3"
                    >
                        <button
                            v-if="
                                can(
                                    $page,
                                    Permissions.EDIT_REMINDER_NOTIFICATION,
                                )
                            "
                            class="btn btn-sm btn-warning mb-0 text-nowrap"
                            @click="isEditing = true"
                        >
                            <i class="fa fa-pencil"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                $t('edit', {
                                    data: $t('reminder_notification'),
                                })
                            }}</span>
                        </button>
                        <button
                            v-if="
                                can(
                                    $page,
                                    Permissions.DELETE_REMINDER_NOTIFICATION,
                                )
                            "
                            class="btn btn-sm btn-danger mb-0 text-nowrap"
                            @click="isDeleting = true"
                        >
                            <i class="fa fa-trash"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                $t('delete', {
                                    data: $t('reminder_notification'),
                                })
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 p-4">
                        <ul class="list-group mb-4">
                            <li
                                class="list-group-item border-0 ps-0 pt-0 text-sm"
                            >
                                <strong class="text-dark"
                                    >{{ $t('title') }}:</strong
                                >
                                &nbsp;
                                {{ data.title }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark"
                                    >{{ $t('message') }}:</strong
                                >
                                &nbsp;
                                {{ data.message }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 p-4">
                        <NotificationPreview :notification="data" />
                    </div>
                </div>
            </div>
        </div>

        <Modal
            :show="isEditing || isDeleting"
            :is-deleting="isDeleting"
            :reminder-notification="data"
            @close="
                () => {
                    isEditing = false;
                    isDeleting = false;
                }
            "
        />
    </AuthenticatedLayout>
</template>
