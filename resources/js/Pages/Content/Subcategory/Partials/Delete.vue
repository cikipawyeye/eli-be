<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const emit = defineEmits<{
    closeModal: [void];
}>();

const page = usePage();
const subcategory = computed(() => page.props.data as Subcategory);

const { t } = useI18n();
const form = useForm({});

const deleteSubcategory = () => {
    form.delete(
        route('subcategories.destroy', {
            subcategory: subcategory.value.id,
        }),
    );
};
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal" id="modal-title-default">
            {{ t('delete', { data: t('subcategory') }) }}
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

    <div class="modal-body">
        <p
            class="mt-1"
            v-html="
                t('confirm_delete', {
                    data: `${t('subcategory')}:
            <strong>${subcategory.name}</strong>`,
                })
            "
        ></p>

        <blockquote class="blockquote text-md mb-4">
            <p class="ps-3">Semua konten pada sub-kategori ini akan hilang</p>
        </blockquote>

        <div class="row">
            <div class="col-6 pe-2">
                <button
                    class="w-100 btn bg-gradient-secondary mb-0"
                    type="button"
                    @click="emit('closeModal')"
                >
                    {{ t('cancel') }}
                </button>
            </div>
            <div class="col-6 ps-2">
                <button
                    class="w-100 btn bg-gradient-danger mb-0"
                    type="button"
                    :disabled="form.processing"
                    @click="deleteSubcategory"
                >
                    {{
                        t('delete', {
                            data: t('subcategory'),
                        })
                    }}
                </button>
            </div>
        </div>
    </div>
</template>
