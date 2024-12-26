<script setup lang="ts">
import { computed, PropType } from 'vue';

const VALID_TYPES = [
    'input-group-outline',
    'input-group-dynamic',
    'input-group-static',
] as const;

const props = defineProps({
    type: {
        type: String as PropType<(typeof VALID_TYPES)[number]>,
        required: false,
        default: 'input-group-outline',
    },
    isInvalid: {
        type: Boolean,
        required: false,
        default: false,
    },
});

const computedClass = computed(() =>
    `input-group ${props.type} ${props.isInvalid ? 'is-invalid' : ''}`.trim(),
);
</script>

<template>
    <div :class="computedClass" v-input-focus>
        <slot>
            <span>No content provided</span>
        </slot>
    </div>
</template>
