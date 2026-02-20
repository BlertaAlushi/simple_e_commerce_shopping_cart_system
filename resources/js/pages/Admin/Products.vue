<script setup lang="ts">
import AppLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem, type Product } from '@/types';
import { Head } from '@inertiajs/vue3';

import { route } from 'ziggy-js';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('admin.products'),
    },
];

const props = defineProps<{
    products_array: {
        data: Product[];
        links: any[];
        meta?: any;
    };
}>();

</script>

<template>
    <Head title="Products" />

    <AppLayout
        :breadcrumbs="breadcrumbs"
    >
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
        </div>
    </AppLayout>
</template>

<style scoped></style>
