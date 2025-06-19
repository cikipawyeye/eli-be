<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
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

const form = useForm<ReminderNotification>({
    title: existing.value.title,
    message: existing.value.message,
    is_active: existing.value.is_active,
});

const submit = () => {
    form.put(route('reminder-notifications.update', existing.value.id), {
        onSuccess: () => {
            emit('closeModal');
            flashSuccess(
                t('updated_data', { data: t('reminder_notification') }),
            );
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="text-start">
        <div class="modal-body">
            <div class="mb-3">
                <label for="title" class="form-label"
                    >{{ t('title') }}<span class="text-warning">*</span></label
                >

                <InputGroup :is-invalid="!!form.errors.title">
                    <input
                        v-model="form.title"
                        id="title"
                        type="text"
                        class="form-control"
                        :placeholder="t('title')"
                        autofocus
                    />
                </InputGroup>

                <InputError :message="form.errors.title" />
            </div>
            <div class="mb-3">
                <label for="message" class="form-label"
                    >{{ t('message')
                    }}<span class="text-warning">*</span></label
                >

                <InputGroup :is-invalid="!!form.errors.message">
                    <input
                        v-model="form.message"
                        id="message"
                        type="text"
                        class="form-control"
                        :placeholder="t('message')"
                        autofocus
                    />
                </InputGroup>

                <InputError :message="form.errors.message" />
            </div>
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
                class="btn bg-gradient-primary mb-1"
            >
                {{ t('save') }}
            </button>
        </div>
    </form>
</template>
