<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { products } from '@/routes';
import { type BreadcrumbItem, type Product } from '@/types';
import { Head } from '@inertiajs/vue3';
import ProductC from '@/components/Product.vue';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: products().url,
    },
];

const props = defineProps<{
    products_array: Product[];
}>();

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
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <ProductC
                    v-for="product in props.products_array"
                    :key="product.id"
                    :product="product"
                    @cartProductsQuantity="setCartProductQuantity"
                >
                </ProductC>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
