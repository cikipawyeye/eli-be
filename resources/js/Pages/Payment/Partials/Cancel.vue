<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const emit = defineEmits<{
    closeModal: [void];
}>();

const page = usePage();
const payment = computed(() => page.props.data as Payment);

const { t } = useI18n();
const form = useForm({});

const submit = () => {
    form.post(
        route('payments.cancel', {
            payment: payment.value.id,
        }),
        {
            onSuccess: () => emit('closeModal'),
        },
    );
};
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal" id="modal-title-default">
            {{ t('cancel_payment') }}
        </h6>
        <button
            type="button"
            class="btn-close text-dark"
            data-bs-dismiss="modal"
            aria-label="Close"
        >
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <div class="modal-body">
        <p class="mt-1">{{ t('cancel_payment_confirmation') }}</p>
    </div>

    <div class="modal-footer">
        <div class="d-flex gap-2">
            <button
                class="btn bg-gradient-secondary mb-0"
                type="button"
                @click="emit('closeModal')"
            >
                {{ t('cancel') }}
            </button>
            <button
                class="btn bg-gradient-danger mb-0"
                type="button"
                :disabled="form.processing"
                @click="submit"
            >
                {{ t('cancel_payment') }}
            </button>
        </div>
    </div>
</template>
