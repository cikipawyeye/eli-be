<script setup lang="ts">
defineProps<{
    notification: ReminderNotification;
}>();
</script>

<template>
    <div class="p-2">
        <div
            class="p-4"
            style="
                background-color: #f1f1f1;
                border-radius: 20px;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            "
        >
            <div class="d-flex mb-2">
                <div class="me-3 d-flex" style="width: 30px">
                    <div
                        class="rounded-circle d-flex m-auto"
                        style="aspect-ratio: 1/1; background-color: #4d5b9b"
                    >
                        <img
                            src="/assets/img/small-logos/logo_white.png"
                            alt=""
                            class="m-auto"
                            style="width: 60%; object-fit: contain"
                        />
                    </div>
                </div>
                <div class="my-auto">
                    <p class="m-0 text-xs">Motivasi Penyejuk Hati &bull; now</p>
                </div>
                <div class="ms-auto my-auto">
                    <i class="fa fa-chevron-up text-primary me-2"></i>
                </div>
            </div>
            <div class="d-flex">
                <div class="me-3" style="width: 30px"></div>
                <div class="">
                    <h6 class="mb-1">{{ notification.title }}</h6>
                    <p class="text-sm m-0">{{ notification.message }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
