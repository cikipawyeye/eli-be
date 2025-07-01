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
    message?: Message | null;
    isDeleting?: boolean;
    emotion: Emotion;
}>();

const emit = defineEmits<{
    close: [void];
}>();

const isShowingModal = computed(() => props.show);
const selected = computed(() => props.message);

const closeModal = () => {
    emit('close');
};
</script>

<template>
    <Modal
        id="add-edit-message-modal"
        :show="isShowingModal"
        size="lg"
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
                        data: t('message'),
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
                        data: t('message'),
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
            :message="selected"
            @close-modal="closeModal"
        />
        <Edit
            v-else-if="selected"
            :message="selected"
            :emotion-id="emotion.id"
            @close-modal="closeModal"
        />
        <Add
            v-else-if="emotion.id"
            :emotion-id="emotion.id"
            @close-modal="closeModal"
        />
    </Modal>
</template>
