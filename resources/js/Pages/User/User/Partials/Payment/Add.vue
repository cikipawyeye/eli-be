<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    userId: number;
}>();
const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm<Payment>({
    user_id: props.userId,
    amount: 0,
    payment_method_type: null,
    state: 'PENDING',
});

const submit = () => {
    form.post(
        route('users.add-payment', {
            user: props.userId,
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
            {{ t('add', { data: t('payment') }) }}
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

    <form @submit.prevent="submit" class="text-start">
        <div class="modal-body">
            <div class="mb-3">
                <label for="amount" class="form-label">{{ t('amount') }}</label>

                <InputGroup :is-invalid="!!form.errors.amount">
                    <input
                        v-model="form.amount"
                        id="amount"
                        type="number"
                        class="form-control"
                        :placeholder="t('amount')"
                        autofocus
                    />
                </InputGroup>

                <InputError :message="form.errors.amount" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">{{
                    t('payment_method')
                }}</label>

                <div class="form-check mb-3">
                    <input
                        v-model="form.payment_method_type"
                        class="form-check-input"
                        type="radio"
                        name="payment_method_type"
                        value="VIRTUAL_ACCOUNT"
                        id="va"
                    />
                    <label class="custom-control-label" for="va"
                        >{{t('virtual_account')}}</label
                    >
                </div>

                <div class="form-check mb-3">
                    <input
                        v-model="form.payment_method_type"
                        class="form-check-input"
                        type="radio"
                        name="payment_method_type"
                        value="OVER_THE_COUNTER"
                        id="counter"
                    />
                    <label class="custom-control-label" for="counter"
                        >{{t('over_the_counter')}}</label
                    >
                </div>

                <div class="form-check mb-3">
                    <input
                        v-model="form.payment_method_type"
                        class="form-check-input"
                        type="radio"
                        name="payment_method_type"
                        value="QR_CODE"
                        id="qr"
                    />
                    <label class="custom-control-label" for="qr">{{t('qr_code')}}</label>
                </div>

                <div class="form-check mb-3">
                    <input
                        v-model="form.payment_method_type"
                        class="form-check-input"
                        type="radio"
                        name="payment_method_type"
                        value="EWALLET"
                        id="ewallet"
                    />
                    <label class="custom-control-label" for="ewallet"
                        >{{t('ewallet')}}</label
                    >
                </div>

                <InputError :message="form.errors.payment_method_type" />
            </div>

            <div class="mb-3">
                <label for="" class="form-label">{{ t('status') }}</label>

                <div class="form-check mb-3">
                    <input
                        v-model="form.state"
                        class="form-check-input"
                        type="radio"
                        name="state"
                        value="PENDING"
                        id="pending"
                    />
                    <label class="custom-control-label" for="pending">{{
                        t('pending')
                    }}</label>
                </div>

                <div class="form-check mb-3">
                    <input
                        v-model="form.state"
                        class="form-check-input"
                        type="radio"
                        name="state"
                        value="SUCCEEDED"
                        id="succeeded"
                    />
                    <label class="custom-control-label" for="succeeded">{{
                        t('succeeded')
                    }}</label>
                </div>

                <div class="form-check mb-3">
                    <input
                        v-model="form.state"
                        class="form-check-input"
                        type="radio"
                        name="state"
                        value="FAILED"
                        id="failed"
                    />
                    <label class="custom-control-label" for="failed">{{
                        t('failed')
                    }}</label>
                </div>

                <InputError :message="form.errors.state" />
            </div>
        </div>

        <div class="modal-footer">
            <button
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
