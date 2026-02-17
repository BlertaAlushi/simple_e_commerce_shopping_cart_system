<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppHeader from '@/components/AppHeader.vue';
import AppShell from '@/components/AppShell.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    canRegister: boolean;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    canRegister: () => true,
});
</script>

<template>
    <AppShell class="flex-col">
        <AppHeader :breadcrumbs="breadcrumbs" :canRegister="canRegister" />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <slot />
        </AppContent>
    </AppShell>
</template>
