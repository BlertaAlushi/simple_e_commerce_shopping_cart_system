<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { defineProps, reactive, watch } from 'vue';
import { type Filters, FilterOptions, FilterOptionItem } from '@/types';
import { ChevronUp, ChevronDown } from 'lucide-vue-next';

// ---------------------------
// Props
// ---------------------------
const props = defineProps<{
    filterOptions: FilterOptions;
    filters: Filters;
}>();

// ---------------------------
// Reactive form (checkbox state)
// ---------------------------
const form = reactive<Filters>({
    skin_types: [...(props.filters.skin_types ?? [])],
    skin_concerns: [...(props.filters.skin_concerns ?? [])],
    product_types: [...(props.filters.product_types ?? [])],
    marks: [...(props.filters.marks ?? [])],
});

// ---------------------------
// Accordion open state
// ---------------------------
const openGroups = reactive<Record<keyof Filters, boolean>>({
    skin_types: true,
    skin_concerns: true,
    product_types: true,
    marks: true,
});

// ---------------------------
// Watch form changes -> GET request
// ---------------------------
watch(
    form,
    () => {
        router.get(window.location.pathname, form, {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        });
    },
    { deep: true },
);

// ---------------------------
// Filter groups array for looping
// ---------------------------
type FilterGroupKey = keyof Filters;

interface FilterGroup {
    key: FilterGroupKey;
    title: string;
    items: FilterOptionItem[];
}

const filterGroups: FilterGroup[] = [
    {
        key: 'skin_types',
        title: 'Skin Types',
        items: props.filterOptions.skinTypes,
    },
    {
        key: 'skin_concerns',
        title: 'Skin Concerns',
        items: props.filterOptions.skinConcerns,
    },
    {
        key: 'product_types',
        title: 'Product Types',
        items: props.filterOptions.productTypes,
    },
    {
        key: 'marks',
        title: 'Marks',
        items: props.filterOptions.marks },
];
</script>

<template>
    <aside class="sticky top-6 h-screen w-80 shrink-0 overflow-y-auto p-4">
        <div v-for="group in filterGroups" :key="group.key">
            <div v-if="group.items?.length" class="mb-4">
                <!-- Accordion toggle -->
                <button
                    @click="openGroups[group.key] = !openGroups[group.key]"
                    :class="[
                        'mb-3 flex w-full items-center justify-between pb-2 font-semibold',
                        openGroups[group.key] ? 'border-b-1 border-gray-900' : '',
                    ]"
                >
                    {{ group.title }}
                    <component
                        :is="openGroups[group.key] ? ChevronUp : ChevronDown"
                        class="h-4 w-4 transition-transform duration-200"
                    />
                </button>

                <!-- Checkbox list -->
                <div v-show="openGroups[group.key]" class="space-y-2 pl-2">
                    <label
                        v-for="item in group.items"
                        :key="item.id"
                        class="flex cursor-pointer items-center gap-2"
                    >
                        <input
                            type="checkbox"
                            :value="item.id"
                            v-model="form[group.key]"
                            class="h-4 w-4 accent-black"
                        />
                        <span class="text-sm">{{ item.translation.name }}</span>
                    </label>
                </div>
            </div>
        </div>
    </aside>
</template>

<style scoped>
aside {
    min-width: 250px;
}
button {
    cursor: pointer;
    transition: color 0.2s;
}
label input {
    cursor: pointer;
}
</style>
