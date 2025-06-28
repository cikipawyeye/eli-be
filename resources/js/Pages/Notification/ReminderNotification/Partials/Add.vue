<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputGroup from '@/Components/InputGroup.vue';
import { flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { ActualFileObject, FilePondFile } from 'filepond';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const emit = defineEmits<{
    closeModal: [void];
}>();

const form = useForm<{ image: null | Blob } & ReminderNotification>({
    title: '',
    message: '',
    is_active: false,
    image: null,
});

const submit = () => {
    form.post(route('reminder-notifications.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            emit('closeModal');
            flashSuccess(
                t('stored_data', { data: t('reminder_notification') }),
            );
        },
    });
};

const updateFiles = (fileItems: FilePondFile[]) => {
    const file =
        (fileItems.map((fileItem) => fileItem.file)[0] as
            | File
            | ActualFileObject) ?? null;

    form.image =
        file instanceof File
            ? file
            : new File([file], (file as ActualFileObject).name, {
                  type: file.type,
              });
};
</script>

<template>
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
                <label for="message" class="form-label"
                    >{{ t('message')
                    }}<span class="text-warning">*</span></label
                >

                <InputGroup :is-invalid="!!form.errors.message">
                    <input
                        v-model="form.message"
                        id="message"
                        type="text"
                        class="form-control"
                        :placeholder="t('message')"
                        autofocus
                    />
                </InputGroup>

                <InputError :message="form.errors.message" />
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">{{ t('image') }}</label>

                <file-pond
                    store-as-file="true"
                    @updatefiles="updateFiles"
                    label-idle="Drop files here..."
                    :allow-multiple="false"
                    :accepted-file-types="['image/*']"
                />

                <InputError :image="form.errors.image" />
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
