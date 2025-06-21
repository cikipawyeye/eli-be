<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    message: Message;
    emotion_id?: number;
}>();

const existing = computed(() => props.message);

const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm<Message>({
    emotion_id: props.emotion_id ?? existing.value.emotion_id,
    content: existing.value.content,
});

const submit = () => {
    form.put(route('messages.update', existing.value.id), {
        onSuccess: () => {
            emit('closeModal');
            flashSuccess(t('updated_data', { data: t('message') }));
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="text-start">
        <div class="modal-body">
            <div class="mb-3">
                <label for="content" class="form-label">
                    {{ t('message_content')
                    }}<span class="text-warning">*</span>
                </label>

                <InputGroup :is-invalid="!!form.errors.content">
                    <textarea
                        v-model="form.content"
                        id="content"
                        type="text"
                        class="form-control"
                        :placeholder="t('message_content')"
                        autofocus
                    />
                </InputGroup>

                <InputError :message="form.errors.content" />
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
