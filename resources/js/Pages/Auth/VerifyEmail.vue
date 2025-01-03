<script setup lang="ts">
import Guest from '@/Layouts/Guest.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <Guest>
        <Head title="Email Verification" />

        <div class="page-header align-items-start min-vh-100">
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
                                        Email Verification
                                    </h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-4 text-sm text-gray-600">
                                    Thanks for signing up! Before getting
                                    started, could you verify your email address
                                    by clicking on the link we just emailed to
                                    you? If you didn't receive the email, we
                                    will gladly send you another.
                                </div>

                                <div
                                    class="text-success mb-2 text-sm font-medium"
                                    v-if="verificationLinkSent"
                                >
                                    A new verification link has been sent to the
                                    email address you provided during
                                    registration.
                                </div>

                                <form @submit.prevent="submit">
                                    <div class="text-center">
                                        <button
                                            :disabled="form.processing"
                                            type="submit"
                                            class="btn bg-gradient-primary w-100 mt-4"
                                        >
                                            Resend Verification Email
                                        </button>
                                    </div>
                                </form>
                                <div class="text-center">
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="btn btn-outline-secondary btn-sm w-100 mb-2"
                                        >Log Out</Link
                                    >
                                </div>
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
