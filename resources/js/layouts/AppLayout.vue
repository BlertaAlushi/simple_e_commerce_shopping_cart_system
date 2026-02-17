<script setup lang="ts">
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    canRegister?: boolean,
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    canRegister: true,
});
</script>

<template>
    <AppLayout
        :breadcrumbs="breadcrumbs"
        :canRegister="canRegister"
    >
        <slot />
    </AppLayout>
</template>
