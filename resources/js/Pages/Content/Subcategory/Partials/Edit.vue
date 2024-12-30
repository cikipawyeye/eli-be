<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { ContentCategory } from '@/Constants/ContentCategory';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const emit = defineEmits<{
    closeModal: [void];
}>();

const page = usePage();
const subcategory = computed(() => page.props.data as Subcategory);

const form = useForm<Subcategory>({
    name: subcategory.value.name,
    category: subcategory.value.category,
    is_active: subcategory.value.is_active,
});

const submit = () => {
    form.put(
        route('subcategories.update', {
            subcategory: subcategory.value.id,
        }),
        {
            onSuccess: () => emit('closeModal'),
        },
    );
};
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal" id="modal-title-default">
            {{ t('edit', { data: t('subcategory') }) }}
        </h6>
        <button
            type="button"
            class="btn-close text-dark"
            data-bs-dismiss="modal"
            aria-label="Close"
        >
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <form @submit.prevent="submit" class="text-start">
        <div class="modal-body">
            <div class="mb-3">
                <label for="category" class="form-label">{{
                    t('category')
                }}</label>

                <InputGroup :is-invalid="!!form.errors.name">
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

                <InputError :message="form.errors.name" />
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">{{ t('name') }}</label>

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

            <label for="is_active" class="form-label">{{ t('status') }}</label>
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
                    <label class="form-check-label mb-0 ms-3" for="is_active">{{
                        form.is_active ? t('active') : t('inactive')
                    }}</label>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button
                class="btn btn-secondary mb-1"
                type="button"
                @click="emit('closeModal')"
            >
                {{ t('cancel') }}
            </button>

            <button
                :disabled="form.processing"
                type="submit"
                class="btn bg-gradient-primary mb-1"
            >
                {{ t('save') }}
            </button>
        </div>
    </form>
</template>
