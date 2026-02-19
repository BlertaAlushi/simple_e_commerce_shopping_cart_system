<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import SideBarFilters from '@/components/SideBarFilters.vue';
import { type Filters, FilterOptions } from '@/types';

const props = defineProps<{
    products: any[];
    filters: Filters;
    filterOptions: FilterOptions;
}>();

// Destructure to pass to sidebar
const { products, filters, filterOptions } = props;
</script>

<template>
    <Head title="Products" />
    <AppLayout>
        <div class="flex gap-6">
            <!-- Sidebar -->
            <SideBarFilters
                :filters="filters"
                :filterOptions="filterOptions"
            />
            <!-- Products list -->
            <main class="flex-1">

            </main>
        </div>
    </AppLayout>
</template>

<style scoped></style>
