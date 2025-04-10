<script setup lang="ts">
import { flashSuccess } from '@/Supports/helpers';
import { useForm } from '@inertiajs/vue3';
import { PropType, computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    music: {
        type: Object as PropType<Music>,
        required: false,
    },
});
const music = computed(() => props.music);
const form = useForm({});

const emit = defineEmits<{
    closeModal: [void];
}>();

const destroy = () => {
    if (!music.value) return;

    form.delete(
        route('musics.destroy', {
            music: music.value.id,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                flashSuccess(t('deleted_data', { data: t('music') }));
                emit('closeModal');
            },
        },
    );
};
</script>

<template>
    <div class="modal-header">
        <h6 class="modal-title font-weight-normal">
            {{ t('delete', { data: t('music') }) }}
        </h6>
        <button
            type="button"
            class="btn-close text-dark"
            data-bs-dismiss="modal"
            aria-label="Close"
            @click="emit('closeModal')"
        >
            <span aria-hidden="true">×</span>
        </button>
    </div>

    <div class="modal-body">
        <p
            class="mb-4 mt-1"
            v-html="
                t('confirm_delete', {
                    data: `${t('music')}:<br/>
            <strong>${music?.title}</strong>`,
                })
            "
        ></p>

        <div class="row">
            <div class="col-6 pe-2">
                <button
                    class="w-100 btn bg-gradient-secondary mb-0"
                    type="button"
                    @click="emit('closeModal')"
                >
                    {{ t('cancel') }}
                </button>
            </div>
            <div class="col-6 ps-2">
                <button
                    class="w-100 btn bg-gradient-danger mb-0"
                    type="button"
                    :disabled="form.processing"
                    @click="destroy"
                >
                    {{
                        t('delete', {
                            data: t('music'),
                        })
                    }}
                </button>
            </div>
        </div>
    </div>
</template>
