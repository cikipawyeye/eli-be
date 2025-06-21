<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import { flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    show: boolean;
    reminderNotification?: ReminderNotification | null;
}>();

const emit = defineEmits<{
    close: [void];
}>();

const selected = computed(() => props.reminderNotification);
const isShowingModal = computed(() => props.show);

const closeModal = () => {
    emit('close');
};

const form = useForm({});

const submit = () => {
    if (!selected.value) {
        flashSuccess(t('no_reminder_notification_selected'));
        return;
    }

    form.post(route('reminder-notifications.set-active', selected.value.id), {
        onSuccess: () => {
            flashSuccess(
                t('updated_data', { data: t('reminder_notification') }),
            );
            closeModal();
        },
    });
};
</script>

<template>
    <Modal
        id="activate-reminder-notification-modal"
        :show="isShowingModal"
        @close="closeModal"
    >
        <div class="modal-header">
            <h6 class="modal-title font-weight-normal" id="modal-title-default">
                {{ t('activate_reminder_notification') }}?
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
            <blockquote class="ps-3 blockquote my-4">
                <h6 class="mb-0">
                    {{ selected?.title }}
                </h6>
                <p>
                    {{ selected?.message }}
                </p>
            </blockquote>
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
                class="btn bg-gradient-primary mb-1"
                type="button"
                @click="submit"
            >
                {{ t('activate') }}
            </button>
        </div>
    </Modal>
</template>
