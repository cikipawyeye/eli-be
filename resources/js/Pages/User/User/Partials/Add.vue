<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm<
    {
        password: string | null;
        password_confirmation: string | null;
    } & User
>({
    name: '',
    email: '',
    email_verified_at: null,
    password: null,
    password_confirmation: null,
    is_premium: false,
});

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => emit('closeModal'),
    });
};
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal" id="modal-title-default">
            {{ t('add', { data: t('user') }) }}
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
                <label for="name" class="form-label">{{ t('name') }}</label>

                <InputGroup :is-invalid="!!form.errors.name">
                    <input
                        v-model="form.name"
                        id="name"
                        type="text"
                        class="form-control"
                        :placeholder="t('name')"
                        autofocus
                    />
                </InputGroup>

                <InputError :message="form.errors.name" />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ t('email') }}</label>

                <InputGroup :is-invalid="!!form.errors.email">
                    <input
                        v-model="form.email"
                        id="email"
                        type="email"
                        class="form-control"
                        :placeholder="t('email')"
                    />
                </InputGroup>

                <InputError :message="form.errors.email" />
            </div>

            <div class="mb-3">
                <label for="email_verified_at" class="form-label">{{
                    t('email_verified_at')
                }}</label>

                <InputGroup :is-invalid="!!form.errors.email_verified_at">
                    <input
                        v-model="form.email_verified_at"
                        id="email_verified_at"
                        type="datetime-local"
                        class="form-control"
                        :placeholder="t('email_verified_at')"
                    />
                </InputGroup>

                <InputError :message="form.errors.email_verified_at" />
            </div>

            <div class="mb-4">
                <label for="is_premium" class="form-label">{{
                    t('account_status')
                }}</label>
                <div class="mx-1">
                    <div
                        class="form-check form-switch d-flex align-items-center mb-3"
                    >
                        <input
                            v-model="form.is_premium"
                            class="form-check-input"
                            type="checkbox"
                            id="is_premium"
                            name="is_premium"
                        />
                        <label
                            class="form-check-label mb-0 ms-3"
                            for="is_premium"
                            >{{
                                form.is_premium ? t('premium') : t('regular')
                            }}</label
                        >
                    </div>
                </div>

                <InputError :message="form.errors.is_premium" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{
                    t('password')
                }}</label>

                <InputGroup :is-invalid="!!form.errors.password">
                    <input
                        v-model="form.password"
                        id="password"
                        type="password"
                        class="form-control"
                        placeholder="Password"
                    />
                </InputGroup>

                <InputError :message="form.errors.password" />
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{
                    t('password_confirmation')
                }}</label>

                <InputGroup :is-invalid="!!form.errors.password_confirmation">
                    <input
                        v-model="form.password_confirmation"
                        id="password_confirmation"
                        type="password"
                        class="form-control"
                        placeholder="Confirm Password"
                    />
                </InputGroup>

                <InputError :message="form.errors.password_confirmation" />
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
