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
                background-color: #272727;
                border-radius: 20px;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            "
        >
            <div class="d-flex mb-2">
                <div class="me-3 d-flex" style="width: 30px">
                    <div
                        class="rounded-circle d-flex m-auto"
                        style="aspect-ratio: 1/1; background-color: #e0deff"
                    >
                        <img
                            src="/assets/img/small-logos/app-logo.webp"
                            alt=""
                            class="m-auto"
                            style="width: 60%; object-fit: contain"
                        />
                    </div>
                </div>
                <div class="my-auto">
                    <p class="m-0 text-xs text-white" style="opacity: 0.7">
                        Motivasi Penyejuk Hati &bull; now
                    </p>
                </div>
                <div class="ms-auto my-auto text-white" style="opacity: 0.7">
                    <i class="fa fa-chevron-up me-2"></i>
                </div>
            </div>
            <div class="d-flex">
                <div class="me-3" style="width: 30px"></div>
                <div class="text-white">
                    <h6 class="mb-1 text-white">{{ notification.title }}</h6>
                    <p class="text-sm m-0" style="opacity: 0.7">
                        {{ notification.message }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
