<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import { Permissions } from '@/Permission';
import { formatHumanDateTime, formatMoney } from '@/Supports/helpers';
import { Deferred, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import Add from './Add.vue';

const { t } = useI18n();
const isAdding = ref(false);
const page = usePage<
    {
        data: User;
        payments: Payment[];
    } & SharedProps
>();

const closeAddModal = () => {
    isAdding.value = false;
};
</script>

<template>
    <div class="card mb-4 mt-5">
        <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
            <div
                class="shadow-secondary border-radius-lg d-flex gap-4 p-3 flex-wrap"
            >
                <h6 class="text-capitalize my-auto">
                    {{ t('payments') }}
                </h6>

                <div class="d-flex align-items-center ms-auto gap-3">
                    <div
                        v-if="
                            (
                                $page.props?.auth.user?.permissions_by_roles ??
                                []
                            ).includes(Permissions.ADD_PAYMENT)
                        "
                    >
                        <button
                            class="btn btn-primary btn-sm mb-0 text-nowrap"
                            @click="isAdding = true"
                        >
                            <i class="fa fa-plus"></i>
                            <span class="ms-2 d-none d-sm-inline">
                                {{
                                    t('add', {
                                        data: t('payment'),
                                    })
                                }}</span
                            >
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body pb-2">
            <div class="table-responsive p-0">
                <table class="align-items-center mb-0 table">
                    <thead>
                        <tr>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                            >
                                ID
                            </th>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                            >
                                {{ t('date') }}
                            </th>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                            >
                                {{ t('amount') }}
                            </th>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                            >
                                {{ t('status') }}
                            </th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <Deferred :data="['payments']">
                            <template #fallback>
                                <tr>
                                    <td
                                        colspan="7"
                                        class="text-secondary py-6 text-center"
                                    >
                                        <span>{{ t('loading_data') }}</span>
                                    </td>
                                </tr>
                            </template>

                            <tr
                                v-for="payment in page.props.payments"
                                :key="payment.id"
                            >
                                <td class="text-sm">
                                    <span class="font-weight-bold mb-0 text-sm"
                                        >#{{ payment.id }}</span
                                    >
                                </td>
                                <td class="text-sm">
                                    <span
                                        class="font-weight-bold mb-0 text-sm"
                                        >{{
                                            payment.created_at
                                                ? formatHumanDateTime(
                                                      payment.created_at,
                                                  )
                                                : '-'
                                        }}</span
                                    >
                                </td>
                                <td class="text-sm">
                                    <span
                                        class="font-weight-bold mb-0 text-sm"
                                        >{{ formatMoney(payment.amount) }}</span
                                    >
                                </td>
                                <td>
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
                                    <span
                                        v-else
                                        class="badge badge-secondary badge-sm"
                                        >{{
                                            payment.state === 'CANCELED'
                                                ? t('canceled')
                                                : t('pending')
                                        }}</span
                                    >
                                </td>
                                <td class="align-middle">
                                    <Link
                                        :href="
                                            route('payments.show', {
                                                payment: payment.id,
                                            })
                                        "
                                        class="text-secondary font-weight-bold text-xs"
                                    >
                                        {{ t('detail') }}
                                    </Link>
                                </td>
                            </tr>

                            <tr
                                v-if="
                                    !page.props.payments ||
                                    page.props.payments.length < 1
                                "
                            >
                                <td
                                    colspan="7"
                                    class="text-secondary py-6 text-center"
                                >
                                    <span>{{ t('no_data') }}</span>
                                </td>
                            </tr>
                        </Deferred>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <Modal
        v-if="
            ($page.props?.auth.user?.permissions_by_roles ?? []).includes(
                Permissions.ADD_PAYMENT,
            )
        "
        :show="isAdding"
        id="add-payment-modal"
        @close="closeAddModal"
    >
        <Add
            v-if="page.props.data?.id"
            :user-id="page.props.data.id"
            v-on:close-modal="closeAddModal"
        />
    </Modal>
</template>
