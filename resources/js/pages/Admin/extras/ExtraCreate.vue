<script setup lang="ts">
import AppLayout from '@/layouts/AdminLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head} from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { route } from 'ziggy-js'
import FormEditCreate from '@/components/Forms/FormEditCreate.vue';

const { t } = useI18n()

const breadcrumbs: BreadcrumbItem[] = [
    { title: t('home.extra'), href: route('admin.extras.create') },
]

</script>

<template>
    <Head :title="t('home.new_extra')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FormEditCreate page_name="extras"></FormEditCreate>
    </AppLayout>
</template>
