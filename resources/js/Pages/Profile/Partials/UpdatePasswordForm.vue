<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <form @submit.prevent="updatePassword" class="py-3">
            <div class="mb-3">
                <InputGroup :is-invalid="!!form.errors.current_password">
                    <label for="current_password" class="form-label"
                        >Current Password</label
                    >
                    <input
                        v-model="form.current_password"
                        id="current_password"
                        type="password"
                        class="form-control"
                        autofocus
                    />
                </InputGroup>

                <InputError
                    class="mt-2"
                    :message="form.errors.current_password"
                />
            </div>

            <div class="mb-3">
                <InputGroup :is-invalid="!!form.errors.password">
                    <label for="new_password" class="form-label"
                        >New Password</label
                    >
                    <input
                        v-model="form.password"
                        id="new_password"
                        type="password"
                        class="form-control"
                        autofocus
                    />
                </InputGroup>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mb-3">
                <InputGroup :is-invalid="!!form.errors.password_confirmation">
                    <label for="password_confirmation" class="form-label"
                        >New Password</label
                    >
                    <input
                        v-model="form.password_confirmation"
                        id="password_confirmation"
                        type="password"
                        class="form-control"
                        autofocus
                    />
                </InputGroup>

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="d-flex gap-4">
                <button
                    class="btn btn-dark mb-0"
                    type="submit"
                    :disabled="form.processing"
                >
                    Save
                </button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
