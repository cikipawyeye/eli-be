<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
        required: false,
    },
    status: {
        type: String,
        required: false,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="py-3"
        >
            <div class="mb-3">
                <InputGroup :is-invalid="!!form.errors.name">
                    <label for="name" class="form-label">Name</label>
                    <input
                        v-model="form.name"
                        id="name"
                        type="text"
                        class="form-control"
                        autofocus
                    />
                </InputGroup>

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mb-3">
                <InputGroup :is-invalid="!!form.errors.email">
                    <label for="email" class="form-label">Email</label>
                    <input
                        v-model="form.email"
                        id="email"
                        type="email"
                        class="form-control"
                        autofocus
                    />
                </InputGroup>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
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
