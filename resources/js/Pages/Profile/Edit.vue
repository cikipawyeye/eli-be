<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();
</script>

<template>
    <Head title="Profile" />

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
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    Profile
                </li>
            </ol>
        </template>

        <div class="card mb-6 mt-5">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div class="bg-gradient-dark shadow-dark border-radius-lg p-3">
                    <h6 class="text-capitalize mb-1 text-white">
                        Profile Information
                    </h6>

                    <p class="text-light mb-0 text-sm">
                        Update your account's profile information and email
                        address.
                    </p>
                </div>
            </div>
            <div class="card-body pb-2">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>
        </div>

        <div class="card my-6">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div class="bg-gradient-dark shadow-dark border-radius-lg p-3">
                    <h6 class="text-capitalize mb-1 text-white">
                        Update Password
                    </h6>

                    <p class="text-light mb-0 text-sm">
                        Ensure your account is using a long, random password to
                        stay secure.
                    </p>
                </div>
            </div>
            <div class="card-body pb-2">
                <UpdatePasswordForm class="max-w-xl" />
            </div>
        </div>

        <div class="card my-6">
            <div class="card-header position-relative mt-n4 z-index-2 mx-3 p-0">
                <div class="bg-gradient-dark shadow-dark border-radius-lg p-3">
                    <h6 class="text-capitalize mb-1 text-white">
                        Delete Account
                    </h6>

                    <p class="text-light mb-0 text-sm">
                        Once your account is deleted, all of its resources and
                        data will be permanently deleted.
                    </p>
                </div>
            </div>
            <div class="card-body pb-2">
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
