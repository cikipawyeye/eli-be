<script setup lang="ts">
import { flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    message: Message;
}>();

const existing = computed(() => props.message);

const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm({});

const submit = () => {
    form.delete(route('messages.destroy', existing.value.id), {
        onSuccess: () => {
            emit('closeModal');
            flashSuccess(t('deleted_data', { data: t('message') }));
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="text-start">
        <div class="modal-body">
            <p>
                {{ t('confirm_delete', { data: t('message') }) }}
            </p>
            <blockquote class="blockquote">
                <p class="ps-2 italic">
                    <em>{{ message.content }}</em>
                </p>
            </blockquote>
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
