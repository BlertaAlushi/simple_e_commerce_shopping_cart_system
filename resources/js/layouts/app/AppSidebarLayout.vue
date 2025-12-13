<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';
import { onMounted, ref, watch } from 'vue';
import axios from 'axios';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    cart_products_quantity?: number;
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    cart_products_quantity: 0,
});

const cart_products_count = ref(0);
async function loadCartQuantity() {
    const response = await axios.get('/cart-products-count');
    cart_products_count.value = response.data.cart_products_count;
}
watch(
    () => props.cart_products_quantity,
    (newVal: number) => {
        if (newVal !== undefined) {
            cart_products_count.value = newVal;
        }
    },
);
onMounted(() => loadCartQuantity());
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar :cart_products_count="cart_products_count" />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
    </AppShell>
</template>
