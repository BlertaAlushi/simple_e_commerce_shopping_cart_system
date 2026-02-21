<script setup lang="ts">
import FormCreateEditProduct from '@/components/Forms/FormCreateEditProduct.vue';
import AppLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { route } from 'ziggy-js';

const { t } = useI18n();

const breadcrumbs: BreadcrumbItem[] = [
    { title: t('home.products'), href: route('admin.products.create') },
];
</script>

<template>
    <Head :title="t('home.new_product')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FormCreateEditProduct></FormCreateEditProduct>
    </AppLayout>
</template>
