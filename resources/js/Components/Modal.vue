<script setup lang="ts">
import { Modal } from 'bootstrap';
import { onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
    scrollable: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const modal = ref<Modal | null>(null);
let hiddenListener: (() => void) | null = null;

onMounted(() => {
    const modalElement = document.getElementById(props.id);

    if (!modalElement) {
        console.error(`Modal with ID "${props.id}" not found.`);
        return;
    }

    modal.value = new Modal(modalElement);

    hiddenListener = () => emit('close');
    modalElement.addEventListener('hidden.bs.modal', hiddenListener);
});

onUnmounted(() => {
    // Cleanup
    modal.value?.dispose();
    const modalElement = document.getElementById(props.id);
    if (modalElement && hiddenListener) {
        modalElement.removeEventListener('hidden.bs.modal', hiddenListener);
    }
});

watch(
    () => props.show,
    (show) => (show ? modal.value?.show() : modal.value?.hide()),
);
</script>

<template>
    <div
        class="modal fade"
        :id="props.id"
        tabindex="-1"
        :aria-labelledby="`${id}-label`"
        aria-hidden="true"
    >
        <div
            :class="`modal-dialog modal-dialog-centered ${scrollable ? 'modal-dialog-scrollable' : ''}`"
        >
            <div class="modal-content">
                <slot />
            </div>
        </div>
    </div>
</template>
