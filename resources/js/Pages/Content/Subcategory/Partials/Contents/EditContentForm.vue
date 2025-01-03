<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { useForm } from '@inertiajs/vue3';
import { FilePondFile } from 'filepond';
import { computed, PropType, watch } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    content: {
        type: Object as PropType<Content>,
        required: false,
    },
});
const selected = computed(() => props.content);

const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm<{ image: File | null } & Content>({
    image: null,
    title: selected.value?.title ?? '',
    subcategory_id: selected.value?.subcategory_id ?? 0,
    premium: selected.value?.premium ?? true,
});

const submit = () => {
    form.put(route('contents.update', { content: selected.value?.id }), {
        onSuccess: () => {
            form.reset();
            emit('closeModal');
        },
    });
};

const updateFiles = (fileItems: FilePondFile[]) => {
    form.image =
        (fileItems.map((fileItem) => fileItem.file)[0] as File) ?? null;
};

watch(
    () => selected.value,
    (value) => {
        if (!value) return;

        form.title = value.title;
        form.subcategory_id = value.subcategory_id;
    },
    { immediate: true },
);
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal" id="modal-title-default">
            {{ t('edit', { data: t('content') }) }}
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
                <label for="title" class="form-label"
                    >{{ t('title') }}<span class="text-warning">*</span></label
                >

                <InputGroup :is-invalid="!!form.errors.title">
                    <input
                        v-model="form.title"
                        id="title"
                        type="text"
                        class="form-control"
                        :placeholder="t('title')"
                        autofocus
                    />
                </InputGroup>

                <InputError :message="form.errors.title" />
            </div>
            <div class="mb-3">
                <label for="" class="form-label">{{ t('image') }}</label>

                <file-pond
                    store-as-file="true"
                    @updatefiles="updateFiles"
                    :label-idle="'Select new image or leave empty to keep the current image.'"
                    :allow-multiple="false"
                    :accepted-file-types="['image/*']"
                />

                <InputError :message="form.errors.image" />
            </div>
            <div class="mb-3">
                <div class="form-check ms-0 ps-0">
                    <input
                        v-model="form.premium"
                        class="form-check-input me-2"
                        type="checkbox"
                        value=""
                        id="premium"
                    />
                    <label class="custom-control-label" for="premium"
                        >Premium user only</label
                    >
                </div>
                <InputError :message="form.errors.premium" />
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
