<script setup lang="ts">
import QrcodeVue from 'qrcode.vue';

defineProps<{ value: string }>();
</script>

<template>
    <qrcode-vue
        :value="value"
        :size="150"
        level="M"
        render-as="svg"
        background="#ffffff"
        foreground="#000000"
        :gradient="true"
        gradient-type="linear"
        gradient-start-color="#000000"
        gradient-end-color="#38bdf8"
    />
</template>
