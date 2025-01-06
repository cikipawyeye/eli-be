<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Permissions } from '@/Permission';
import {
    flashError,
    flashSuccess,
    formatHumanDateTime,
    formatMoney,
} from '@/Supports/helpers';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, PropType, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import Edit from './Partials/Edit.vue';
import Modal from '@/Components/Modal.vue';
import Delete from './Partials/Delete.vue';

const props = defineProps({
    data: {
        type: Object as PropType<Payment>,
        required: true,
    },
});
const payment = computed(() => props.data);
const page = usePage<SharedProps>();
const flash = computed(() => page.props.flash);
const isEditing = ref(false);
const isDeleting = ref(false);

const { t } = useI18n();

watch(
    () => flash.value,
    (value) => {
        if (value.error) {
            flashError(value.error);
        }
        if (value.success) {
            flashSuccess(value.success);
        }
    },
    {deep: true}
);

const closeEditModal = () => {
    isEditing.value = false;
};

const closeDeleteModal = () => {
    isDeleting.value = false;
};
</script>

<template>
    <Head :title="t('payment')" />

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
                <li class="breadcrumb-item text-sm">{{ t('payments') }}</li>
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    {{ data?.id }}
                </li>
            </ol>
        </template>

        <div class="card mb-4 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div
                    class="shadow-secondary border-radius-lg d-flex flex-wrap gap-4 p-3"
                >
                    <h6 class="text-capitalize my-auto">
                        {{ t('payment') }}
                    </h6>

                    <div
                        class="d-flex align-items-center justify-content-end ms-auto flex-wrap gap-3"
                    >
                        <button
                            v-if="
                                (
                                    $page.props?.auth.user
                                        ?.permissions_by_roles ?? []
                                ).includes(Permissions.EDIT_PAYMENT)
                            "
                            class="btn btn-sm btn-warning mb-0 text-nowrap"
                            @click="isEditing = true"
                        >
                            <i class="fa fa-pencil"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                t('edit', {
                                    data: t('payment'),
                                })
                            }}</span>
                        </button>
                        <button
                            v-if="
                                (
                                    $page.props?.auth.user
                                        ?.permissions_by_roles ?? []
                                ).includes(Permissions.DELETE_PAYMENT)
                            "
                            class="btn btn-sm btn-danger mb-0 text-nowrap"
                            @click="isDeleting = true"
                        >
                            <i class="fa fa-trash"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                t('delete', {
                                    data: t('payment'),
                                })
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <ul class="list-group m-4">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">{{ t('id', {
                            data: t('payment'),
                        }) }}:</strong>
                        &nbsp;
                        #{{
                            payment.id
                        }}
                    </li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">{{ t('date') }}:</strong>
                        &nbsp;
                        {{
                            payment.created_at
                                ? formatHumanDateTime(payment.created_at)
                                : ''
                        }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">{{ t('amount') }}:</strong>
                        &nbsp;
                        {{ formatMoney(payment.amount) }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark"
                            >{{ t('payment_method') }}:</strong
                        >
                        &nbsp;
                        {{ payment.payment_method_type }}
                    </li>
                    <li class="list-group-item border-0 ps-0 text-sm">
                        <strong class="text-dark">{{ t('status') }}:</strong>
                        &nbsp;
                        <span
                            v-if="payment.state === 'SUCCEEDED'"
                            class="badge bg-gradient-primary badge-sm"
                            >{{ t('succeeded') }}</span
                        >
                        <span
                            v-else-if="payment.state === 'FAILED'"
                            class="badge badge-warning badge-sm"
                            >{{ t('failed') }}</span
                        >
                        <span v-else class="badge badge-secondary badge-sm">{{
                            t('pending')
                        }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>

    <Modal
        v-if="
            ($page.props?.auth.user?.permissions_by_roles ?? []).includes(
                Permissions.EDIT_PAYMENT,
            ) && payment?.id
        "
        :show="isEditing"
        id="edit-payment-modal"
        @close="closeEditModal"
    >
        <Edit v-on:close-modal="closeEditModal" />
    </Modal>

    <Modal
        v-if="
            ($page.props?.auth.user?.permissions_by_roles ?? []).includes(
                Permissions.DELETE_PAYMENT,
            ) && payment?.id
        "
        :show="isDeleting"
        id="delete-payment-modal"
        @close="closeDeleteModal"
    >
        <Delete v-on:close-modal="closeDeleteModal"/>
    </Modal>
</template>
