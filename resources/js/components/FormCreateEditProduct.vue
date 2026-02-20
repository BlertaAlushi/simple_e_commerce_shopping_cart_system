<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsList, TabsTrigger, TabsContent } from '@/components/ui/tabs';

import type { Translation, Product } from '@/types';

interface FormData {
    slug: string;
    name: string;
    translations: Translation[];
    mark_id: number; // required
    body_parts: number[];
    skin_types: number[];
    skin_concerns: number[];
    extras: number[];
    product_types: number[];
}

const props = defineProps<{
    product?: Product;
    languages: { id: number; language: string }[];
    marks: { id: number; name: string }[];
    bodyParts: { id: number; name: string }[];
    skinTypes: { id: number; name: string }[];
    skinConcerns: { id: number; name: string }[];
    extras: { id: number; name: string }[];
    productTypes: { id: number; name: string }[];
}>();

const isEdit = !!props.product?.id;

// Prepare translations
const translationsArray: Translation[] = props.languages.map((lang) => {
    const existing = props.product?.translations?.find(
        (t: any) => t.language_id === lang.id
    );
    return {
        language_id: lang.id,
        name: existing?.name ?? '',
    };
});

// Initialize form
const form = useForm<FormData>({
    slug: props.product?.slug ?? '',
    name: props.product?.name ?? '',
    translations: translationsArray,
    mark_id: props.product?.mark_id ?? 0, // 0 = no mark selected yet
    body_parts: props.product?.body_parts?.map(b => b.id) ?? [],
    skin_types: props.product?.skin_types?.map(s => s.id) ?? [],
    skin_concerns: props.product?.skin_concerns?.map(s => s.id) ?? [],
    extras: props.product?.extras?.map(e => e.id) ?? [],
    product_types: props.product?.product_types?.map(p => p.id) ?? [],
});

// Submit
const submit = () => {
    if (form.mark_id === 0) {
        alert('Please select a Mark/Brand.');
        return;
    }

    if (isEdit) {
        form.put(route('admin.products.update', props.product.id));
    } else {
        form.post(route('admin.products.store'));
    }
};
</script>

<template>
    <Card class="mx-auto mt-10 w-full max-w-6xl">
        <CardHeader>
            <CardTitle>{{ isEdit ? 'Edit Product' : 'Create Product' }}</CardTitle>
        </CardHeader>

        <CardContent class="space-y-6">
            <!-- Default Name -->
            <div class="grid w-full items-center gap-1.5">
                <Label>Default Name</Label>
                <Input v-model="form.name" type="text" />
                <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
            </div>

            <!-- Slug -->
            <div v-if="isEdit" class="grid w-full items-center gap-1.5">
                <Label>Slug</Label>
                <Input v-model="form.slug" type="text" />
                <p v-if="form.errors.slug" class="text-sm text-red-500">{{ form.errors.slug }}</p>
            </div>

            <!-- Mark Select -->
            <div class="grid w-full max-w-sm items-center gap-1.5">
                <Label>Mark / Brand <span class="text-red-500">*</span></Label>
                <Select v-model="form.mark_id">
                    <SelectTrigger>
                        <SelectValue :placeholder="'Select a Mark'" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem :value="0" disabled>Select a Mark</SelectItem>
                        <SelectItem v-for="mark in props.marks" :key="mark.id" :value="mark.id">
                            {{ mark.name }}
                        </SelectItem>
                    </SelectContent>
                </Select>
                <p v-if="form.errors.mark_id" class="text-sm text-red-500">{{ form.errors.mark_id }}</p>
            </div>

            <!-- Translations -->
            <Tabs class="w-full">
                <TabsList>
                    <TabsTrigger v-for="lang in props.languages" :key="lang.id" :value="String(lang.id)">
                        {{ lang.language }}
                    </TabsTrigger>
                </TabsList>

                <TabsContent
                    v-for="(translation, index) in form.translations"
                    :key="translation.language_id"
                    :value="String(translation.language_id)"
                    class="mt-4"
                >
                    <div class="grid w-full items-center gap-1.5">
                        <Label>
                            Name ({{ props.languages.find((l) => l.id === translation.language_id)?.language }})
                        </Label>
                        <Input v-model="form.translations[index].name" />
                        <p
                            v-if="form.errors[`translations.${index}.name`]"
                            class="text-sm text-red-500"
                        >
                            {{ form.errors[`translations.${index}.name`] }}
                        </p>
                    </div>
                </TabsContent>
            </Tabs>

            <!-- Multi-Selects -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                <!-- Body Parts -->
                <div>
                    <Label class="font-semibold mb-2">Body Parts</Label>
                    <div class="grid grid-cols-2 gap-2">
                        <label v-for="part in props.bodyParts" :key="part.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="part.id" v-model="form.body_parts" />
                            <span>{{ part.name }}</span>
                        </label>
                    </div>
                </div>

                <!-- Skin Types -->
                <div>
                    <Label class="font-semibold mb-2">Skin Types</Label>
                    <div class="grid grid-cols-2 gap-2">
                        <label v-for="type in props.skinTypes" :key="type.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="type.id" v-model="form.skin_types" />
                            <span>{{ type.name }}</span>
                        </label>
                    </div>
                </div>

                <!-- Skin Concerns -->
                <div>
                    <Label class="font-semibold mb-2">Skin Concerns</Label>
                    <div class="grid grid-cols-2 gap-2">
                        <label v-for="concern in props.skinConcerns" :key="concern.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="concern.id" v-model="form.skin_concerns" />
                            <span>{{ concern.name }}</span>
                        </label>
                    </div>
                </div>

                <!-- Extras -->
                <div>
                    <Label class="font-semibold mb-2">Extras</Label>
                    <div class="grid grid-cols-2 gap-2">
                        <label v-for="extra in props.extras" :key="extra.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="extra.id" v-model="form.extras" />
                            <span>{{ extra.name }}</span>
                        </label>
                    </div>
                </div>

                <!-- Product Types -->
                <div>
                    <Label class="font-semibold mb-2">Product Types</Label>
                    <div class="grid grid-cols-2 gap-2">
                        <label v-for="ptype in props.productTypes" :key="ptype.id" class="flex items-center gap-2">
                            <input type="checkbox" :value="ptype.id" v-model="form.product_types" />
                            <span>{{ ptype.name }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end mt-6">
                <Button @click="submit" :disabled="form.processing">
                    {{ isEdit ? 'Update' : 'Create' }}
                </Button>
            </div>
        </CardContent>
    </Card>
</template>
