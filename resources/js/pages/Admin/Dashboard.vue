<script setup lang="ts">
import AppLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem, type UserCart } from '@/types';
import { Head } from '@inertiajs/vue3';
import {route} from 'ziggy-js'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
];

defineProps<{
    orders: UserCart[] | [];
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative flex-1 gap-4 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                <p class="p-2 text-left text-sm">
                    Browse
                    <a href="/ProductsOld" class="text-blue-300"> Products </a> and
                    order your favorite ones.
                </p>
                <p class="p-2">Your orders:</p>
                <div
                    v-for="order in orders"
                    :key="order.id"
                    class="m-2 ml-0 flex flex-col justify-between gap-2 rounded-xl border border-gray-200 p-4 dark:border-gray-700"
                >
                    <div v-if="order.is_ordered">
                        <p class="text-left text-sm">
                            Order ID: {{ order.id }}
                        </p>
                        <p class="text-left text-sm">
                            Total price: {{ order.total_price }}
                            {{ order.products[0].product.currency }}
                        </p>
                        <p class="text-left text-sm">
                            Ordered at: {{ order.ordered_at }}
                        </p>
                    </div>
                    <div v-else>
                        <p class="p-2 text-left text-sm">
                            Order now products added to
                            <a href="/cart" class="text-blue-300">
                                shopping cart </a
                            >.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
