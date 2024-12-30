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
            class="mt-1 text-sm text-gray-600"
            v-html="
                t('confirm_delete', {
                    data: `${t('subcategory')}:
            <strong>${subcategory.name}</strong>`,
                })
            "
        ></p>
    </div>

    <div class="modal-footer">
        <button
            class="btn btn-secondary mb-0"
            type="button"
            @click="emit('closeModal')"
        >
            {{ t('cancel') }}
        </button>

        <button
            class="btn btn-danger mb-0"
            type="button"
            :disabled="form.processing"
            @click="deleteSubcategory"
        >
            {{ t('delete') }}
        </button>
    </div>
</template>
