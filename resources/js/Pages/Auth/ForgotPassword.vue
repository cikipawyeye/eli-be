<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import Guest from '@/Layouts/Guest.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Guest>
        <Head title="Forgot Password" />

        <div
            class="page-header align-items-start min-vh-100"
            style="
                background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');
            "
        >
            <span class="mask bg-gradient-dark opacity-6"></span>

            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div
                                class="card-header position-relative mt-n4 z-index-2 mx-3 p-0"
                            >
                                <div
                                    class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1"
                                >
                                    <h4
                                        class="font-weight-bolder mt-2 text-center text-white"
                                    >
                                        Forgot Password
                                    </h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div
                                    v-if="status"
                                    class="alert alert-success text-sm text-white"
                                    role="alert"
                                >
                                    {{ status }}
                                </div>

                                <p class="mb-4 text-sm">
                                    Forgot your password? No problem. Just let
                                    us know your email address and we will email
                                    you a password reset link that will allow
                                    you to choose a new one.
                                </p>

                                <form @submit.prevent="submit">
                                    <div class="mb-3">
                                        <InputGroup
                                            :is-invalid="!!form.errors.email"
                                        >
                                            <label
                                                for="email"
                                                class="form-label"
                                                >Email</label
                                            >
                                            <input
                                                v-model="form.email"
                                                id="email"
                                                type="email"
                                                class="form-control"
                                                autofocus
                                            />
                                        </InputGroup>

                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.email"
                                        />
                                    </div>

                                    <div class="text-center">
                                        <button
                                            :disabled="form.processing"
                                            type="submit"
                                            class="btn bg-gradient-dark w-100 my-4 mb-2"
                                        >
                                            Email Password Reset Link
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer position-absolute w-100 bottom-2 py-2">
                <div class="container">
                    <div
                        class="row align-items-center justify-content-lg-between"
                    >
                        <div class="col-12 col-md-6 my-auto">
                            <div
                                class="copyright text-lg-start text-center text-sm text-white"
                            >
                                ©
                                {{ new Date().getFullYear() }}, made with
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                by
                                <a
                                    href="https://whatthefun.id"
                                    class="font-weight-bold text-white"
                                    target="_blank"
                                    >Whatthefun.id</a
                                >
                                for a better web.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </Guest>
</template>
