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

const deletePayment = () => {
    form.delete(
        route('payments.destroy', {
            payment: payment.value.id,
        }),
    );
};
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal" id="modal-title-default">
            {{ t('delete', { data: t('payment') }) }}
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
        <p
            class="mt-1"
            v-html="
                t('confirm_delete', {
                    data: `${t('payment')}:
            <strong>#${payment.id}</strong>`,
                })
            "
        ></p>

        <div class="row">
            <div class="col-6 pe-2">
                <button
                    class="w-100 btn bg-gradient-secondary mb-0"
                    type="button"
                    @click="emit('closeModal')"
                >
                    {{ t('cancel') }}
                </button>
            </div>
            <div class="col-6 ps-2">
                <button
                    class="w-100 btn bg-gradient-danger mb-0"
                    type="button"
                    :disabled="form.processing"
                    @click="deletePayment"
                >
                    {{
                        t('delete', {
                            data: t('payment'),
                        })
                    }}
                </button>
            </div>
        </div>
    </div>
</template>
