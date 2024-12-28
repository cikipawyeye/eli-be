<script setup lang="ts">
import { debounce } from '@/Supports/helpers';
import { computed, defineEmits, defineProps } from 'vue';
import InputGroup from './InputGroup.vue';

const emit = defineEmits<{
    navigate: [params: { page: number; per_page: number }];
}>();

const props = defineProps<{
    meta: PaginatedResponseData['meta'];
}>();

const meta = computed(() => props.meta);

// Pages to show around the current page
const pagesToShow = computed(() => {
    const totalPages = meta.value?.last_page || 0;
    const currentPage = meta.value?.current_page || 1;
    const range = 3; // Show 3 pages before/after the current page
    const pages = [];

    for (
        let i = Math.max(1, currentPage - range);
        i <= Math.min(totalPages, currentPage + range);
        i++
    ) {
        pages.push(i);
    }

    return pages;
});

const handleSetLimit = debounce((perPage?: number) => {
    emit('navigate', {
        per_page: perPage ?? meta.value.per_page,
        page: 1,
    });
}, 300);
</script>

<template>
    <div class="d-flex flex-wrap px-4">
        <div class="d-flex">
            <span style="text-wrap: nowrap" class="my-auto me-2 text-sm"
                >Per Page:</span
            >
            <InputGroup>
                <select
                    v-model="meta.per_page"
                    class="form-control form-control-sm my-auto me-auto"
                    @change="handleSetLimit(meta.per_page)"
                >
                    <option :value="5">5</option>
                    <option :value="10">10</option>
                    <option :value="25">25</option>
                    <option :value="50">50</option>
                    <option :value="100">100</option>
                    <option
                        v-if="typeof meta?.total == 'number'"
                        :value="meta.total"
                    >
                        Show all
                    </option>
                </select>
            </InputGroup>
        </div>

        <ul
            v-if="meta?.prev_page_url || meta?.next_page_url"
            class="pagination pagination-info my-auto ms-auto"
        >
            <!-- Previous Button -->
            <li class="page-item" :class="{ disabled: !meta?.prev_page_url }">
                <a
                    class="page-link"
                    href="javascript:;"
                    @click.prevent="
                        $emit('navigate', {
                            per_page: meta.per_page,
                            page: meta.current_page - 1,
                        })
                    "
                    aria-label="Previous"
                >
                    &laquo;
                </a>
            </li>

            <!-- Ellipsis Before -->
            <li v-if="meta.current_page > 4" class="page-item disabled">
                <span class="page-link">...</span>
            </li>

            <!-- Pages -->
            <li
                v-for="page in pagesToShow"
                :key="page"
                class="page-item"
                :class="{ active: page === meta.current_page }"
            >
                <a
                    class="page-link"
                    href="javascript:;"
                    @click.prevent="
                        $emit('navigate', { per_page: meta.per_page, page })
                    "
                >
                    {{ page }}
                </a>
            </li>

            <!-- Ellipsis After -->
            <li
                v-if="meta.current_page < meta.last_page - 3"
                class="page-item disabled"
            >
                <span class="page-link">...</span>
            </li>

            <!-- Next Button -->
            <li class="page-item" :class="{ disabled: !meta?.next_page_url }">
                <a
                    class="page-link"
                    href="javascript:;"
                    @click.prevent="
                        $emit('navigate', {
                            per_page: meta.per_page,
                            page: meta.current_page + 1,
                        })
                    "
                    aria-label="Next"
                >
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
