<script setup lang="ts">
import { formatAverageAge } from '@/Supports/helpers';
import { Deferred, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage<
    SharedProps & {
        premiumUser: number;
        nonPremiumUser: number;
        averageAge: string;
    }
>();

const { t } = useI18n();
</script>

<template>
    <div class="card">
        <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-sm mb-0 text-capitalize">
                        {{ t('average_age') }}
                    </p>
                    <Deferred :data="['averageAge']">
                        <template #fallback>
                            <h6 class="h6 text-secondary">Loading...</h6>
                        </template>
                        <h4 v-if="page.props.averageAge" class="mb-0">
                            {{
                                t('user_age', {
                                    data: formatAverageAge(
                                        +page.props.averageAge,
                                    ),
                                })
                            }}
                        </h4>
                        <h4 v-else class="mb-0">{{ '-' }}</h4>
                    </Deferred>
                </div>
                <div
                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg"
                >
                    <i class="material-symbols-rounded opacity-10"
                        >leaderboard</i
                    >
                </div>
            </div>
        </div>
        <hr class="dark horizontal my-0" />
        <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm">
                {{ t('all_time') }}
            </p>
        </div>
    </div>
</template>
