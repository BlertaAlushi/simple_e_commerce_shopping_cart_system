<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { products } from '@/routes';
import { type BreadcrumbItem, type Product } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import ProductC from '@/components/Product.vue';
import { ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: products().url,
    },
];

const props = defineProps<{
    products_array: {
        data: Product[];
        links: any[];
        meta?: any;
    };
    filters: {
        search?: string;
    };
}>();

const search = ref(props.filters.search || '');
watch(search, (value) => {
    router.get(
        products().url,
        { search: value },
        { preserveState: true, replace: true },
    );
});

const cart_products_quantity = ref(0);
function setCartProductQuantity(quantity: number) {
    cart_products_quantity.value = quantity;
}
</script>

<template>
    <Head title="Products" />

    <AppLayout
        :breadcrumbs="breadcrumbs"
        :cart_products_quantity="cart_products_quantity"
    >
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <input
                v-model="search"
                type="text"
                placeholder="Search products..."
                class="w-full rounded border px-3 py-2 mb-4"
            />

            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <ProductC
                    v-for="product in props.products_array.data"
                    :key="product.id"
                    :product="product"
                    @cartProductsQuantity="setCartProductQuantity"
                >
                </ProductC>
            </div>
            <div class="mt-6 flex gap-2">
                <button
                    v-for="link in props.products_array.links"
                    :key="link.label"
                    v-html="link.label"
                    :disabled="!link.url"
                    class="rounded border px-3 py-1"
                    :class="{ 'bg-gray-300': link.active }"
                    @click="link.url && router.visit(link.url)"
                />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
