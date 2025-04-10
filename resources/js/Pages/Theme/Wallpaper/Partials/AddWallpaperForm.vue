<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { useForm } from '@inertiajs/vue3';
import { FilePondFile } from 'filepond';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm<{ file: File | null } & Wallpaper>({
    name: '',
    type: null,
    file: null,
});

const submit = () => {
    form.post(route('wallpapers.store'), {
        onSuccess: () => {
            form.reset();
            emit('closeModal');
        },
    });
};

const updateFiles = (fileItems: FilePondFile[]) => {
    form.file = (fileItems.map((fileItem) => fileItem.file)[0] as File) ?? null;
};
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal" id="modal-title-default">
            {{ t('add', { data: t('wallpaper') }) }}
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
                <label for="name" class="form-label"
                    >{{ t('name') }}<span class="text-warning">*</span></label
                >

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
                <label for="" class="form-label"
                    >{{ t('file') }}<span class="text-warning">*</span></label
                >

                <file-pond
                    store-as-file="true"
                    @updatefiles="updateFiles"
                    label-idle="Drop files here..."
                    :allow-multiple="false"
                    :accepted-file-types="[
                        'image/jpeg',
                        'image/png',
                        'image/jpg',
                        'image/gif',
                        'image/webp',
                        'video/mp4',
                    ]"
                    maxFileSize="20MB"
                />

                <InputError :message="form.errors.file" />
            </div>
        </div>

        <div class="modal-footer">
            <button
                :disabled="form.processing"
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
