<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    emotion: Emotion;
}>();

const existing = computed(() => props.emotion);

const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm<Emotion>({
    name: existing.value.name,
});

const submit = () => {
    form.put(route('emotions.update', existing.value.id), {
        onSuccess: () => {
            emit('closeModal');
            flashSuccess(t('updated_data', { data: t('emotion') }));
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="text-start">
        <div class="modal-body">
            <div class="mb-3">
                <label for="name" class="form-label">
                    {{ t('emotion') }}<span class="text-warning">*</span>
                </label>

                <InputGroup :is-invalid="!!form.errors.name">
                    <input
                        v-model="form.name"
                        id="name"
                        type="text"
                        class="form-control"
                        :placeholder="t('emotion')"
                        autofocus
                    />
                </InputGroup>

                <InputError :message="form.errors.name" />
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
