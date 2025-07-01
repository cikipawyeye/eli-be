<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import { flashError, flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import NotificationPreview from './NotificationPreview.vue';
import NotificationPreviewDark from './NotificationPreviewDark.vue';

defineProps<{
    active: ReminderNotification | null;
}>();

const { t } = useI18n();

const isShowingModal = ref(false);

const closeModal = () => {
    isShowingModal.value = false;
};

const form = useForm({});

const submit = () => {
    form.post(route('reminder-notifications.disable'), {
        onSuccess: () => {
            flashSuccess(
                t('updated_data', { data: t('reminder_notification') }),
            );
            closeModal();
        },
    });
};

const environment = import.meta.env.VITE_APP_ENV;

const testNotification = () => {
    form.post(route('reminder-notifications.test'), {
        showProgress: true,
        onSuccess: () => {
            flashSuccess(t('test_notification_sent'));
        },
        onError: ({ message }) => {
            flashError(message);
        },
    });
};
</script>

<template>
    <div class="card mb-4 mt-3">
        <div class="card-header d-flex gap-4 justify-content-between flex-wrap">
            <h6 class="text-capitalize my-auto">
                {{ t('reminder_notifications') }}
            </h6>
            <div class="d-flex gap-3">
                <button
                    v-if="environment && environment !== 'production'"
                    @click="testNotification"
                    :disabled="form.processing"
                    class="btn btn-warning btn-sm mb-0 text-nowrap"
                >
                    <i class="fa fa-bell me-2"></i>
                    {{ t('test_notification') }}
                </button>

                <button
                    v-if="active"
                    @click="isShowingModal = true"
                    :disabled="form.processing"
                    class="btn btn-danger btn-sm mb-0 text-nowrap"
                >
                    <i class="fa fa-ban me-2"></i>
                    {{ t('turn_off_notifications') }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-if="active" class="row justify-content-center">
                <div class="col-md-6">
                    <NotificationPreview :notification="active" />
                    <p class="m-0 text-xs text-center">Preview light mode</p>
                </div>
                <div class="col-md-6">
                    <NotificationPreviewDark :notification="active" />
                    <p class="m-0 text-xs text-center">Preview dark mode</p>
                </div>
            </div>
            <p v-else class="text-sm text-center mt-0" style="opacity: 0.6">
                {{ t('no_active_reminder_notification_yet') }}
            </p>
        </div>
    </div>

    <Modal
        id="disable-reminder-notification-modal"
        :show="isShowingModal"
        @close="closeModal"
    >
        <div class="modal-header">
            <h6 class="modal-title font-weight-normal" id="modal-title-default">
                {{ t('disable_reminder_notification') }}
            </h6>

            <button
                type="button"
                class="btn-close text-dark"
                data-bs-dismiss="modal"
                aria-label="Close"
                @click="closeModal"
            >
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="modal-body">
            <p class="mb-0">
                {{ t('disable_reminder_notification_confirmation') }}
            </p>
        </div>

        <div class="modal-footer">
            <button
                :disabled="form.processing"
                class="btn btn-secondary mb-1"
                type="button"
                @click="closeModal"
            >
                {{ t('cancel') }}
            </button>

            <button
                :disabled="form.processing"
                class="btn bg-gradient-danger mb-1"
                type="button"
                @click="submit"
            >
                {{ t('yes') }}
            </button>
        </div>
    </Modal>
</template>
