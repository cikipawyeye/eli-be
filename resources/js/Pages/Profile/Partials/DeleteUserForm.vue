<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <p class="mt-1 text-sm text-gray-600">
                Before deleting your account, please download any data or
                information that you wish to retain.
            </p>
        </header>

        <button
            class="btn btn-danger"
            @click="confirmUserDeletion"
            :disabled="form.processing"
        >
            Delete Account
        </button>

        <Modal
            :show="confirmingUserDeletion"
            id="confirm-user-deletion-modal"
            @close="closeModal"
        >
            <div class="modal-body">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your account is deleted, all of its resources and data
                    will be permanently deleted. Please enter your password to
                    confirm you would like to permanently delete your account.
                </p>

                <div class="mt-4">
                    <InputGroup :is-invalid="!!form.errors.password">
                        <label for="password" class="form-label">
                            Password</label
                        >
                        <input
                            v-model="form.password"
                            id="password"
                            type="password"
                            class="form-control"
                            autofocus
                        />
                    </InputGroup>

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="d-flex justify-content-end mt-4 gap-3">
                    <button
                        class="btn btn-secondary mb-0"
                        type="button"
                        @click="closeModal"
                    >
                        Cancel
                    </button>

                    <button
                        class="btn btn-danger mb-0"
                        type="button"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>
