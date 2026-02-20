<script setup lang="ts">
import AppLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem, Item } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { route } from 'ziggy-js';
import FormEditCreate from '@/components/FormEditCreate.vue';

const { t } = useI18n();
const props = defineProps<{
    body_part: Item;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: t('home.body_parts'), href: route('admin.body-parts.edit',props.body_part.slug) },
];

</script>

<template>
    <Head :title="t('home.new_body_part')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FormEditCreate page_name="body-parts" :item="body_part"></FormEditCreate>
    </AppLayout>
</template>
