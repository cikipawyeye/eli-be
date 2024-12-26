<script setup lang="ts">
import InputGroup from '@/Components/InputGroup.vue';
import Guest from '@/Layouts/Guest.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onSuccess: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <Guest>
        <Head title="Log in" />

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
                                        class="font-weight-bolder mb-0 mt-2 text-center text-white"
                                    >
                                        Sign in
                                    </h4>
                                    <div class="row mt-3">
                                        <div class="col-2 ms-auto text-center">
                                            <a
                                                class="btn btn-link px-3"
                                                href="javascript:;"
                                            >
                                                <i
                                                    class="fa fa-facebook text-lg text-white"
                                                ></i>
                                            </a>
                                        </div>
                                        <div class="col-2 px-1 text-center">
                                            <a
                                                class="btn btn-link px-3"
                                                href="javascript:;"
                                            >
                                                <i
                                                    class="fa fa-github text-lg text-white"
                                                ></i>
                                            </a>
                                        </div>
                                        <div class="col-2 me-auto text-center">
                                            <a
                                                class="btn btn-link px-3"
                                                href="javascript:;"
                                            >
                                                <i
                                                    class="fa fa-google text-lg text-white"
                                                ></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div v-if="status" class="mb-4">
                                    {{ status }}
                                </div>

                                <form
                                    @submit.prevent="submit"
                                    class="text-start"
                                >
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
                                        <small
                                            v-if="form.errors.email"
                                            class="text-danger text-sm"
                                            >{{ form.errors.email }}</small
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <InputGroup
                                            :is-invalid="!!form.errors.password"
                                        >
                                            <label
                                                for="password"
                                                class="form-label"
                                                >Password</label
                                            >
                                            <input
                                                v-model="form.password"
                                                id="password"
                                                type="password"
                                                class="form-control"
                                            />
                                        </InputGroup>
                                        <small
                                            v-if="form.errors.password"
                                            class="text-danger text-sm"
                                            >{{ form.errors.password }}</small
                                        >
                                    </div>

                                    <div
                                        class="form-check form-switch d-flex align-items-center mb-3"
                                    >
                                        <input
                                            v-model="form.remember"
                                            class="form-check-input"
                                            type="checkbox"
                                            id="rememberMe"
                                            name="remember"
                                        />
                                        <label
                                            class="form-check-label mb-0 ms-3"
                                            for="rememberMe"
                                            >Remember me</label
                                        >
                                    </div>
                                    <div class="text-center">
                                        <button
                                            :disabled="form.processing"
                                            type="submit"
                                            class="btn bg-gradient-dark w-100 my-4 mb-2"
                                        >
                                            Sign in
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
                                {{ new Date().getFullYear() }}
                                , made with
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
