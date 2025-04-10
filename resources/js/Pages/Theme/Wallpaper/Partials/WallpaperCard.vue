<script setup lang="ts">
import { PropType, ref } from 'vue';

const props = defineProps({
    wallpaper: {
        type: Object as PropType<Wallpaper>,
        required: true,
    },
});

const emit = defineEmits<{
    destroy: [Wallpaper];
}>();

const downloadSuccess = ref(false);

const download = () => {
    if (
        !window.confirm(
            `Do you want to download wallpaper: ${props.wallpaper?.name}?`,
        )
    )
        return;

    const imageUrl = props.wallpaper.file_url;

    if (imageUrl) {
        const a = document.createElement('a');
        a.href = imageUrl;
        a.download = imageUrl.split('/').pop() ?? 'download';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

        downloadSuccess.value = true;

        setTimeout(() => {
            downloadSuccess.value = false;
        }, 2000);
    } else {
        console.error('Image URL is not available for download');
    }
};
</script>

<template>
    <div class="w-100 card mt-6" data-animation="true">
        <div class="card-header mt-n4 z-index-2 mx-3 p-0">
            <picture class="d-block">
                <img
                    :src="wallpaper.thumbnail_url"
                    :alt="wallpaper.name"
                    class="w-100 border-radius-lg shadow-dark"
                    style="aspect-ratio: 3/4; object-fit: cover"
                />
            </picture>
        </div>

        <div class="card-body text-center">
            <div class="d-flex mt-n5 justify-content-center mx-auto">
                <button
                    v-if="!downloadSuccess"
                    class="btn btn-link text-dark mb-0 border-0"
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    title="Download"
                    @click="download()"
                >
                    <i class="material-symbols-rounded text-lg">download</i>
                </button>
                <button
                    v-else
                    class="btn btn-link text-success mb-0 border-0"
                    @click="download()"
                >
                    <i class="material-symbols-rounded text-lg">check</i>
                </button>
                <button
                    class="btn btn-link text-danger mb-0 border-0"
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    title="Delete"
                    @click="emit('destroy', wallpaper)"
                >
                    <i class="material-symbols-rounded text-lg">delete</i>
                </button>
            </div>
            <h6 class="font-weight-normal mt-3 mb-1">
                <a href="javascript:;">{{ wallpaper.name }}</a>
            </h6>
            <span class="text-sm">{{
                wallpaper.type == 'image' ? 'Image' : 'Video'
            }}</span>
        </div>
    </div>
</template>
