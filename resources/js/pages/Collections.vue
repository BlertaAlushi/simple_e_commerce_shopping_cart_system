<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import SideBarFilters from '@/components/SideBarFilters.vue';
import { type Filters, Product, type PageType } from '@/types';
import { reactive, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    Item,
    ItemContent,
    ItemDescription,
    ItemGroup,
    ItemHeader,
    ItemTitle,
} from '@/components/ui/item';

import {
    Empty,
    EmptyDescription,
    EmptyHeader,
    EmptyTitle,
} from '@/components/ui/empty';

import { useI18n } from 'vue-i18n';

const page = usePage<PageType>();

const { t } = useI18n();

const props = defineProps<{
    products: {
        data: Product[];
        meta: {
            links:any[]
        };
    };
    filters: Filters;
}>();

const filterOptions = page.props.menu;

const { products } = props;

const form = reactive<Filters>({
    skin_types: [...(props.filters.skin_types ?? [])],
    skin_concerns: [...(props.filters.skin_concerns ?? [])],
    product_types: [...(props.filters.product_types ?? [])],
    extras: [...(props.filters.extras ?? [])],
    order_by: props.filters.order_by ?? null,
    per_page: props.filters.per_page ?? null,
});

watch(
    form,
    () => {
        const query: Record<string, any> = {};

        Object.entries(form).forEach(([key, value]) => {
            if (Array.isArray(value)) {
                if (value.length > 0) query[key] = value;
            } else if (value != null && value !== '') {
                query[key] = value;
            }
        });

        router.get(window.location.pathname, query, {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        });
    },
    { deep: true },
);
</script>

<template>
    <Head title="Products" />
    <AppLayout>
        <div class="flex gap-x-14 p-8">
            <SideBarFilters
                :filters="form"
                :filterOptions="filterOptions"
                @update:filters="(update) => Object.assign(form, update)"
            />
            <main class="flex flex-1 flex-col gap-y-10">
                <div class="ml-auto flex gap-3">
                    <Select v-model="form.order_by">
                        <SelectTrigger class="w-45">
                            <SelectValue :placeholder="t('home.order_by')" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>{{
                                    t('home.order_by')
                                }}</SelectLabel>
                                <SelectItem value="availability">
                                    {{ t('home.availability') }}
                                </SelectItem>
                                <SelectItem value="price_high_to_low">
                                    {{ t('home.price_high_to_low') }}
                                </SelectItem>
                                <SelectItem value="price_low_to_high">
                                    {{ t('home.price_low_to_high') }}
                                </SelectItem>
                                <SelectItem value="date_new_to_old">
                                    {{ t('home.date_new_to_old') }}
                                </SelectItem>
                                <SelectItem value="date_old_to_new">
                                    {{ t('home.date_old_to_new') }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <Select v-model="form.per_page">
                        <SelectTrigger class="w-45">
                            <SelectValue
                                :placeholder="t('home.show_per_page')"
                            />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>{{
                                    t('home.show_per_page')
                                }}</SelectLabel>
                                <SelectItem value="12"> 12 </SelectItem>
                                <SelectItem value="24"> 24 </SelectItem>
                                <SelectItem value="48"> 48 </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div v-if="products.data.length" class="flex flex-col gap-6">
                    <div class="flex w-full max-w-xl flex-col gap-6">
                        <ItemGroup class="grid grid-cols-2 gap-4">
                            <Item
                                v-for="product in products.data"
                                :key="product.name"
                                variant="outline"
                                as-child
                                role="listitem"
                            >
                                <a href="#">
                                    <ItemHeader>
                                        <img
                                            :src="product.image"
                                            :alt="product.name"
                                            width="128"
                                            height="128"
                                            class="aspect-square w-full rounded-sm object-cover"
                                        />
                                    </ItemHeader>
                                    <ItemContent>
                                        <ItemTitle>{{
                                            product.name
                                        }}</ItemTitle>
                                        <ItemDescription
                                            >{{ product.price }}
                                            {{ product.currency }}
                                        </ItemDescription>
                                    </ItemContent>
                                </a>
                            </Item>
                        </ItemGroup>
                    </div>
                    <div class="ml-auto">
                        <button
                            v-for="link in props.products.meta.links"
                            :key="link.label"
                            v-html="link.label"
                            :disabled="!link.url"
                            class="rounded border px-3 py-1"
                            :class="{ 'bg-gray-300': link.active }"
                            @click="link.url && router.visit(link.url)"
                        />
                    </div>
                </div>
                <div v-else>
                    <Empty
                        class="h-full bg-linear-to-b from-muted/50 from-30% to-background"
                    >
                        <EmptyHeader>
                            <EmptyTitle>{{ t('home.no_products') }}</EmptyTitle>
                            <EmptyDescription>
                                {{ t('home.no_products_description') }}
                            </EmptyDescription>
                        </EmptyHeader>
                    </Empty>
                </div>
            </main>
        </div>
    </AppLayout>
</template>

<style scoped></style>
