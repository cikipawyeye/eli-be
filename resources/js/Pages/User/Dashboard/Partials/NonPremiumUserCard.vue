<script setup lang="ts">
import { Deferred, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage<SharedProps & {
    nonPremiumUser: number;
}>()

const { t } = useI18n();

</script>

<template>
    <div class="card">
        <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-sm mb-0 text-capitalize">{{ t('non_premium_user') }}</p>
                    <Deferred :data="['nonPremiumUser']">
                        <template #fallback>
                            <h6 class="h6 text-secondary">Loading...</h6>
                        </template>
                        <h4 class="mb-0">{{ page.props.nonPremiumUser }}</h4>
                    </Deferred>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                    <i class="material-symbols-rounded opacity-10">person</i>
                </div>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm">
                {{ t('all_time') }}
            </p>
        </div>
    </div>
</template>