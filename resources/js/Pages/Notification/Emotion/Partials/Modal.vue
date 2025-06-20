<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import Add from './Add.vue';
import Delete from './Delete.vue';
import Edit from './Edit.vue';

const { t } = useI18n();

const props = defineProps<{
    show: boolean;
    emotion?: Emotion | null;
    isDeleting?: boolean;
}>();

const emit = defineEmits<{
    close: [void];
}>();

const isShowingModal = computed(() => props.show);
const selected = computed(() => props.emotion);

const closeModal = () => {
    emit('close');
};
</script>

<template>
    <Modal
        id="add-edit-emotion-modal"
        :show="isShowingModal"
        @close="closeModal"
    >
        <div class="modal-header">
            <h6
                v-if="selected && isDeleting"
                class="modal-title font-weight-normal"
                id="modal-title-default"
            >
                {{
                    t('delete', {
                        data: t('emotion'),
                    })
                }}
            </h6>
            <h6
                v-else
                class="modal-title font-weight-normal"
                id="modal-title-default"
            >
                {{
                    t(selected ? 'edit' : 'add', {
                        data: t('emotion'),
                    })
                }}
            </h6>
            <button
                type="button"
                class="btn-close text-dark"
                data-bs-dismiss="modal"
                aria-label="Close"
                @click="closeModal"
            >
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <Delete
            v-if="selected && isDeleting"
            :emotion="selected"
            @close-modal="closeModal"
        />
        <Edit
            v-else-if="selected"
            :emotion="selected"
            @close-modal="closeModal"
        />
        <Add v-else @close-modal="closeModal" />
    </Modal>
</template>
