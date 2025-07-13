<script setup lang="ts">
import { flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    reminderNotification: ReminderNotification;
}>();

const existing = computed(() => props.reminderNotification);

const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm({});

const submit = () => {
    form.delete(route('reminder-notifications.destroy', existing.value.id), {
        onSuccess: () => {
            emit('closeModal');
            flashSuccess(
                t('deleted_data', { data: t('reminder_notification') }),
            );
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="text-start">
        <div class="modal-body">
            <p>
                {{ t('confirm_delete', { data: t('reminder_notification') }) }}
            </p>
        </div>

        <div class="modal-footer">
            <button
                :disabled="form.processing"
                class="btn btn-secondary mb-1"
                type="button"
                @click="emit('closeModal')"
            >
                {{ t('cancel') }}
            </button>

            <button
                :disabled="form.processing"
                type="submit"
                class="btn bg-gradient-danger mb-1"
            >
                {{ t('delete') }}
            </button>
        </div>
    </form>
</template>
