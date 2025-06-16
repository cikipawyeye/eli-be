<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Permissions } from '@/Permission';
import {
    flashError,
    flashSuccess,
    formatHumanDateTime,
    formatMoney,
    toTitleCase,
} from '@/Supports/helpers';
import { Deferred, Head, Link, usePage } from '@inertiajs/vue3';
import { computed, PropType, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import Cancel from './Partials/Cancel.vue';
import Delete from './Partials/Delete.vue';
import Edit from './Partials/Edit.vue';
import RenderQR from './Partials/RenderQR.vue';

const props = defineProps({
    data: {
        type: Object as PropType<Payment>,
        required: true,
    },
    payment_info: {
        type: Object as PropType<XenditPaymentRequest>,
        required: false,
    },
});
const payment = computed(() => props.data);
const page = usePage<SharedProps>();
const flash = computed(() => page.props.flash);
const isCanceling = ref(false);
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
    { deep: true },
);

const closeEditModal = () => {
    isEditing.value = false;
};

const closeCancelModal = () => {
    isCanceling.value = false;
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
                            <i class="text-xs fa fa-pencil"></i>
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
                                ).includes(Permissions.CANCEL_PAYMENT) &&
                                payment?.state !== 'CANCELED' &&
                                payment?.state !== 'FAILED'
                            "
                            class="btn btn-sm btn-danger mb-0 text-nowrap"
                            @click="isCanceling = true"
                        >
                            <i class="text-xs fa fa-ban"></i>
                            <span class="d-none d-md-inline ms-2">{{
                                t('cancel_payment')
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
                            <i class="text-xs fa fa-trash"></i>
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
                <div class="row">
                    <div class="col-12 col-md-6 p-2">
                        <ul class="list-group m-4">
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark"
                                    >{{
                                        t('id', {
                                            data: t('payment'),
                                        })
                                    }}:</strong
                                >
                                &nbsp; #{{ payment.id }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark"
                                    >{{ t('date') }}:</strong
                                >
                                &nbsp;
                                {{
                                    payment.created_at
                                        ? formatHumanDateTime(
                                              payment.created_at,
                                          )
                                        : ''
                                }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark"
                                    >{{ t('amount') }}:</strong
                                >
                                &nbsp;
                                {{ formatMoney(payment.amount) }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark"
                                    >{{ t('payment_type') }}:</strong
                                >
                                &nbsp;
                                {{
                                    payment.payment_method_type
                                        ? t(
                                              payment.payment_method_type.toLowerCase(),
                                          )
                                        : ''
                                }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark"
                                    >{{ t('status') }}:</strong
                                >
                                &nbsp;
                                <span
                                    v-if="payment.state === 'SUCCEEDED'"
                                    class="badge bg-gradient-primary"
                                    >{{ t('succeeded') }}</span
                                >
                                <span
                                    v-else-if="payment.state === 'FAILED'"
                                    class="badge badge-warning"
                                    >{{ t('failed') }}</span
                                >
                                <span v-else class="badge badge-secondary">{{
                                    payment.state === 'CANCELED'
                                        ? t('canceled')
                                        : t('pending')
                                }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 p-2">
                        <Deferred :data="['payment_info']">
                            <template #fallback>
                                <div
                                    class="d-flex justify-content-center m-4 p-4"
                                >
                                    <div
                                        class="spinner-border text-primary"
                                        role="status"
                                    >
                                        <span class="visually-hidden"
                                            >Loading...</span
                                        >
                                    </div>
                                </div>
                            </template>

                            <ul v-if="payment_info" class="list-group m-4">
                                <li
                                    v-if="
                                        payment_info.payment_method.type ==
                                        'EWALLET'
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{
                                            t('payment_channel_code')
                                        }}:</strong
                                    >
                                    &nbsp;
                                    {{
                                        payment_info.payment_method.ewallet
                                            .channel_code
                                    }}
                                </li>
                                <li
                                    v-else-if="
                                        payment_info.payment_method.type ==
                                        'OVER_THE_COUNTER'
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{
                                            t('payment_channel_code')
                                        }}:</strong
                                    >
                                    &nbsp;
                                    {{
                                        payment_info.payment_method
                                            .over_the_counter.channel_code
                                    }}
                                </li>
                                <li
                                    v-else-if="
                                        payment_info.payment_method.type ==
                                        'QR_CODE'
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{
                                            t('payment_channel_code')
                                        }}:</strong
                                    >
                                    &nbsp;
                                    {{
                                        payment_info.payment_method.qr_code
                                            .channel_code
                                    }}
                                </li>
                                <li
                                    v-else-if="
                                        payment_info.payment_method.type ==
                                        'VIRTUAL_ACCOUNT'
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{
                                            t('payment_channel_code')
                                        }}:</strong
                                    >
                                    &nbsp;
                                    {{
                                        payment_info.payment_method
                                            .virtual_account.channel_code
                                    }}
                                </li>

                                <li
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{ t('status') }}:</strong
                                    >
                                    &nbsp;
                                    <span
                                        v-if="
                                            payment_info.status === 'SUCCEEDED'
                                        "
                                        class="badge badge-success"
                                        >{{ t('succeeded') }}</span
                                    >
                                    <span
                                        v-else-if="
                                            payment_info.status === 'FAILED'
                                        "
                                        class="badge badge-danger"
                                        >{{ t('failed') }}</span
                                    >
                                    <span
                                        v-else-if="
                                            payment_info.status === 'PENDING' ||
                                            payment_info.status ===
                                                'AWAITING_CAPTURE'
                                        "
                                        class="badge badge-secondary"
                                        >{{ t('pending') }}</span
                                    >
                                    <span
                                        v-else-if="
                                            payment_info.status ===
                                            'REQUIRES_ACTION'
                                        "
                                        class="badge badge-warning"
                                        >{{ t('requires_action') }}</span
                                    >
                                </li>

                                <li
                                    v-if="
                                        payment_info.payment_method.type ==
                                        'OVER_THE_COUNTER'
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{ t('expired_date') }}:</strong
                                    >
                                    &nbsp;
                                    {{
                                        payment_info.payment_method
                                            .over_the_counter.channel_properties
                                            .expires_at
                                            ? formatHumanDateTime(
                                                  payment_info.payment_method
                                                      .over_the_counter
                                                      .channel_properties
                                                      .expires_at,
                                              )
                                            : '-'
                                    }}
                                </li>
                                <li
                                    v-else-if="
                                        payment_info.payment_method.type ==
                                        'VIRTUAL_ACCOUNT'
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{ t('expired_date') }}:</strong
                                    >
                                    &nbsp;
                                    {{
                                        payment_info.payment_method
                                            .virtual_account.channel_properties
                                            .expires_at
                                            ? formatHumanDateTime(
                                                  payment_info.payment_method
                                                      .virtual_account
                                                      .channel_properties
                                                      .expires_at,
                                              )
                                            : '-'
                                    }}
                                </li>
                                <li
                                    v-else-if="
                                        payment_info.payment_method.type ==
                                        'QR_CODE'
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{ t('expired_date') }}:</strong
                                    >
                                    &nbsp;
                                    {{
                                        payment_info.payment_method.qr_code
                                            .channel_properties.expires_at
                                            ? formatHumanDateTime(
                                                  payment_info.payment_method
                                                      .qr_code
                                                      .channel_properties
                                                      .expires_at,
                                              )
                                            : '-'
                                    }}
                                </li>

                                <li
                                    v-if="
                                        payment_info.payment_method.type ==
                                            'QR_CODE' &&
                                        payment_info.payment_method.qr_code
                                            .channel_properties.qr_string
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{ t('qr_string') }}:</strong
                                    >
                                    <br />
                                    <br />
                                    <RenderQR
                                        :value="
                                            payment_info.payment_method.qr_code
                                                .channel_properties.qr_string
                                        "
                                    />
                                </li>

                                <div
                                    v-if="
                                        payment_info.payment_method.type ==
                                        'EWALLET'
                                    "
                                >
                                    <li
                                        v-if="
                                            payment_info.payment_method.ewallet
                                                .channel_properties
                                                .mobile_number
                                        "
                                        class="list-group-item border-0 ps-0 text-sm"
                                    >
                                        <strong class="text-dark"
                                            >{{ t('phone_number') }}:</strong
                                        >
                                        &nbsp;
                                        {{
                                            payment_info.payment_method.ewallet
                                                .channel_properties
                                                .mobile_number
                                        }}
                                    </li>

                                    <li
                                        v-if="
                                            payment_info.payment_method.ewallet
                                                .account.name
                                        "
                                        class="list-group-item border-0 ps-0 text-sm"
                                    >
                                        <strong class="text-dark"
                                            >{{ t('account_name') }}:</strong
                                        >
                                        &nbsp;
                                        {{
                                            payment_info.payment_method.ewallet
                                                .account.name
                                        }}
                                    </li>
                                </div>

                                <li
                                    v-if="
                                        payment_info.status ==
                                            'REQUIRES_ACTION' &&
                                        payment_info.actions &&
                                        payment_info.actions.length > 0
                                    "
                                    class="list-group-item border-0 ps-0 text-sm"
                                >
                                    <strong class="text-dark"
                                        >{{ t('action') }}:</strong
                                    >
                                    &nbsp;
                                    {{
                                        payment_info.actions
                                            .map((val) =>
                                                toTitleCase(val.action),
                                            )
                                            .filter(
                                                (value, index, self) =>
                                                    self.indexOf(value) ===
                                                    index,
                                            )
                                            .join(', ')
                                    }}
                                </li>
                            </ul>
                        </Deferred>
                    </div>
                </div>
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
                Permissions.CANCEL_PAYMENT,
            ) && payment?.id
        "
        :show="isCanceling"
        id="cancel-payment-modal"
        @close="closeCancelModal"
    >
        <Cancel v-on:close-modal="closeCancelModal" />
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
        <Delete v-on:close-modal="closeDeleteModal" />
    </Modal>
</template>
