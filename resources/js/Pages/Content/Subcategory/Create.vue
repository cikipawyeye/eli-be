<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { ContentCategory } from '@/Constants/ContentCategory';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, PropType } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps({
    query: {
        type: Object as PropType<{ category: 0 | 1 }>,
        required: false,
    },
});

const { t } = useI18n();

const category = computed(() => {
    if (props.query?.category !== undefined && props.query?.category !== null) {
        return props.query.category in Object.keys(ContentCategory)
            ? t(ContentCategory[props.query.category])
            : t('subcategories');
    }

    return t('motivation');
});

const form = useForm<Subcategory>({
    name: '',
    category: props.query?.category ?? 0,
    is_active: true,
    premium: true,
});

const submit = () => {
    form.post(route('subcategories.index'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head :title="category" />

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
                <li class="breadcrumb-item text-sm">{{ t('content') }}</li>
                <li class="breadcrumb-item text-sm">
                    <Link
                        v-if="query?.category"
                        class="text-dark opacity-5"
                        :href="
                            route('subcategories.index', {
                                category: query.category,
                            })
                        "
                    >
                        {{ t(ContentCategory[query.category]) }}
                    </Link>
                    <div v-else>
                        {{ category }}
                    </div>
                </li>
                <li
                    class="breadcrumb-item text-dark active text-sm"
                    aria-current="page"
                >
                    {{
                        t('create', {
                            data: t('subcategory'),
                        })
                    }}
                </li>
            </ol>
        </template>

        <div class="ms-2 my-3">
            <h3 class="mb-0 h5 font-weight-bolder">
                {{
                    t('add', {
                        data: t('subcategory'),
                    })
                }}
            </h3>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form @submit.prevent="submit" class="text-start">
                    <div class="mb-3">
                        <label for="category" class="form-label">{{
                            t('category')
                        }}</label>

                        <InputGroup :is-invalid="!!form.errors.category">
                            <select
                                v-model="form.category"
                                id="category"
                                class="form-control"
                                disabled
                            >
                                <option :value="0">
                                    {{ t(ContentCategory[0]) }}
                                </option>
                                <option :value="1">
                                    {{ t(ContentCategory[1]) }}
                                </option>
                            </select>
                        </InputGroup>

                        <InputError :message="form.errors.category" />
                    </div>

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

                    <label for="premium" class="form-label">{{
                        t('access')
                    }}</label>
                    <div class="mx-1">
                        <div
                            class="form-check form-switch d-flex align-items-center mb-3"
                        >
                            <input
                                v-model="form.premium"
                                class="form-check-input"
                                type="checkbox"
                                id="premium"
                                name="premium"
                            />
                            <label
                                class="form-check-label mb-0 ms-3"
                                for="premium"
                                >{{
                                    form.premium
                                        ? t('premium_user_only')
                                        : t('all_users')
                                }}</label
                            >
                        </div>
                    </div>

                    <label for="is_active" class="form-label">{{
                        t('status')
                    }}</label>
                    <div class="mx-1">
                        <div
                            class="form-check form-switch d-flex align-items-center mb-3"
                        >
                            <input
                                v-model="form.is_active"
                                class="form-check-input"
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                            />
                            <label
                                class="form-check-label mb-0 ms-3"
                                for="is_active"
                                >{{
                                    form.is_active ? t('active') : t('inactive')
                                }}</label
                            >
                        </div>
                    </div>

                    <div class="text-end">
                        <button
                            :disabled="form.processing"
                            type="submit"
                            class="btn bg-gradient-primary my-4 mb-2"
                        >
                            {{ t('save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
