<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import JobType from '@/Constants/JobType';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { flashSuccess, toTitleCase } from '@/Supports/helpers';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps<{
    cities: {
        name: string;
        code: string;
    }[];
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
    job_type: '0',
    job: undefined,
    phone_number: undefined,
    gender: undefined,
    birth_date: undefined,
    city_code: undefined,
});

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () =>
            flashSuccess(
                t('stored_data', {
                    data: t('user'),
                }),
            ),
    });
};
</script>

<template>
    <Head
        :title="
            t('create', {
                data: t('user'),
            })
        "
    />

    <AuthenticatedLayout>
        <template #header>
            <ol class="breadcrumb m-auto bg-transparent">
                <li class="breadcrumb-item text-sm">
                    <Link
                        class="text-dark opacity-5"
                        :href="route('dashboard')"
                    >
                        <i class="fa fa-house"></i>
                    </Link>
                </li>
                <li class="breadcrumb-item text-sm">{{ t('user') }}</li>
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    {{
                        t('create', {
                            data: t('user'),
                        })
                    }}
                </li>
            </ol>
        </template>

        <div class="ms-2 my-3">
            <h3 class="mb-0 h5 font-weight-bolder">
                {{
                    t('create', {
                        data: t('user'),
                    })
                }}
            </h3>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form @submit.prevent="submit" class="text-start">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{
                                t('name')
                            }}</label>

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
                            <label for="email" class="form-label">{{
                                t('email')
                            }}</label>

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

                            <InputGroup
                                :is-invalid="!!form.errors.email_verified_at"
                            >
                                <input
                                    v-model="form.email_verified_at"
                                    id="email_verified_at"
                                    type="datetime-local"
                                    class="form-control"
                                    :placeholder="t('email_verified_at')"
                                />
                            </InputGroup>

                            <InputError
                                :message="form.errors.email_verified_at"
                            />
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">{{
                                t('phone_number')
                            }}</label>

                            <InputGroup
                                :is-invalid="!!form.errors.phone_number"
                            >
                                <input
                                    v-model="form.phone_number"
                                    id="phone_number"
                                    type="text"
                                    class="form-control"
                                    :placeholder="t('phone_number')"
                                />
                            </InputGroup>

                            <InputError :message="form.errors.phone_number" />
                        </div>

                        <div class="mb-3">
                            <label for="birth_date" class="form-label">{{
                                t('birth_date')
                            }}</label>

                            <InputGroup :is-invalid="!!form.errors.birth_date">
                                <input
                                    v-model="form.birth_date"
                                    id="birth_date"
                                    type="date"
                                    class="form-control"
                                    :placeholder="t('birth_date')"
                                />
                            </InputGroup>

                            <InputError :message="form.errors.birth_date" />
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">{{
                                t('gender')
                            }}</label>

                            <div class="d-flex mb-3 mt-2">
                                <div class="form-check">
                                    <input
                                        v-model="form.gender"
                                        class="form-check-input"
                                        type="radio"
                                        name="gender"
                                        value="M"
                                        id="male"
                                    />
                                    <label
                                        class="custom-control-label"
                                        for="male"
                                        >{{ t('male') }}</label
                                    >
                                </div>

                                <div class="form-check">
                                    <input
                                        v-model="form.gender"
                                        class="form-check-input"
                                        type="radio"
                                        name="gender"
                                        value="F"
                                        id="female"
                                    />
                                    <label
                                        class="custom-control-label"
                                        for="female"
                                        >{{ t('female') }}</label
                                    >
                                </div>
                            </div>

                            <InputError :message="form.errors.gender" />
                        </div>

                        <div class="mb-3">
                            <label for="job_type" class="form-label">{{
                                t('job_type')
                            }}</label>

                            <InputGroup :is-invalid="!!form.errors.job_type">
                                <select
                                    v-model="form.job_type"
                                    id="job_type"
                                    class="form-control"
                                >
                                    <option
                                        v-for="(job, index) in Object.keys(
                                            JobType,
                                        ) as (keyof typeof JobType)[]"
                                        :value="job"
                                        :key="index"
                                    >
                                        {{ t(JobType[job]) }}
                                    </option>
                                </select>
                            </InputGroup>

                            <InputError :message="form.errors.job_type" />
                        </div>

                        <div v-if="form.job_type == '0'" class="mb-3">
                            <label for="job" class="form-label">{{
                                t('job')
                            }}</label>

                            <InputGroup :is-invalid="!!form.errors.job">
                                <input
                                    v-model="form.job"
                                    id="job"
                                    type="text"
                                    class="form-control"
                                    :placeholder="t('job')"
                                />
                            </InputGroup>

                            <InputError :message="form.errors.job" />
                        </div>

                        <div class="mb-3">
                            <label for="city_code" class="form-label">{{
                                t('city')
                            }}</label>

                            <InputGroup>
                                <select
                                    v-model="form.city_code"
                                    class="form-control"
                                >
                                    <option selected disabled value>
                                        {{ t('city') }}
                                    </option>
                                    <option
                                        v-for="(city, index) in cities"
                                        :key="index"
                                        :value="city.code"
                                    >
                                        {{ toTitleCase(city.name) }}
                                    </option>
                                </select>
                            </InputGroup>

                            <InputError :message="form.errors.city_code" />
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
                                            form.is_premium
                                                ? t('premium')
                                                : t('regular')
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
                            <label
                                for="password_confirmation"
                                class="form-label"
                                >{{ t('password_confirmation') }}</label
                            >

                            <InputGroup
                                :is-invalid="
                                    !!form.errors.password_confirmation
                                "
                            >
                                <input
                                    v-model="form.password_confirmation"
                                    id="password_confirmation"
                                    type="password"
                                    class="form-control"
                                    placeholder="Confirm Password"
                                />
                            </InputGroup>

                            <InputError
                                :message="form.errors.password_confirmation"
                            />
                        </div>
                    </div>

                    <div class="modal-footer gap-3 my-2">
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="btn bg-gradient-primary mb-1"
                        >
                            {{ t('save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
