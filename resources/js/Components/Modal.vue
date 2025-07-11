<script setup lang="ts">
import { Modal } from 'bootstrap';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps<{
    id: string;
    show?: boolean;
    scrollable?: boolean;
    size?: 'sm' | 'md' | 'lg' | 'xl';
}>();

const emit = defineEmits<{
    close: [void];
}>();

const modal = ref<Modal | null>(null);
const showModal = computed(() => props.show);
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
    () => showModal.value,
    (show) => (show ? modal.value?.show() : modal.value?.hide()),
);
</script>

<template>
    <div
        class="modal fade"
        :id="props.id"
        tabindex="-1"
        :aria-labelledby="`${id}-label`"
        :aria-hidden="showModal ? 'true' : 'false'"
    >
        <div
            :class="`modal-dialog modal-dialog-centered ${scrollable ? 'modal-dialog-scrollable' : ''} ${size ? `modal-${size}` : ''}`"
        >
            <div class="modal-content">
                <slot />
            </div>
        </div>
    </div>
</template>
