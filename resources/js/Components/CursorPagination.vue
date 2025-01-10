<script setup lang="ts">
import { debounce } from '@/Supports/helpers';
import { computed, PropType } from 'vue';
import InputGroup from './InputGroup.vue';

const emit = defineEmits<{
    navigate: [params: { cursor: string | null; per_page: number }];
}>();

const props = defineProps({
    meta: {
        type: Object as PropType<CursorPaginatedResponseData['meta']>,
        required: true,
    },
    withPageSetting: {
        type: Boolean,
        default: true,
    },
    size: {
        type: String as PropType<'sm' | 'lg'>,
        default: null,
    },
});

const meta = computed(() => props.meta);

const handleSetLimit = debounce((perPage?: number) => {
    emit('navigate', {
        per_page: perPage ?? meta.value.per_page,
        cursor: null,
    });
}, 300);
</script>

<template>
    <div class="d-flex flex-wrap w-100">
        <div v-if="withPageSetting" class="d-flex">
            <span style="text-wrap: nowrap" class="my-auto me-2 text-sm">Per Page:</span>
            <InputGroup>
                <select v-model="meta.per_page" class="form-control form-control-sm my-auto me-auto"
                    @change="handleSetLimit(meta.per_page)">
                    <option :value="5">5</option>
                    <option :value="10">10</option>
                    <option :value="25">25</option>
                    <option :value="50">50</option>
                    <option :value="100">100</option>
                </select>
            </InputGroup>
        </div>

        <ul v-if="meta?.prev_cursor || meta?.next_cursor"
            :class="`pagination pagination-info my-auto ms-auto ${size ? `pagination-${size}` : ''}`">
            <!-- Previous Button -->
            <li class="page-item" :class="{ disabled: !meta?.prev_cursor }">
                <a class="page-link" href="javascript:;" @click.prevent="
                    $emit('navigate', {
                        per_page: meta.per_page,
                        cursor: meta.prev_cursor,
                    })
                    " aria-label="Previous">
                    &laquo;
                </a>
            </li>

            <!-- Next Button -->
            <li class="page-item" :class="{ disabled: !meta?.next_cursor }">
                <a class="page-link" href="javascript:;" @click.prevent="
                    $emit('navigate', {
                        per_page: meta.per_page,
                        cursor: meta.next_cursor,
                    })
                    " aria-label="Next">
                    &raquo;
                </a>
            </li>
        </ul>
    </div>
</template>

<style scoped>
.not-allowed {
    cursor: not-allowed;
}

.pagination-info .page-item.active .page-link {
    background-color: #007bff;
    color: white;
}

.pagination-info .page-item.disabled .page-link {
    pointer-events: none;
    color: #ccc;
}
</style>
