<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import Guest from '@/Layouts/Guest.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps<{
    email: string;
    token: string;
}>();

const { t } = useI18n();
const page = usePage<SharedProps>();
const status = computed(() => page.props.flash);

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};
const togglePasswordConfirmationVisibility = () => {
    showPasswordConfirmation.value = !showPasswordConfirmation.value;
};

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onSuccess: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <Guest>
        <Head title="Reset Password" />

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
                                        Reset Password
                                    </h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div
                                    v-if="status.success"
                                    class="alert alert-success text-sm text-white"
                                    role="alert"
                                >
                                    {{ status.success }}
                                </div>

                                <form @submit.prevent="submit">
                                    <div class="flex-fill">
                                        <InputGroup
                                            :is-invalid="!!form.errors.email"
                                        >
                                            <input
                                                v-model="form.email"
                                                id="email"
                                                type="email"
                                                class="form-control"
                                                required
                                                disabled
                                            />
                                        </InputGroup>

                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.email"
                                        />
                                    </div>

                                    <div class="mb-3">
                                        <div
                                            class="mt-3 position-relative w-full"
                                        >
                                            <InputGroup>
                                                <label
                                                    for="password"
                                                    class="form-label"
                                                    >{{
                                                        t('new_password')
                                                    }}</label
                                                >
                                                <input
                                                    v-model="form.password"
                                                    :type="
                                                        showPassword
                                                            ? 'text'
                                                            : 'password'
                                                    "
                                                    id="password"
                                                    class="form-control"
                                                    required
                                                    autofocus
                                                />
                                            </InputGroup>

                                            <button
                                                class="position-absolute top-50 translate-middle border-0 p-1 bg-transparent"
                                                :onclick="
                                                    togglePasswordVisibility
                                                "
                                                type="button"
                                                style="
                                                    opacity: 0.7;
                                                    z-index: 20;
                                                    left: 94% !important;
                                                "
                                                tabindex="-1"
                                            >
                                                <i
                                                    v-if="showPassword"
                                                    class="text-sm fa fa-eye"
                                                ></i>
                                                <i
                                                    v-else
                                                    class="text-sm fa fa-eye-slash"
                                                ></i>
                                            </button>
                                        </div>

                                        <InputError
                                            :message="form.errors.password"
                                        />
                                    </div>

                                    <div class="mb-3">
                                        <div
                                            class="mt-3 position-relative w-full"
                                        >
                                            <InputGroup>
                                                <label
                                                    for="password_confirmation"
                                                    class="form-label"
                                                    >{{
                                                        t(
                                                            'password_confirmation',
                                                        )
                                                    }}</label
                                                >
                                                <input
                                                    v-model="
                                                        form.password_confirmation
                                                    "
                                                    :type="
                                                        showPasswordConfirmation
                                                            ? 'text'
                                                            : 'password'
                                                    "
                                                    id="password_confirmation"
                                                    class="form-control"
                                                    required
                                                    autofocus
                                                />
                                            </InputGroup>

                                            <button
                                                class="position-absolute top-50 translate-middle border-0 bg-transparent"
                                                :onclick="
                                                    togglePasswordConfirmationVisibility
                                                "
                                                type="button"
                                                style="
                                                    opacity: 0.7;
                                                    z-index: 20;
                                                    left: 94% !important;
                                                "
                                                tabindex="-1"
                                            >
                                                <i
                                                    v-if="
                                                        showPasswordConfirmation
                                                    "
                                                    class="text-sm fa fa-eye"
                                                ></i>
                                                <i
                                                    v-else
                                                    class="text-sm fa fa-eye-slash"
                                                ></i>
                                            </button>
                                        </div>

                                        <InputError
                                            :message="
                                                form.errors
                                                    .password_confirmation
                                            "
                                        />
                                    </div>

                                    <div class="text-center">
                                        <button
                                            :disabled="form.processing"
                                            type="submit"
                                            class="btn bg-gradient-dark w-100 my-4 mb-2"
                                        >
                                            Reset Password
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
