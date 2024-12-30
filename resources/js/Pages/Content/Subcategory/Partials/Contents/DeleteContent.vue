<script setup lang="ts">
import { flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { PropType, computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    content: {
        type: Object as PropType<Content>,
        required: true,
    },
});
const content = computed(() => props.content);
const form = useForm({});

const emit = defineEmits<{
    closeModal: [void];
}>();

const destroy = () => {
    form.delete(
        route('contents.destroy', {
            content: content.value.id,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                flashSuccess(t('deleted_data', { data: t('content') }));
                emit('closeModal');
            },
        },
    );
};
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal">
            {{ t('delete', { data: t('content') }) }}
        </h6>
        <button
            type="button"
            class="btn-close text-dark"
            data-bs-dismiss="modal"
            aria-label="Close"
            @click="emit('closeModal')"
        >
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <div class="modal-body">
        <p
            class="mt-1 text-sm text-gray-600"
            v-html="
                t('confirm_delete', {
                    data: `${t('content')}:
            <strong>${content.title}</strong>`,
                })
            "
        ></p>
    </div>

    <div class="modal-footer">
        <button
            class="btn btn-secondary mb-0"
            type="button"
            @click="emit('closeModal')"
        >
            {{ t('cancel') }}
        </button>

        <button
            class="btn btn-danger mb-0"
            type="button"
            :disabled="form.processing"
            @click="destroy"
        >
            {{ t('delete') }}
        </button>
    </div>
</template>
