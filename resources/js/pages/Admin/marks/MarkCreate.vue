<script setup lang="ts">
import AppLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { route } from 'ziggy-js';
import FormMark from '@/components/Forms/FormMark.vue';

const { t } = useI18n();

const breadcrumbs: BreadcrumbItem[] = [
    { title: t('home.marks'), href: route('admin.marks.create') },
];
</script>

<template>
    <Head :title="t('home.new_mark')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FormMark page_name="marks"></FormMark>
    </AppLayout>
</template>
