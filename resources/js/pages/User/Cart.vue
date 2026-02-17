<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type UserCart } from '@/types';
import { Head } from '@inertiajs/vue3';
import CartProduct from '@/components/CartProduct.vue';
import { ref } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cart',
        href: route('cart'),
    },
];

const props = defineProps<{
    user_cart: UserCart | null;
}>();

const cart_products_quantity = ref(0);
const error = ref(false);
async function removeCartProduct(id: number) {
    if (!props.user_cart) return;
    try {
        const response = await axios.post('/remove-from-cart', {
            id: id,
            cart_id: props.user_cart.id,
        });
        if (response.data.success) {
            cart_products_quantity.value = response.data.cart_products_quantity;
            router.reload();
        }
    } catch (error) {
        console.log(error);
    }
}

async function order() {
    if (!props.user_cart) return;
    if (!props.user_cart.id) return;

    try {
        const response = await axios.post('/order-cart', {
            id: props.user_cart.id,
        });
        error.value = !response.data.success;
        if (response.data.success) {
            router.visit('/dashboard');
        }
    } catch (error) {
        console.log(error);
    }
}
</script>

<template>
    <Head title="Cart" />

    <AppLayout
        :breadcrumbs="breadcrumbs"
        :cart_products_quantity="cart_products_quantity"
    >
        <div
            v-if="user_cart && user_cart.products.length > 0"
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                v-if="error"
                class="w-1/5 rounded-lg border border-red-800 p-3 text-center text-red-800"
            >
                Order is not done!
            </div>
            <p class="text-md text-left">Your cart products:</p>
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <CartProduct
                    v-for="cart_product in user_cart.products"
                    :key="cart_product.id"
                    :cart_product="cart_product"
                    @removeCartProduct="removeCartProduct"
                >
                </CartProduct>
            </div>
            <p class="text-md text-left">
                Total price:
                <span class="font-bold"
                    >{{ user_cart.total_price }}
                    {{ user_cart.products[0].product.currency }}</span
                >
            </p>
            <button
                class="w-1/5 cursor-pointer rounded-lg bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700"
                @click="order"
            >
                Order
            </button>
        </div>
        <div
            v-else
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <p class="text-md text-left">Your cart is empty!</p>
            <p class="text-left text-sm">
                Browse
                <a href="/Admin/Products" class="text-blue-300"> Products </a> and
                select your favorite ones.
            </p>
        </div>
    </AppLayout>
</template>

<style scoped></style>
