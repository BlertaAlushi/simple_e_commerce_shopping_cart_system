<script setup lang="ts">
import { computed, defineEmits, defineProps } from 'vue';
import { Trash2 } from 'lucide-vue-next';
import { type CartProduct } from '@/types';

const props = defineProps<{
    cart_product: CartProduct;
}>();

const emit = defineEmits<{
    (e: 'removeCartProduct', id: number): void;
}>();

async function remove() {
    if (!props.cart_product.id) return;
    emit('removeCartProduct', props.cart_product.id);
}
const totalPrice = computed(() => {
    return props.cart_product.quantity * props.cart_product.product.price;
});
</script>

<template>
    <div
        class="flex flex-row justify-between gap-2 rounded-xl border border-gray-200 p-4 dark:border-gray-700"
    >
        <div>
            <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">
                {{ cart_product.quantity }} x {{ cart_product.product.name }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Price: {{ totalPrice }}
                {{ cart_product.product.currency }}
            </p>
        </div>

        <button
            @click="remove"
            class="mt-2 flex cursor-pointer items-center justify-between gap-2 text-red-500 hover:underline dark:text-red-400"
        >
            <Trash2 />
        </button>
    </div>
</template>

<style scoped>
/* Optional: You can add hover effects or shadows here */
</style>
