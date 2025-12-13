<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    cart_products_quantity?: number;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    cart_products_quantity: 0,
});
</script>

<template>
    <AppLayout
        :breadcrumbs="breadcrumbs"
        :cart_products_quantity="cart_products_quantity"
    >
        <slot />
    </AppLayout>
</template>
