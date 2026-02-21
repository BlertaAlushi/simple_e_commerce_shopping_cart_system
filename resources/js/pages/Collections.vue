<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import SideBarFilters from '@/components/SideBarFilters.vue';
import { type Filters, Product, type PageType } from '@/types';

const page = usePage<PageType>();

const props = defineProps<{
    products: {
        data: Product[];
    };
    filters: Filters;
}>();

const filterOptions = page.props.menu;
const { products, filters } = props;
</script>

<template>
    <Head title="Products" />
    <AppLayout>
        <div class="flex gap-6">
            <SideBarFilters :filters="filters" :filterOptions="filterOptions" />
            <main class="flex-1">
                <div v-for="product in products.data" :key="product.slug">
                    {{ product }}
                </div>
            </main>
        </div>
    </AppLayout>
</template>

<style scoped></style>
